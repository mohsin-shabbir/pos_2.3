<?php
require_once ("secure_area.php");
class Web_hooks extends Secure_area 
{
	function __construct()
	{
		parent::__construct('config');
	}
	
	function index()
	{
		$this->load->view("web_hooks");
	}
	
	function save_web_hooks()
	{
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');
		$this->form_validation->set_rules('callout', 'Callout', 'required');
		$this->form_validation->set_rules('url', 'URL', 'required');
		$this->form_validation->set_rules('error_email', 'email', 'required|valid_email');
		$this->form_validation->set_rules('is_secure', 'security', 'required');
		if($this->input->post('is_secure') == 1)
		{
			$this->form_validation->set_rules('authorization_token', 'Authentication token', 'required');
			$this->form_validation->set_rules('authorization_username', 'Authentication username', 'required');
			$this->form_validation->set_rules('authorization_password', 'Authentication password', 'required');
		}

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('web_hooks');
		}
		else
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
			$this->load->model('Web_hooks');
			if($this->Web_hooks->save_global_config($batch_save_data))
			{
				$data['msg'] = "Your record has been saved successfully.";
			}
			else
			{
				$data['msg'] = "Sorry we cannot save your record.";
			}
			$this->load->view('web_hooks' , $data);
		}
		
	}

}
?>