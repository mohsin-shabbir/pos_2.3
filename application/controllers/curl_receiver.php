<?php
//require_once ("secure_area.php");
class Curl_receiver extends CI_Controller
{
	function __construct()
	{
		parent::__construct('config');
		
	}
	
	function index()
	{
		$postdata1 = file_get_contents("php://input");
		
		///////////////////////////Check if encypted//////////////////////
		$headerInfo = array();
		$headerInfo = getallheaders();
		//$this->load->model('Web_hooks');
		if($this->authentiate_user($headerInfo))
		{
			$postData = json_decode($postdata1, true);
			$servicePath = $postData['path'];

			switch($servicePath)
				{
					case 'addReceivedAmount':
						  $this->addReceivedAmount($postData);
					break;
									
					default:
							$response = array();
							$response['customMessage'] = 'Action not found';
							$response['processorMessage'] = '';
							$response['statusCode'] = 3;
							$response['status'] = false;
							return json_encode($response);	
					break;
					
				}

		}
		else
		{
			$response = array();
			$response['customMessage'] = 'Action not found';
			$response['processorMessage'] = '';
			$response['statusCode'] = 9;
			$response['status'] = false;
			return json_encode($response);
		}
	}
	
	function addReceivedAmount($postData)
	{
		
		$this->load->model('sale');
		//$postData = unset($postData["path"]
		
		if($this->sale->insertCurlPayment($postData['sale_id'] , $postData['payment_amount']))
		{
			$response = array();
			$response['customMessage'] = 'Action make successfully';
			$response['processorMessage'] = '';
			$response['statusCode'] = 200;
			$response['status'] = true;
			echo json_encode($response);	
		}
		else
		{
			$response = array();
			$response['customMessage'] = 'Action can not make successfully';
			$response['processorMessage'] = '';
			$response['statusCode'] = 9;
			$response['status'] = false;
			echo json_encode($response);
		}
	
	}
	function authentiate_user($headers = array())
	{
		$sender_url = $headers['sender_url'];
		$sender_id = $headers['sender_id'];
		$query = mysql_query("SELECT * FROM ospos_global_config WHERE status = 1 LIMIT 0 ,1");
		$row =  mysql_fetch_assoc($query);
		//$query = $this->db->get_where('ospos_global_config', array('status' => '1' , 'global_id' => $sender_id),1);
		if (mysql_num_rows($query) > 0)
		{
			if($sender_url == $row['url'])
			{
				
				if($row['is_secure'] == 1)
				{
					
					if(((isset($headers['access-token']) && $headers['access-token'] != '') && $headers['access-token'] = $row['authorization_token']) && ((isset($headers['access-username']) && $headers['access-username'] != '') && $headers['access-username'] = $row['authorization_username']) && ((isset($headers['access-password']) && $headers['access-password'] != '') && $headers['access-password'] = $row['authorization_password']))
					{
						return true;
					}
				}
				else
				{
					return true;
				}
			}
			else
			{
				return false;
			}
		}
	}
	
}
?>