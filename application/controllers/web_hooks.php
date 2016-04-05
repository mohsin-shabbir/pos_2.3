<?php
require_once ("secure_area.php");
class Web_hooks extends Secure_area 
{
	function __construct()
	{
		//parent::__construct('config');
	}
	
	function index()
	{
		$this->load->view("web_hooks", $data);
	}
		
	function save()
	{
		$batch_save_data=array(
		'callout'=>$this->input->post('callout'),
		'url'=>$this->input->post('url'),
		'error_email'=>$this->input->post('error_email'),
		'is_secure'=>$this->input->post('is_secure'),
		'authorization_token'=>$this->input->post('authorization_token'),
		'authorization_username'=>$this->input->post('authorization_username'),
		'authorization_password'=>$this->input->post('authorization_password')
		);
		$this->load->model('web_hooks');
		if($this->Web_hooks->save_global_config($batch_save_data))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('config_saved_successfully')));
		}
	}
}
?>