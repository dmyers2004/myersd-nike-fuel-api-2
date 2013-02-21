<?php
/**
* DMyers Nike Plus PHP Api
*
* @package    NikePlus Class
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2013
* @license    Released under the MIT License.
*/
/*
	include('nikeplusapi.php');
	$token = ''; // Your Token
	$np = new nikeplusapi($token);
	echo '<pre>';
	print_r($np->sport());
	print_r($np->activities());
	print_r($np->activity(2095521418));
	print_r($np->gps(2095521418));
*/
class nikeplusapi {

	public $token = '';
	public $appid = 'nike';
	public $header = array();
	public $apidomain = 'https://api.nike.com';
	public $apilocation = '/me/sport';
	
	public function __construct($token=NULL) {
		if ($token == NULL) {
			return $this->_error(500,'Token Must not be NULL nikeplus/construct');
		}
		$this->token = $token;
		$this->headerAppend('Accept','application/json');
		$this->headerAppend('appid',$this->appid);
	}
	
	public function headerAppend($name,$value) {
		$this->header[] = $name.': '.$value;
	}
	
	public function sport() {
		return $this->_get();
	}
	
	public function activities($offset=1,$count=25) {
		return $this->_get('/activities',array('offset'=>$offset,'count'=>$count));
	}
	
	public function activity($activityid=NULL) {
		if ($activityid == NULL) {
			return $this->_error(501,'Activity Id Must not be NULL nikeplus/activity');
		}
		return $this->_get('/activities/'.$activityid);
	}
	
	public function gps($activityid=NULL) {
		if ($activityid == NULL) {
			return $this->_error(502,'Activity Id Must not be NULL nikeplus/gps');
		}
		return $this->_get('/activities/'.$activityid.'/gps');
	}
	
	public function get($url,$fields=array()) {
		return $this->_get($url,$fields);
	}
	
	private function _get($url='',$fields=array()) {
		$fields['access_token'] = $this->token;
		
		$fields_string = '';
		
		foreach($fields as $key=>$value) {
			$fields_string .= $key.'='.$value.'&';
		}
		
		$fields_string = rtrim($fields_string,'&');
		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->apidomain.$this->apilocation.$url.'?'.$fields_string);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header); 
		
		$json = curl_exec($ch);

		curl_close($ch);
		
		return json_decode($json);
	}
	
	private function _error($num,$msg) {
		$err = new stdClass;
		$err->errNo = $num;
		$err->errMsg = $msg;
		return $err;
	}

	private function mylogger($v,$name='logname',$new=false) {
		$path = '/Users/myersd/Desktop/';
		$flag = ($new) ? 'w' : 'a';
		if ($log_handle = fopen($path.$name.'.log',$flag)) {
			fwrite($log_handle,$v.chr(10));
			fclose($log_handle);
		}
	}



}