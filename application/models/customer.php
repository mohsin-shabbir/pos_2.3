
<?php
class Customer extends Person
{	
	/*
	Determines if a given person_id is a customer
	*/
	function exists($person_id)
	{
		$this->db->from('customers');	
		$this->db->join('people', 'people.person_id = customers.person_id');
		$this->db->where('customers.person_id',$person_id);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}
	
	/*
	Returns all the customers
	*/
	
	function get_all($limit=10000, $offset=0)
	{
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');			
		$this->db->where('deleted',0);
		$this->db->order_by("last_name", "asc");
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();		
	}
	function get_all_customers()
	{
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');			
		$this->db->where('deleted',0);
		$this->db->order_by("last_name", "asc");
		return $this->db->get()->result();		
	}
	
	function count_all()
	{
		$this->db->from('customers');
		$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}
	
	/*
	Gets information about a particular customer
	*/
	function get_info($customer_id)
	{
		$this->db->from('customers');	
		$this->db->join('people', 'people.person_id = customers.person_id');
		$this->db->where('customers.person_id',$customer_id);
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $customer_id is NOT an customer
			$person_obj=parent::get_info(-1);
			
			//Get all the fields from customer table
			$fields = $this->db->list_fields('customers');
			
			//append those fields to base parent object, we we have a complete empty object
			foreach ($fields as $field)
			{
				$person_obj->$field='';
			}
			
			return $person_obj;
		}
	}
	
	/*
	Gets information about multiple customers
	*/
	function get_multiple_info($customer_ids)
	{
		$this->db->from('customers');
		$this->db->join('people', 'people.person_id = customers.person_id');		
		$this->db->where_in('customers.person_id',$customer_ids);
		$this->db->order_by("last_name", "asc");
		return $this->db->get();		
	}
	
	/*
	Inserts or updates a customer
	*/
	function save(&$person_data, &$customer_data,$customer_id=false)
	{
		$success=false;
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		if(parent::save($person_data,$customer_id))
		{
			if (!$customer_id or !$this->exists($customer_id))
			{
				$customer_data['person_id'] = $person_data['person_id'];
				$success = $this->db->insert('customers',$customer_data);						
			}
			else
			{
				$this->db->where('person_id', $customer_id);
				$success = $this->db->update('customers',$customer_data);				
			}
			
		}
		
		$this->db->trans_complete();
		if($success)
		{
			$customer_save_data = array();
			$customer_save_data['path'] = "insertPayment";
			$customer_save_data['customer_id'] = $customer_id;
			$customer_save_data['person_data'] = $person_data;
			$customer_save_data['customer_data'] = $customer_data;
			$this->common_lib->sendToThirdParty($customer_save_data);	
		}		
		return $success;
	}
	
	/*
	Deletes one customer
	*/
	function delete($customer_id)
	{
		$this->db->where('person_id', $customer_id);
		$success =  $this->db->update('customers', array('deleted' => 1));
		if($success)
		{
			$customer_save_data['path'] = "deleteCustomer";
			$customer_save_data['customer_id'] = $customer_id;
			$this->common_lib->sendToThirdParty($customer_save_data);	
		}
		return $success;
	}
	
	/*
	Deletes a list of customers
	*/
	function delete_list($customer_ids)
	{
		$this->db->where_in('person_id',$customer_ids);
		$success = $this->db->update('customers', array('deleted' => 1));
		if($success)
		{
			$customer_save_data['path'] = "deleteCustomersList";
			$customer_save_data['customer_id'] = $customer_id;
			$this->common_lib->sendToThirdParty($customer_ids);	
		}
		return $success;
 	}
 	
 	/*
	Get search suggestions to find customers
	*/
	function get_search_suggestions($search,$limit=25)
	{
		$suggestions = array();
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->where("(first_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		last_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");
		$this->db->order_by("last_name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->first_name.' '.$row->last_name;		
		}
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->where('deleted',0);		
		$this->db->like("email",$search);
		$this->db->order_by("email", "asc");		
		$by_email = $this->db->get();
		foreach($by_email->result() as $row)
		{
			$suggestions[]=$row->email;		
		}

		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->where('deleted',0);		
		$this->db->like("phone_number",$search);
		$this->db->order_by("phone_number", "asc");		
		$by_phone = $this->db->get();
		foreach($by_phone->result() as $row)
		{
			$suggestions[]=$row->phone_number;		
		}
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->where('deleted',0);		
		$this->db->like("account_number",$search);
		$this->db->order_by("account_number", "asc");		
		$by_account_number = $this->db->get();
		foreach($by_account_number->result() as $row)
		{
			$suggestions[]=$row->account_number;		
		}
		
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;
	}
	
	/*
	Get search suggestions to find customers
	*/
	function get_customer_search_suggestions($search,$limit=25)
	{
		$suggestions = array();
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->where("(first_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		last_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");
		$this->db->order_by("last_name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->person_id.'|'.$row->first_name.' '.$row->last_name;		
		}
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->where('deleted',0);		
		$this->db->like("account_number",$search);
		$this->db->order_by("account_number", "asc");		
		$by_account_number = $this->db->get();
		foreach($by_account_number->result() as $row)
		{
			$suggestions[]=$row->person_id.'|'.$row->account_number;
		}

		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
	/*
	Preform a search on customers
	*/
	function search($search)
	{
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');		
		$this->db->where("(first_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		last_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		email LIKE '%".$this->db->escape_like_str($search)."%' or 
		phone_number LIKE '%".$this->db->escape_like_str($search)."%' or 
		account_number LIKE '%".$this->db->escape_like_str($search)."%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");		
		$this->db->order_by("last_name", "asc");
		
		return $this->db->get();	
	}
	/////////////////////////////////Logs Data Start From here////////////////////////
	function get_all_logs($limit=10000, $offset=0)
	{
		$this->db->from('tbl_logs');
		$this->db->join('people','tbl_logs.employee_id = people.person_id');			
		$this->db->where('status',1);
		$this->db->order_by("log_id", "asc");
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();		
	}

	
	
	function search_log($search)
	{
		$this->db->from('tbl_logs');
		$this->db->join('people','tbl_logs.employee_id = people.person_id');		
		$this->db->where("(log_id LIKE '%".$this->db->escape_like_str($search)."%' or 
		module_id LIKE '%".$this->db->escape_like_str($search)."%' or 
		first_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		last_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		module_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		action_time LIKE '%".$this->db->escape_like_str($search)."%' or 
		employee_id LIKE '%".$this->db->escape_like_str($search)."%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and status=1");		
		$this->db->order_by("log_id", "asc");		
		return $this->db->get();	
	}
	
	function search_log_date($toDate , $fromDate )
	{
		$to = date("Y-m-d", strtotime($toDate));
		$from = date("Y-m-d", strtotime($fromDate));
		$this->db->from('tbl_logs');
		$this->db->join('people','tbl_logs.employee_id = people.person_id');		
		$this->db->where("action_time BETWEEN '".$to."' AND  '".$from."' and status=1");		
		$this->db->order_by("log_id", "asc");		
		return $this->db->get();	
	}
	
	
	
	function get_search_log_suggestions($search,$limit=25)
	{
		$suggestions = array();
		$this->db->from('tbl_logs');
		$this->db->join('people','tbl_logs.employee_id = people.person_id');	
		$this->db->where("(first_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		last_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and status=1");
		$this->db->order_by("log_id", "asc");	
		$this->db->distinct();
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->first_name.' '.$row->last_name;		
		}
		
		$this->db->from('tbl_logs');
		$this->db->join('people','tbl_logs.employee_id = people.person_id');	
		$this->db->where('status',1);		
		$this->db->like("module_name",$search);
		$this->db->order_by("module_name", "asc");	
		$this->db->distinct();	
		$by_email = $this->db->get();
		foreach($by_email->result() as $row)
		{
			$suggestions[]=$row->module_name;			
		}

		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;
	}
	
	
}
?>
