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
		$authenticate = $this->authentiate_user($headerInfo);
		if($authenticate === true)
		{
			$postData = json_decode($postdata1, true);
			if($postData == NULL)
			{
				switch(json_last_error())
				{
					case JSON_ERROR_DEPTH:
						$error =  'Maximum stack depth exceeded';
						break;
					case JSON_ERROR_CTRL_CHAR:
						$error = 'Unexpected control character found';
						break;
					case JSON_ERROR_SYNTAX:
						$error = 'Syntax error, malformed JSON';
						break;
					case JSON_ERROR_STATE_MISMATCH:
							$error = 'Underflow or the modes mismatch';
						break;
					case JSON_ERROR_UTF8:
							$error = 'Malformed UTF-8 characters, possibly incorrectly encoded';
						break;
					case JSON_ERROR_NONE:
					default:
						$error = '';                    
				}
				if(!empty($error))
				{
					$response = array();
					$data = array();
					$response['statusCode'] = HTTP_BAD_REQUEST;
					$response['status'] = false;
					$response['message'] = $error;
					$response['data'] = $data;
					echo json_encode($response);
				}
				else
				{
					$response = array();
					$data = array();
					$response['statusCode'] = HTTP_BAD_REQUEST;
					$response['status'] = false;
					$response['message'] = 'Invalid Json OR required keys are missing.';
					$response['data'] = $data;
					echo json_encode($response);
				}
					
			}
			else
			{
				if(isset($headerInfo['sender_id']) && $headerInfo['sender_id'] != '')			
					$sender_id = $headerInfo['sender_id'];
				else
					$sender_id = 0;
				$insertSendingData = array(
				   "receiver_id" => $sender_id,
				   "data" => json_encode($postData),
				   "curl_status" => 2,
				   "curl_timestamp" => date('Y-m-d H:i:s'),
				   "status" => 1,
				   "curl_type" => 2
			   );
			   $this->db->insert('curl_log' , $insertSendingData);
				$servicePath = $postData['path'];
				
				switch($servicePath)
					{
						case 'addReceivedAmount':
							  $this->addReceivedAmount($postData);
						break;
						
						case 'deleteCustomer':
							  $this->deleteCustomer($postData);
						break;
						
						case 'saveCustomer':
							  $this->saveCustomer($postData);
						break;
						
						case 'getCustomers':
							  $this->getCustomers($postData);
						break;						
															
						default:
						{
								$response = array();
								$response['statusCode'] = HTTP_NOT_FOUND;
								$response['status'] = false;
								$response['message'] = 'Action not found';
								echo json_encode($response);	
						break;
						}
						
					}
		
			}		
		}
	}
	
	function addReceivedAmount($postData)
	{
		$this->load->model('sale');
		if((isset($postData['sale_id']) && $postData['sale_id'] != '') && (isset($postData['payment_amount']) && $postData['payment_amount'] != ''))
		{
			if($this->sale->insertCurlPayment($postData['sale_id'] , $postData['payment_amount']))
			{
				$this->successMessage();
			}
			else
			{
				$this->interServerError();
			}
		}
		else
		{
			$this->missingKeys();
		}
	
	}
		/*
	Inserts/updates a customer
	*/
	function saveCustomer($postData)
	{
		$this->load->model('customer');
		if((isset($postData['first_name']) && $postData['first_name'] != '') && (isset($postData['last_name']) && $postData['last_name'] != '')
		  && (isset($postData['customer_id']) && ($postData['customer_id'] == -1 || $postData['customer_id'] > 0)))
		{
			$customer_data = array();
			$customer_id = '';
			if(isset($postData['account_number']) || isset($postData['taxable']))
			{				
				$customer_data['account_number'] = $this->input->post('account_number')=='' ? null:$this->input->post('account_number');
				$customer_data['taxable'] = $this->input->post('taxable')=='' ? 0:1;
				unset($postData['account_number']);
				unset($postData['taxable']);																
			}
			$customer_id = $postData['customer_id'];
			unset($postData['customer_id']);	
			unset($postData['path']);
			if($this->Customer->save($postData,$customer_data,$customer_id))
			{
				$this->successMessage();
			}
			else
			{
				$this->interServerError();
			}
		}
		else
		{
			$this->missingKeys();
		}
	
	}
	function getCustomers($postData)
	{
		$this->load->model('customer');
		$customer_id = '';
		$requestResponse = '';
		if(isset($postData['customer_id']) && $postData['customer_id'] > 0)
		{
			$customer_id = $postData['customer_id'];
			unset($postData['customer_id']);
			$requestResponse = $this->Customer->get_info($customer_id);
		}
		else
		{
			$requestResponse = $this->Customer->get_all_customers();			
		}			
		unset($postData['path']);		
		if(json_encode($requestResponse))
		{
			$this->sendResponse($requestResponse);
		}
		else
		{
			$this->interServerError();
		}
	}
	function deleteCustomer($postData)
	{		
		$this->load->model('customer');
		if((isset($postData['customerId']) && $postData['customerId'] != ''))
		{	
			unset($postData['path']);
			if($this->Customer->delete($postData['customerId']))
			{
				$this->successMessage();
			}
			else
			{
				$this->interServerError();
			}
		}
		else
		{
			$this->missingKeys();
		}
	
	
	}
	function sendResponse($json_data)
	{
		$response = array();
		$data = array();
		$response['statusCode'] = HTTP_OK;
		$response['status'] = true;
		$response['message'] = 'Action make successfully';
		$response['data'] = $json_data;
		echo json_encode($response);
	}
	function successMessage()
	{
		$response = array();
		$data = array();
		$response['statusCode'] = HTTP_OK;
		$response['status'] = true;
		$response['message'] = 'Action make successfully';
		$response['data'] = $data;
		echo json_encode($response);
	}
	function interServerError()
	{
		$response = array();
		$data = array();
		$response['statusCode'] = HTTP_INTERNAL_SERVER_ERROR;
		$response['status'] = false;
		$response['message'] = 'Sorry due to internal server error we can not make your request successfull.';
		$response['data'] = $data;
		echo json_encode($response);
	}
	function missingKeys()
	{
		$response = array();
		$data = array();
		$response['statusCode'] = HTTP_BAD_REQUEST;
		$response['status'] = false;
		$response['message'] = 'Some required keys/values are missing.';
		$response['data'] = $data;
		echo json_encode($response);
	}
	/*function authentiate_user($headers = array())
	{
		$sender_url = $headers['sender_hash'];
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
	}*/
	
	function authentiate_user($headers = array())
	{
		
		if($this->config->item('rest_auth') == 'basic')
		{
			if((isset($headers['sender_hash_code']) && $headers['sender_hash_code'] != '') && (isset($headers['sender_id']) && $headers['sender_id'] != ''))
			{
				$query = mysql_query("SELECT * FROM ospos_tbl_keys WHERE key_id = '".$headers['sender_id']."' AND hash_code = '".$headers['sender_hash_code']."'");
				$row =  mysql_fetch_assoc($query);
				//$query = $this->db->get_where('ospos_global_config', array('status' => '1' , 'global_id' => $sender_id),1);
				if (mysql_num_rows($query) > 0)
				{
					if(!isset($headers['Content-Type']))
					{
						$response = array();
						$data = array();
						$response['statusCode'] = HTTP_NOT_ACCEPTABLE;
						$response['status'] = false;
						$response['message'] = 'Missing content-type.';
						$response['data'] = $data;
						echo json_encode($response);
					}
					else
					{
						if(isset($headers['Content-Type']) && $headers['Content-Type'] != 'application/json')
						{
							$response = array();
							$data = array();
							$response['statusCode'] = HTTP_NOT_ACCEPTABLE;
							$response['status'] = false;
							$response['message'] = 'Invalid content type we support only application/json.';
							$response['data'] = $data;
							echo json_encode($response);
						}
						else
						{
							$methods = $this->config->item('supported_methods');
							$method = $this->input->server('REQUEST_METHOD');
							if(!in_array($method, $methods))
							{
								$response = array();
								$data = array();
								$response['statusCode'] = HTTP_METHOD_NOT_ALLOWED;
								$response['status'] = false;
								$response['message'] = 'Invalid request method we support only POST.';
								$response['data'] = $data;
								echo json_encode($response);
							}
							else
							{
								return true;
							}							
						}
					}
				}
				else
				{
					$response = array();
					$data = array();
					$response['statusCode'] = HTTP_UNAUTHORIZED;
					$response['status'] = false;
					$response['message'] = 'Invalid sender Id or hash code.';
					$response['data'] = $data;
					echo json_encode($response);
				}
			}
			else
			{
				$response = array();
				$data = array();
				$response['statusCode'] = HTTP_NON_AUTHORITATIVE_INFORMATION;
				$response['status'] = false;
				$response['message'] = 'Sender Id and hash code is required for authorization.';
				$response['data'] = $data;
				echo json_encode($response);
			}
		}
		else
		{
			if(!isset($headers['Content-Type']))
					{
						$response = array();
						$data = array();
						$response['statusCode'] = HTTP_NOT_ACCEPTABLE;
						$response['status'] = false;
						$response['message'] = 'Missing content-type.';
						$response['data'] = $data;
						echo json_encode($response);
					}
					else
					{
						if(isset($headers['Content-Type']) && $headers['Content-Type'] != 'application/json')
						{
							$response = array();
							$data = array();
							$response['statusCode'] = HTTP_NOT_ACCEPTABLE;
							$response['status'] = false;
							$response['message'] = 'Invalid content type we support only application/json.';
							$response['data'] = $data;
							echo json_encode($response);
						}
						else
						{
							$methods = $this->config->item('supported_methods');
							$method = $this->input->server('REQUEST_METHOD');
							if(!in_array($method, $methods))
							{
								$response = array();
								$data = array();
								$response['statusCode'] = HTTP_METHOD_NOT_ALLOWED;
								$response['status'] = false;
								$response['message'] = 'Invalid request method we support only POST.';
								$response['data'] = $data;
								echo json_encode($response);
							}
							else
							{
								return true;
							}							
						}
					}
		}
	}
		
}
?>