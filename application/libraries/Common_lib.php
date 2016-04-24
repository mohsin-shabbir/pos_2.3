<?php
class Common_lib extends CI_Model
{
	var $CI;

  	function __construct()
	{
		$this->CI =& get_instance();
	}
	
	function saveLog($module_id = "" , $module_name = "" , $action_time = "" , $employee_id = "" , $comment = "" )
	{
		$logData = array(
			'module_id'=> $module_id,
			'module_name'=>$module_name,
			'action_time'=>date('Y-m-d H:i:s'),
			'employee_id'=>$employee_id,
			'comment'=>$comment
		);
		$this->db->insert('tbl_logs',$logData);
		$log_id = $this->db->insert_id();
	}
	
	function sendEmail($fromEmail , $fromName , $toEmail , $cc = "" , $bccEmail = "" , $subject , $message)
	{
		$ci = get_instance();
		$ci->load->library('email');
		$config['protocol'] = "smtp";
		$config['smtp_host'] = "ssl://smtp.gmail.com";
		$config['smtp_port'] = "465";
		$config['smtp_user'] = "link2mohsin22@gmail.com"; 
		$config['smtp_pass'] = "ph6362968!@";
		$config['charset'] = "utf-8";
		$config['mailtype'] = "html";
		$config['newline'] = "\r\n";
		$ci->email->initialize($config);
		
		$this->email->from($fromEmail , $fromName );
		$this->email->to($toEmail); 
		$this->email->cc($cc); 
		$this->email->bcc($bccEmail); 
		$this->email->subject($subject );
		$this->email->message($message);	
		if($this->email->send())
		{
			return "Email sends successfully.";
		}
		else
		{
			return "Sorry, We cannot send your email.";
		}
	}
	
	function sendToThirdParty($json)
	{
			
		/********************************************/
		//Curl Code Will Goes here
		$query = $this->db->get_where('ospos_global_config', array('status' => '1') , 1);
		/*foreach ($query->result() as $row)
		{
			echo $row->title;
		}*/
		if ($query->num_rows() > 0)
		{
		   $row = $query->row_array(); 
		   $insertSendingData = array(
			   "receiver_id" => $row['global_id'],
			   "data" => json_encode($json),
			   "curl_status" => 0,
			   "curl_timestamp" => date('Y-m-d H:i:s'),
			   "status" => 1,
			   "curl_type" => 1
		   );
		   $errorEmail = $row['error_email'];
		   $this->db->insert('curl_log' , $insertSendingData);
		   $curl_id = $this->db->insert_id();
		   $headers = array();
		   $headers[0] = 'Content-Type: application/json';
		   if(isset($row['callout']) && $row['callout'] == 1);
		   {
		   		if(isset($row['is_secure']) && $row['is_secure'] == 1)
				{
					$headers[1] = 'access-token: '.hash('sha256', $row['authorization_token']);
					$headers[2] = 'access-username: '.hash('sha256', $row['authorization_username']);
					$headers[3] = 'access-password: '.hash('sha256', $row['authorization_password']);
				}
				$serverString = json_encode($json);
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $row['url']);
				curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS , $serverString);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$curlResponse  = curl_exec($curl);
				curl_close($curl);
				unset($headers);				
				if($curlResponse)///if($curlResponse['status'] == 200)
				{
					$data = array(
					   'curl_status' => 1
					);
	
					$this->db->where('curl_id', $curl_id);
					$this->db->update('curl_log', $data); 
					$code = 200;
					$message = "Your request has been sent to third party.";
					$status = true;
				}
				else
				{
					$message = '
							<html>
								<head>
									<title>Failed Curl</title>
								</head>
								<body>
								<p>Sorry we are fail to send your curl reques, below are curl details.</p>
								<table>
									<tr>
										<td>Curl Id</td>
										<td>'.$curl_id.'</td>
									</tr>
									<tr>
										<td>Request Time</td>
										<td>'.date('Y-m-d H:i:s').'</td>
									</tr>
															
								</table>
								</body>
							</html>';
					$this->sendEmail("link2mohsin22@yahoo.com" , "Tousef Ahmad" , "link2mohsin22@gmail.com" , "" , "" , "Test Message" , $message );
					$code = 9;
					$message = "Sorry! we cannot send your code.";
					$status = false;
					
				}
				$response = array();
				$response['code'] = $code;
				$response['message'] = $message;
				$response['status'] = $status;
				$returnData = json_encode($response);
				return $returnData;				
		   }
		}
		
		exit;
		
	}
}
?>