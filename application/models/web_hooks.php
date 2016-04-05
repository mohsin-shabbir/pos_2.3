<?php
class Web_hooks extends CI_Model 
{
	function save_global_config($batch_save_data)
	{
		return $this->db->insert('global_config',$batch_save_data);
	}

}
?>