<?php
class Sale extends CI_Model
{
	function __construct()
	{
		$this->load->library('common_lib');
	}
	public function get_info($sale_id)
	{
		$this->db->from('sales');
		$this->db->join('people', 'people.person_id = sales.customer_id', 'LEFT');
		$this->db->where('sale_id',$sale_id);
		return $this->db->get();
	}
	
	function get_invoice_count()
	{
		$this->db->from('sales');
		$this->db->where('invoice_number is not null');
		return $this->db->count_all_results();
	}
	
	function get_sale_by_invoice_number($invoice_number)
	{
		$this->db->from('sales');
		$this->db->where('invoice_number', $invoice_number);
		return $this->db->get();
	}

	function exists($sale_id)
	{
		$this->db->from('sales');
		$this->db->where('sale_id',$sale_id);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}
	
	function update($sale_data, $sale_id)
	{
		$this->db->where('sale_id', $sale_id);
		$success = $this->db->update('sales',$sale_data);
		
		return $success;
	}
	
	function save ($items,$customer_id,$employee_id,$comment,$invoice_number,$payments,$sale_id=false)
	{
		if(count($items)==0)
			return -1;

		//Alain Multiple payments
		//Build payment types string
		$payment_types='';
		foreach($payments as $payment_id=>$payment)
		{
			$payment_types=$payment_types.$payment['payment_type'].': '.to_currency($payment['payment_amount']).'<br />';
		}

		$sales_data = array(
			'sale_time' => date('Y-m-d H:i:s'),
			'customer_id'=> $this->Customer->exists($customer_id) ? $customer_id : null,
			'employee_id'=>$employee_id,
			'payment_type'=>$payment_types,
			'comment'=>$comment,
			'invoice_number'=>$invoice_number
		);

		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();

		$this->db->insert('sales',$sales_data);
		$sale_id = $this->db->insert_id();

		foreach($payments as $payment_id=>$payment)
		{
			if ( substr( $payment['payment_type'], 0, strlen( $this->lang->line('sales_giftcard') ) ) == $this->lang->line('sales_giftcard') )
			{
				/* We have a gift card and we have to deduct the used value from the total value of the card. */
				$splitpayment = explode( ':', $payment['payment_type'] );
				$cur_giftcard_value = $this->Giftcard->get_giftcard_value( $splitpayment[1] );
				$this->Giftcard->update_giftcard_value( $splitpayment[1], $cur_giftcard_value - $payment['payment_amount'] );
			}

			$sales_payments_data = array
			(
				'sale_id'=>$sale_id,
				'payment_type'=>$payment['payment_type'],
				'payment_amount'=>$payment['payment_amount'],
				'is_received'=>$payment['is_received']
			);
			$this->db->insert('sales_payments',$sales_payments_data);
		}

		foreach($items as $line=>$item)
		{
			$cur_item_info = $this->Item->get_info($item['item_id']);

			$sales_items_data = array
			(
				'sale_id'=>$sale_id,
				'item_id'=>$item['item_id'],
				'line'=>$item['line'],
				'description'=>$item['description'],
				'serialnumber'=>$item['serialnumber'],
				'quantity_purchased'=>$item['quantity'],
				'discount_percent'=>$item['discount'],
				'item_cost_price' => $cur_item_info->cost_price,
				'item_unit_price'=>$item['price'],
				'item_location'=>$item['item_location']
			);

			$this->db->insert('sales_items',$sales_items_data);

			//Update stock quantity
			$item_quantity = $this->Item_quantities->get_item_quantity($item['item_id'], $item['item_location']);       
            $this->Item_quantities->save(array('quantity'=>$item_quantity->quantity - $item['quantity'],
                                              'item_id'=>$item['item_id'],
                                              'location_id'=>$item['item_location']), $item['item_id'], $item['item_location']);
	
			
			//Ramel Inventory Tracking
			//Inventory Count Details
			$qty_buy = -$item['quantity'];
			$sale_remarks ='POS '.$sale_id;
			$inv_data = array
			(
				'trans_date'=>date('Y-m-d H:i:s'),
				'trans_items'=>$item['item_id'],
				'trans_user'=>$employee_id,
				'trans_location'=>$item['item_location'],
				'trans_comment'=>$sale_remarks,
				'trans_inventory'=>$qty_buy
			);
			$this->Inventory->insert($inv_data);
			//------------------------------------Ramel

			$customer = $this->Customer->get_info($customer_id);
 			if ($customer_id == -1 or $customer->taxable)
 			{
				foreach($this->Item_taxes->get_info($item['item_id']) as $row)
				{
					$this->db->insert('sales_items_taxes', array(
						'sale_id' 	=>$sale_id,
						'item_id' 	=>$item['item_id'],
						'line'      =>$item['line'],
						'name'		=>$row['name'],
						'percent' 	=>$row['percent']
					));
				}
			}
		}
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			return -1;
		}
		
