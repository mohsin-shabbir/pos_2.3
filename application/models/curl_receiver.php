<?php
class Curl_receiver extends CI_Model 
{
	/*function insertPayment($batch_save_data)
	{
		return $this->db->insert('global_config',$batch_save_data);
	}*/
	
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
			return true;		
		}

		
	}

}
?>