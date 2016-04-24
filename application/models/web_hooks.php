<?php
class Web_hooks extends CI_Model 
{
	function save_global_config($batch_save_data)
	{
		return $this->db->insert('global_config',$batch_save_data);
	}
	
	function save_module_web_hooks($batch_module_save_data)
	{
		return $this->db->insert('module_web_hooks',$batch_module_save_data);
	}

}
?>