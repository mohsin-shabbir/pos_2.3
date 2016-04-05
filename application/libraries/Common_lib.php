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
	
	function sendToThirdParty($json)
	{
			
		/********************************************/
		//Curl Code Will Goes here
		$query = $this->db->get_where('ospos_global_config', array('status' => '1') , 1);
	/*	foreach ($query->result() as $row)
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
			   "status" => 1
		   );
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
				if($curlResponse['status'] == 200)
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