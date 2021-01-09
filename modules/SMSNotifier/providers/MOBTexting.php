<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
// include_once 'vtlib/Vtiger/Net/Client.php';

class SMSNotifier_MOBTEXTING_Provider implements SMSNotifier_ISMSProvider_Model {

	private $userName;
	private $password;
	private $parameters = array();
	private $SERVICE_URI = 'https://portal.mobtexting.com/api/v2/sms/send/';

	private static $REQUIRED_PARAMETERS = array(array('name'=>'access_token','label'=>'ACCESS TOKEN','type'=>'text'),array('name'=>'service','label'=>'Service','type'=>'text'),array('name'=>'sender','label'=>'Sender','type'=>'text'));

	/**
	 * Function to get provider name
	 * @return <String> provider name
	 */
	public function getName() {
		return 'MOBTexting';
	}

	/**
	 * Function to get required parameters other than (userName, password)
	 * @return <array> required parameters list
	 */
	public function getRequiredParams() {
		return self::$REQUIRED_PARAMETERS;
	}

	/**
	 * Function to get service URL to use for a given type
	 * @param <String> $type like SEND, PING, QUERY
	 */
	public function getServiceURL($type = false) {
		$this->SERVICE_URI = $this->SERVICE_URI;
		if($type) {
			switch(strtoupper($type)) {
				case self::SERVICE_AUTH:  return $this->SERVICE_URI . '/http/auth';
				case self::SERVICE_SEND:  return $this->SERVICE_URI . '/http/sendmsg';
				case self::SERVICE_QUERY: return $this->SERVICE_URI . '/http/querymsg';
			}
		}
		return $this->SERVICE_URI;
	}

	/**
	 * Function to set authentication parameters
	 * @param <String> $userName
	 * @param <String> $password
	 */
	public function setAuthParameters($userName, $password) {
		$this->userName = $userName;
		$this->password = $password;
	}

	/**
	 * Function to set non-auth parameter.
	 * @param <String> $key
	 * @param <String> $value
	 */
	public function setParameter($key, $value) {
		$this->parameters[$key] = $value;
	}

	/**
	 * Function to get parameter value
	 * @param <String> $key
	 * @param <String> $defaultValue
	 * @return <String> value/$default value
	 */
	public function getParameter($key, $defaultValue = false) {
		if(isset($this->parameters[$key])) {
			return $this->parameters[$key];
		}
		return $defaultValue;
	}

	/**
	 * Function to prepare parameters
	 * @return <Array> parameters
	 */
	protected function prepareParameters() {
		foreach (self::$REQUIRED_PARAMETERS as $key=>$fieldInfo) {
			$params[$fieldInfo['name']] = $this->getParameter($fieldInfo['name']);
		}
		return $params;
	}
	/**
	 * Function to handle SMS Send operation
	 * @param <String> $message
	 * @param <Mixed> $toNumbers One or Array of numbers
	 */
	public function send($message, $toNumbers) {
		if(!is_array($toNumbers)) {
			$toNumbers = array($toNumbers);
		}
		foreach ($tonumbers as $i => $tonumber) {
			$tonumbers[$i] = str_replace(array('(', ')', ' ', '+', '-'), '', $tonumber);
		}

		$params = $this->prepareParameters();
		$httpClient = new Vtiger_Net_Client($this->getServiceURL());
		foreach($toNumbers as $toNumber) {
			$format_number = str_replace(array('(', ')', ' ', '+', '-'), '', $toNumber);
			$params['message'] = $message;
			$params['to'] = $format_number;
			$xmlResponse = $httpClient->doPost($params);
			$xmlObject=json_decode($xmlResponse);
			$result = array();

			error_log(print_r($xmlObject, TRUE), 3, '/mobobj_errors.log');

			if(count($xmlObject)>0 || !empty($xmlObject)) {
				$result['id'] = $xmlObject->data[0]->id;
				// $result['status'] = $xmlObject->data[0]->id;

				$status = $xmlObject->status;
				$message = $xmlObject->message;
				$result['to'] = $xmlObject->data[0]->mobile;
				switch($status) {
					case 'ERROR'	:	
										$result['error'] = true;
										$result['status'] =$message;
										$result['to'] =$format_number; 
										$result['statusmessage'] =$message;
										break;

					case '200'	    :	$result['status'] ="Sent";
										break;
					case '401'	    :	
										$result['error'] = true;
										$result['status'] =$message;
										$result['statusmessage'] =$message;
										break;
				}


				$results[] = $result;

			} else {
				$result['error'] = true;
				$result['statusmessage'] = "Unauthenticated or Access Token Invalid.";
				$result['to'] = $format_number;
				$results[] = $result;
			}



		}
			// error_log(print_r($results, TRUE), 3, '/mobresults.log');

		return $results;
	}


	/**
	 * Function to get query for status using messgae id
	 * @param <Number> $messageId
	 */

	public function query($messageId) {
		$params = $this->prepareParameters();
		$params['id'] = $messageId;
		$params = $this->prepareParameters();
		$httpClient = new Vtiger_Net_Client($this->getServiceURL().'/'.$messageId);

		// $httpClient->setHeaders(array('Authorization' => $params['access_token'],'access_token' => $params['access_token'],'service' => $params['service'],'sender' => $params['sender']));

		$xmlResponse = $httpClient->doPost($params);
		// $xmlResponse = $httpClient->doGet(array());
		$xmlObject=json_decode($xmlResponse);

		$result = array();
		$result['error'] = false;
		$status = $xmlObject->status;
		$message = $xmlObject->message;
		switch($status) {	
			case '200'		    :	$result['needlookup'] = 0;
									$result['status'] ="Sent";

									break;
			case 'ERROR'		:	$result['error'] = true;
									$result['needlookup'] = 1;
									$result['status'] =$message;
									$result['statusmessage'] =$message;
									break;
			case '401'		    :   $result['error'] = true;
									$result['needlookup'] = 1;
									$result['statusmessage'] =$message;
									break;

		}

		// $result['status'] = $status;
		// $result['statusmessage'] = $xmlObject->message;
		
		return $result;
	}

	function getProviderEditFieldTemplateName() {
		return 'MobTexting.tpl';
	}
}
?>