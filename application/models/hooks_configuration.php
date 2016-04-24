<?php
class Hooks_configuration extends CI_Model 
{
	function save_global_config($batch_save_data)
	{
		return $this->db->insert('global_config',$batch_save_data);
	}
	
	function save_module_web_hooks($batch_module_save_data)
	{
		return $this->db->insert('module_web_hooks',$batch_module_save_data);
	}
	
	function save_global_key($batch_module_save_data)
	{
		return $this->db->insert('tbl_keys',$batch_module_save_data);
	}
	
	function update_module_web_hooks($batch_module_save_data , $module_hook_id)
	{
		$this->db->where('module_hook_id', $module_hook_id);
		return $this->db->update('module_web_hooks',$batch_module_save_data);
	}
		
	function count_main_all()
	{
		$this->db->from('global_config');
		$this->db->where('status', 1);
		return $this->db->count_all_results();
	}
	
	function get_all_main_configuration($limit=10000, $offset=0)
	{
		$this->db->from('global_config');
		$this->db->where('status',1);
		$this->db->order_by("global_id", "asc");
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();		
	}
	
	function count_module_all()
	{
		$this->db->from('module_web_hooks');
		$this->db->where('status', 1);
		return $this->db->count_all_results();
	}
	
	function get_all_hooks_module_configuration($limit=10000, $offset=0)
	{
		$this->db->from('module_web_hooks');
		$this->db->where('status',1);
		$this->db->order_by("module_name", "asc");
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();		
	}
	
	function get_all_hooks_module_keys($limit=10000, $offset=0)
	{
		$this->db->from('tbl_keys');
		$this->db->where('status',1);
		$this->db->order_by("key_id", "asc");
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();		
	}
	
	function get_search_hooks_module_suggestions($search,$limit=25)
	{
		$suggestions = array();
		$this->db->from('module_web_hooks');
		$this->db->where("(module_name LIKE '%".$this->db->escape_like_str($search)."%') or 
		(callout_event LIKE '%".$this->db->escape_like_str($search)."%') or (module_web_hooks_url LIKE '%".$this->db->escape_like_str($search)."%') and status=1");
		$this->db->order_by("module_name", "asc");	
		$this->db->distinct();
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->module_name.' '.$row->callout_event;		
		}

		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;
	}
	
	
	function search_module_hooks($search)
	{
		$this->db->from('module_web_hooks');
		$this->db->where("(CONCAT(`module_name`,' ',`callout_event`) LIKE '%".$this->db->escape_like_str($search)."%') and status=1");		
		$this->db->order_by("module_name", "asc");		
		return $this->db->get();	
	}
	
		/*
	Gets information about a particular customer
	*/
	function get_info($module_id)
	{
		$this->db->from('module_web_hooks');	
		$this->db->where('module_web_hooks.module_hook_id',$module_id);
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
			$fields = $this->db->list_fields('module_web_hooks');
			
			//append those fields to base parent object, we we have a complete empty object
			foreach ($fields as $field)
			{
				$person_obj->$field='';
			}
			
			return $person_obj;
		}
	}
	
		/*
	Deletes a list of customers
	*/
	function delete_list($module_ids)
	{
		$this->db->where_in('module_hook_id',$module_ids);
		$success = $this->db->update('module_web_hooks', array('status' => 0));
		return $success;
 	}
	
	function delete_key_list($key_ids)
	{
		$this->db->where_in('key_id',$key_ids);
		$success = $this->db->update('tbl_keys', array('status' => 0));
		return $success;
 	}
	
	function get_search_hooks_module_Keys_suggestions($search,$limit=25)
	{
		$suggestions = array();
		$this->db->from('tbl_keys');
		$this->db->where("(key_id LIKE '%".$this->db->escape_like_str($search)."%') or 
		(hash_code LIKE '%".$this->db->escape_like_str($search)."%') and status=1");
		$this->db->order_by("key_id", "asc");	
		$this->db->distinct();
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->key_id.' '.$row->hash_code;		
		}

		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;
	}
	
		
	function search_module_hooks_keys($search)
	{
		$this->db->from('tbl_keys');
		$this->db->where("(CONCAT(`key_id`,' ',`hash_code`) LIKE '%".$this->db->escape_like_str($search)."%') and status=1");		
		$this->db->order_by("key_id", "asc");		
		return $this->db->get();	
	}

}
?>