		return $sale_id;
	}
	
	function delete_list($sale_ids, $employee_id,$update_inventory=TRUE) 
	{
		$result = TRUE;
		foreach($sale_ids as $sale_id) {
			$result &= $this->delete($sale_id, $employee_id, $update_inventory);
		}
		return $result;
	}
	
	function delete($sale_id,$employee_id,$update_inventory=TRUE) 
	{
		// start a transaction to assure data integrity
		$this->db->trans_start();
		// first delete all payments
		$this->db->delete('sales_payments', array('sale_id' => $sale_id));
		// then delete all taxes on items
		$this->db->delete('sales_items_taxes', array('sale_id' => $sale_id));
		if ($update_inventory) {
			// defect, not all item deletions will be undone??
			// get array with all the items involved in the sale to update the inventory tracking
			$items = $this->get_sale_items($sale_id)->result_array();
			foreach($items as $item) {
				// create query to update inventory tracking
				$inv_data = array
				(
						'trans_date'=>date('Y-m-d H:i:s'),
						'trans_items'=>$item['item_id'],
						'trans_user'=>$employee_id,
						'trans_comment'=>'Deleting sale ' . $sale_id,
						'trans_inventory'=>$item['quantity_purchased']
	
				);
				// update inventory
				$this->Inventory->insert($inv_data);
			}
		}
		// delete all items
		$this->db->delete('sales_items', array('sale_id' => $sale_id));
		// delete sale itself
		$this->db->delete('sales', array('sale_id' => $sale_id));
		// execute transaction
		$this->db->trans_complete();
	
		return $this->db->trans_status();
	}

	function get_sale_items($sale_id)
	{
		$this->db->from('sales_items');
		$this->db->where('sale_id',$sale_id);
		return $this->db->get();
	}

	function get_sale_payments($sale_id)
	{
		$this->db->from('sales_payments');
		$this->db->where('sale_id',$sale_id);
		return $this->db->get();
	}

	function get_customer($sale_id)
	{
		$this->db->from('sales');
		$this->db->where('sale_id',$sale_id);
		return $this->Customer->get_info($this->db->get()->row()->customer_id);
	}
	
	function invoice_number_exists($invoice_number,$sale_id='')
	{
		$this->db->from('sales');
		$this->db->where('invoice_number', $invoice_number);
		if (!empty($sale_id))
		{
			$this->db->where('sale_id !=', $sale_id);
		}
		$query=$this->db->get();
		return ($query->num_rows()==1);
	}

	//We create a temp table that allows us to do easy report/sales queries
	public function create_sales_items_temp_table()
	{
		$this->db->query("DROP TABLE IF EXISTS phppos_sales_items_temp");
		$this->db->query("CREATE TEMPORARY TABLE ".$this->db->dbprefix('sales_items_temp')."
		(SELECT date(sale_time) as sale_date, sale_time, ".$this->db->dbprefix('sales_items').".sale_id, comment,payments.payment_type, customer_id, employee_id, 
		".$this->db->dbprefix('items').".item_id, supplier_id, quantity_purchased, item_cost_price, item_unit_price, SUM(percent) as item_tax_percent,
		discount_percent, (item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100) as subtotal,
		".$this->db->dbprefix('sales_items').".line as line, serialnumber, ".$this->db->dbprefix('sales_items').".description as description,
		(item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)*(1+(SUM(percent)/100)) as total,
		(item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)*(SUM(percent)/100) as tax,
		(item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100) - (item_cost_price*quantity_purchased) as profit
		FROM ".$this->db->dbprefix('sales_items')."
		INNER JOIN ".$this->db->dbprefix('sales')." ON  ".$this->db->dbprefix('sales_items').'.sale_id='.$this->db->dbprefix('sales').'.sale_id'."
		INNER JOIN ".$this->db->dbprefix('items')." ON  ".$this->db->dbprefix('sales_items').'.item_id='.$this->db->dbprefix('items').'.item_id'."
		INNER JOIN (SELECT sale_id, SUM(payment_amount) AS sale_payment_amount, 
		GROUP_CONCAT(payment_type SEPARATOR ', ') AS payment_type FROM " .$this->db->dbprefix('sales_payments') . " 
		WHERE payment_type <> '" . $this->lang->line('sales_check') . "' GROUP BY sale_id) AS payments 
		ON " . $this->db->dbprefix('sales_items') . '.sale_id'. "=" . "payments.sale_id		
		LEFT OUTER JOIN ".$this->db->dbprefix('suppliers')." ON  ".$this->db->dbprefix('items').'.supplier_id='.$this->db->dbprefix('suppliers').'.person_id'."
		LEFT OUTER JOIN ".$this->db->dbprefix('sales_items_taxes')." ON  "
		.$this->db->dbprefix('sales_items').'.sale_id='.$this->db->dbprefix('sales_items_taxes').'.sale_id'." and "
		.$this->db->dbprefix('sales_items').'.item_id='.$this->db->dbprefix('sales_items_taxes').'.item_id'." and "
		.$this->db->dbprefix('sales_items').'.line='.$this->db->dbprefix('sales_items_taxes').'.line'."
		GROUP BY sale_id, item_id, line)");

		//Update null item_tax_percents to be 0 instead of null
		$this->db->where('item_tax_percent IS NULL');
		$this->db->update('sales_items_temp', array('item_tax_percent' => 0));

		//Update null tax to be 0 instead of null
		$this->db->where('tax IS NULL');
		$this->db->update('sales_items_temp', array('tax' => 0));

		//Update null subtotals to be equal to the total as these don't have tax
		$this->db->query('UPDATE '.$this->db->dbprefix('sales_items_temp'). ' SET total=subtotal WHERE total IS NULL');
	}
	
	public function get_giftcard_value( $giftcardNumber )
	{
		if ( !$this->Giftcard->exists( $this->Giftcard->get_giftcard_id($giftcardNumber)))
			return 0;
		
		$this->db->from('giftcards');
		$this->db->where('giftcard_number',$giftcardNumber);
		return $this->db->get()->row()->value;
	}
	public function getReceivedPayments($sale_id)
	{		
		///echo 'MM';
		//$this->db->select('(SELECT sale_id ,  SUM(payment_amount) as totalAmount FROM ospos_sales_payments WHERE sale_id = '.$sale_id.'', FALSE); 
		//echo "SELECT sale_id ,  SUM(payment_amount) as totalAmount FROM ospos_sales_payments WHERE sale_id = '".$sale_id."'";
		//echo "SELECT sale_id ,  SUM(payment_amount) as paidAmount FROM ospos_sales_payments WHERE sale_id = '".$sale_id."' AND is_received = 1";
		$balance = '';
		$totalAmount = 0;
		$result2 = $this->db->get_where('ospos_sales_items' , array('sale_id'=>$sale_id))->result();
		foreach($result2 as $result)
		{
			if(isset($result->discount_percent) && $result->discount_percent != '0.00')
			{
				$unitPriceDiffrence = ($result->item_unit_price*$result->discount_percent)/100;
				$unitPrice = $result->item_unit_price - $unitPriceDiffrence;
			}
			else
			{
				$unitPrice = $result->item_unit_price;
			}
			$totalAmount = $unitPrice + $totalAmount;
		}
		
		$totalOtherThanSalesCredit = mysql_fetch_array(mysql_query("SELECT sale_id ,  SUM(payment_amount) as totalOtherThanSalesCredit FROM ospos_sales_payments WHERE sale_id = '".$sale_id."' AND payment_type != 'Received Payment'"));
				
		$totalReceived = mysql_fetch_array(mysql_query("SELECT sale_id ,  SUM(payment_amount) as totalReceived FROM ospos_sales_payments WHERE sale_id = '".$sale_id."' AND payment_type = 'Received Payment'"));
		
		$totalCreditSales = mysql_fetch_array(mysql_query("SELECT sale_id ,  SUM(payment_amount) as totalCreditSales FROM ospos_sales_payments WHERE sale_id = '".$sale_id."' AND payment_type = 'Sales Credit'"));
			
		$grandTotalOtherThanSalesCredit = $totalAmount - $totalCreditSales['totalCreditSales'];
		if($totalReceived['totalReceived'] >= $totalCreditSales['totalCreditSales'])
		{
			$creditReceivedBalance = $totalReceived['totalReceived']- $totalCreditSales['totalCreditSales'];
		}
		else
		{
			$creditReceivedBalance = $totalCreditSales['totalCreditSales'] - $totalReceived['totalReceived'];
			$creditReceivedBalance = '-'.$creditReceivedBalance;
		}
		//echo 'total received '.$totalReceived['totalReceived'].'<br>';
		//echo 'total credit sales '.$totalCreditSales['totalCreditSales'].'<br>';
		//echo 'received sales balance '.$creditReceivedBalance.'<br>';
		
		if($totalOtherThanSalesCredit['totalOtherThanSalesCredit'] >= $totalAmount)
		{
			$otherBalance = $totalOtherThanSalesCredit['totalOtherThanSalesCredit']- $totalAmount;
		}
		else
		{
			$otherBalance = $totalAmount - $totalOtherThanSalesCredit['totalOtherThanSalesCredit'];
			$otherBalance = '-'.$otherBalance;
		}
		
		$balance = ($creditReceivedBalance) + ($otherBalance);
		//echo $balance;
		if($balance > 0)
		{
			/////Update Customet Balance///////
			mysql_query("UPDATE ospos_sales SET sales_balance = '".$balance."' WHERE sale_id = '".$sale_id."'");
			$selectCustomer = mysql_query("SELECT * FROM ospos_sales WHERE sale_id = '".$sale_id."'");
			$fetchRow = mysql_fetch_array($selectCustomer);
			if(!is_null($fetchRow['customer_id']))
			{
				$selectBalance = mysql_fetch_array(mysql_query("SELECT sum(sales_balance) as balance from ospos_sales WHERE customer_id = '".$fetchRow['customer_id']."'"));
				mysql_query("UPDATE ospos_customers SET balance = '".$selectBalance['balance']."' WHERE person_id = '".$fetchRow['customer_id']."'");	
			
			}
		}
		$query2 = mysql_fetch_array(mysql_query("SELECT sale_id ,  SUM(payment_amount) as paidAmount FROM ospos_sales_payments WHERE sale_id = '".$sale_id."' AND is_received = 1"));
		$result1 = $this->db->get_where('ospos_sales_payments' , array('sale_id'=>$sale_id))->result();
		$data['payments'] = $result1;
		$data['balance'] = $balance;
		return $data;
	/*	
		$this->db->select('sale_id , sum(payment_amount) as totalAmount' , false);
		$this->db->from('ospos_sales_payments');
		$result2 = $this->db->get_where('sale_id',$sale_id);
		print_r($result2);*/
	}
	function insertPayment($sale_id , $payment_amount)
	{
		
		$sales_payments_data = array
			(
				'sale_id'=>$sale_id,
				'payment_type'=> 'Received Payment',
				'payment_amount'=> $payment_amount,
				'is_received'=>1//$inputArray['is_received']
			);
		$updateAmount = '';
		$case = '';
		$selectPaymentType = mysql_query("SELECT * FROM ospos_sales_payments WHERE payment_type = 'Received Payment' AND sale_id = '".$sale_id."'");
		if(mysql_num_rows($selectPaymentType) > 0)
		{
			$amount = mysql_fetch_array(mysql_query("SELECT sum(payment_amount) AS paymentAmount FROM ospos_sales_payments WHERE payment_type = 'Received Payment' AND sale_id = '".$sale_id."'"));
			$updateAmount = $amount['paymentAmount']+$payment_amount;
			if(mysql_query("UPDATE ospos_sales_payments SET payment_amount = '".$updateAmount."' WHERE payment_type = 'Received Payment' AND sale_id = '".$sale_id."'"))
			{	$module_id = $sale_id; }
			$case = "update";
			
		}
		else
		{
				$this->db->insert('ospos_sales_payments',$sales_payments_data);
				$module_id = $this->db->insert_id();
				$case = "insert";
		}
		if($module_id != '')
		{
					///$this->load->library('common_lib');
			$sales_payments_data['path'] = "insertPayment";
			$sales_payments_data['updated_amount'] = $updateAmount;
			$this->common_lib->sendToThirdParty($sales_payments_data);			
		}
		$this->getReceivedPayments($sale_id);
		return $module_id;
		
	}
	
	function insertCurlPayment($sale_id , $payment_amount)
	{
		
		$sales_payments_data = array
			(
				'sale_id'=>$sale_id,
				'payment_type'=> 'Received Payment',
				'payment_amount'=> $payment_amount,
				'is_received'=>1//$inputArray['is_received']
			);
		$updateAmount = '';
		$case = '';
		$selectPaymentType = mysql_query("SELECT * FROM ospos_sales_payments WHERE payment_type = 'Received Payment' AND sale_id = '".$sale_id."'");
		if(mysql_num_rows($selectPaymentType) > 0)
		{
			$amount = mysql_fetch_array(mysql_query("SELECT sum(payment_amount) AS paymentAmount FROM ospos_sales_payments WHERE payment_type = 'Received Payment' AND sale_id = '".$sale_id."'"));
			$updateAmount = $amount['paymentAmount']+$payment_amount;
			if(mysql_query("UPDATE ospos_sales_payments SET payment_amount = '".$updateAmount."' WHERE payment_type = 'Received Payment' AND sale_id = '".$sale_id."'"))
			{	$module_id = $sale_id; }
			$case = "update";
			
		}
		else
		{
				$this->db->insert('ospos_sales_payments',$sales_payments_data);
				$module_id = $this->db->insert_id();
				$case = "insert";
		}
		if($module_id != '')
		{
			return true;		
		}

		
	}

}
?>
