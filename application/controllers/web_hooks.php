<?php
require_once ("secure_area.php");
class Web_hooks extends Secure_area 
{
	function __construct()
	{
		parent::__construct('config');
		$this->load->model('Hooks_configuration');
	}
	
	function index()
	{
		$this->load->view("web_hooks");
	}
	
	function show_main_configuration()
	{
		
		$config['base_url'] = site_url('/web_hooks/index');
		$config['total_rows'] = $this->Hooks_configuration->count_main_all();
		$config['per_page'] = '20';
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['manage_table']= get_main_web_hooks_table($this->Hooks_configuration->get_all_main_configuration( $config['per_page'], $this->uri->segment( $config['uri_segment'] ) ), $this );
		$this->load->view('people/main_config',$data);
	}
	
	function show_module_configuration()
	{
		
		$config['base_url'] = site_url('/web_hooks/index');
		$config['total_rows'] = $this->Hooks_configuration->count_module_all();
		$config['per_page'] = '20';
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['manage_table']= get_module_web_hooks_table($this->Hooks_configuration->get_all_hooks_module_configuration( $config['per_page'], $this->uri->segment( $config['uri_segment'] ) ), $this );
		$this->load->view('people/hooks_modules_config',$data);
	}
	
	function show_keys()
	{
		$config['base_url'] = site_url('/web_hooks/index');
		$config['total_rows'] = $this->Hooks_configuration->count_module_all();
		$config['per_page'] = '20';
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['manage_table']= get_module_web_hooks_keys_table($this->Hooks_configuration->get_all_hooks_module_keys( $config['per_page'], $this->uri->segment( $config['uri_segment'] ) ), $this );
		$this->load->view('people/hooks_keys',$data);
	}
	
	function get_form_width()
	{			
		return 350;
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
			$data["msg2"] = "Fileds with red label are required.";
			$this->load->view('web_hooks' , $data);
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
			
			if($this->Hooks_configuration->save_global_config($batch_save_data))
			{
				$data['msg1'] = "Your record has been saved successfully.";
			}
			else
			{
				$data['msg1'] = "Sorry we cannot save your record.";
			}
			$this->load->view('web_hooks' , $data);
		}
		
	}
	
	function save_module_web_hooks()
	{
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');
		$this->form_validation->set_rules('module_name', 'Module Name', 'required');
		$this->form_validation->set_rules('callout_event', 'Callout Event', 'required');  
		$this->form_validation->set_rules('module_web_hooks_url', 'Callout URL', 'required');
		$this->form_validation->set_rules('module_is_secure', 'security', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data["msg3"] = "Fileds with red label are required.";
			$this->load->view('web_hooks' , $data);
		}
		else
		{
			$batch_save_data=array(
			'module_name'=>$this->input->post('module_name'),
			'callout_event'=>$this->input->post('callout_event'),
			'module_web_hooks_url'=>$this->input->post('module_web_hooks_url'),
			'module_is_secure'=>$this->input->post('module_is_secure'),
			);
			
			if($this->Hooks_configuration->save_module_web_hooks($batch_save_data))
			{
				$data['msg4'] = "Your record has been saved successfully.";
			}
			else
			{
				$data['msg4'] = "Sorry we cannot save your record.";
			}
			$this->load->view('web_hooks' , $data);
		}
		
	}
	
	function update_module_web_hooks()
	{
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_rules('module_hook_id', 'Module Id', 'required');
		$this->form_validation->set_rules('module_name', 'Module Name', 'required');
		$this->form_validation->set_rules('callout_event', 'Callout Event', 'required');  
		$this->form_validation->set_rules('module_web_hooks_url', 'Callout URL', 'required');
		$this->form_validation->set_rules('module_is_secure', 'security', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data["msg3"] = "Fileds with red label are required.";
			$this->view();
		}
		else
		{
			$module_hook_id = $this->input->post('module_hook_id');
			$batch_save_data=array(			
			'module_name'=>$this->input->post('module_name'),
			'callout_event'=>$this->input->post('callout_event'),
			'module_web_hooks_url'=>$this->input->post('module_web_hooks_url'),
			'module_is_secure'=>$this->input->post('module_is_secure'),
			);
			
			if($this->Hooks_configuration->update_module_web_hooks($batch_save_data ,$module_hook_id))
			{
				$data['msg4'] = "Your record has been updated successfully.";
			}
			else
			{
				$data['msg4'] = "Sorry we cannot save your record.";
			}
			$this->show_module_configuration();
		}
		
	}
	
		/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->Hooks_configuration->get_search_hooks_module_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}
	
		/*
	Returns customer table data rows. This will be called with AJAX.
	*/
	function search()
	{
		$search=$this->input->post('search');
		$data_rows= get_module_hooks_manage_table_data_rows($this->Hooks_configuration->search_module_hooks($search),$this);
		echo $data_rows;
	}
	
	
		/*
	Gives search suggestions based on what is being searched for
	*/
	function suggestKeys()
	{
		$suggestions = $this->Hooks_configuration->get_search_hooks_module_Keys_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}
	
		/*
	Returns customer table data rows. This will be called with AJAX.
	*/
	function searchKeys()
	{
		$search=$this->input->post('search');
		$data_rows= get_module_hooks_manage_keys_table_data_rows($this->Hooks_configuration->search_module_hooks_keys($search),$this);
		echo $data_rows;
	}
	
	/*
	Loads the customer edit form
	*/
	function view($module_id=-1)
	{
		$data['module_info']=$this->Hooks_configuration->get_info($module_id);
		$this->load->view("web_hooks_module",$data);
	}
	
	/*
	This deletes customers from the customers table
	*/
	function delete()
	{
		$customers_to_delete=$this->input->post('ids');		
		if($this->Hooks_configuration->delete_list($customers_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('customers_successful_deleted').' '.
			count($customers_to_delete).' '.$this->lang->line('web_hooks_module_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('web_hooks_modules_cannot_be_deleted')));
		}
	}
	function create_keys()
	{
	
		$batch_save_data=array(
		'hash_code'=> md5(round(microtime(true)*1000))
		);
		
		if($this->Hooks_configuration->save_global_key($batch_save_data))
		{
			$data['msg6'] = "Your record has been saved successfully.";
		}
		else
		{
			$data['msg7'] = "Sorry we cannot save your record.";
		}
		$this->load->view('web_hooks' , $data);
		
	}
	/*
	This deletes customers from the customers table
	*/
	function deleteKeys()
	{
		$customers_to_delete=$this->input->post('ids');		
		if($this->Hooks_configuration->delete_key_list($customers_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('customers_successful_deleted').' '.
			count($customers_to_delete).' '.$this->lang->line('web_hooks_module_keys')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('web_hooks_keys_cannot_be_deleted')));
		}
	}
	
	

}
?>