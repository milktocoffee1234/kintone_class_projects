<?php
class Post_Kintone{
	public $url;
	public $header;
	public $appId;
	public $recode;

	function request_kintone_post($url, $header, $appId, $record) {
		try {
			// リクエスト作成
			$request = new HTTP_Request2();
			$request->setHeader($header);
			$request->setUrl($url);
			$request->setMethod(HTTP_Request2::METHOD_POST);
			$request->setBody(json_encode(array("app" => $appId,
				"record" => $record)
			));
			$request->setConfig(array(
				'ssl_verify_host' => false,
				'ssl_verify_peer' => false
				));

		    // レスポンス取得
			$response = $request->send();

			return $response;
		} catch (HTTP_Request2_Exception $e) {
			//die($e->getMessage());
			return null;
		} catch (Exception $e) {
			//die($e->getMessage());
			return null;
		}
	}

}



class Util {
	private $post_data = array();
	public function __construct(array $arg){
		$this -> post_data = $arg;
		print_r($this-> post_data);
	}	
	
	public function get_post_string($name) {
		return isset( $this -> post_data[$name] ) ? $this -> post_data[$name] : "";
	}

	public function get_post_array($name) {
		return isset( $this -> post_data[$name] ) ? $this -> post_data[$name] : array();
	}
}

class Validation{
function setErrorMessage($prefix, $value) {

	global $error_message;

	if ($error_message["{$prefix}Error"] != null) {
		unset($error_message["{$prefix}Error"]);
	}

	$error_message += array("{$prefix}Error" => $value);
}


function check_required($value) {
	if(empty($value)) {
		return false;
	}
	return true;
}

function check_past_date_format($value, $target) {
	try {
		return strtotime($value) <= strtotime($target);
	} catch (Exception $e) {
		return false;
	} 
}

function check_integer($value) {

	$regex = "/^[1-9][0-9]*$/";

return check_pattern($value, $regex);

}

function check_digits($value) {
	if(strlen($value) <= 3){
		return true;
	} else {
		return false;
	}
}

function check_email_local($value) {

	// [A-Za-z0-9!#\$%&'\*\+\-\/=\?\^_`\{\|\}~]
	//$regex = "/^[A-Za-z0-9\\!#\\$%&'\\*\\+\\-/\\=\\?\\^_`\\{\\|\\}~](\\.?[A-Za-z0-9\\!#\\$%&'\\*\\+\\-/\\=\\?\\^_`\\{\\|\\}~]+)*$/";
	$regex = "/^[A-Za-z0-9\\!#\\$%&'\\*\\+\\-\\=\\?\\^_`\\{\\|\\}~]([\\.]?[A-Za-z0-9\\!#\\$%&'\\*\\+\\-\\=\\?\\^_`\\{\\|\\}~])*$/";

	return check_pattern($value, $regex);
	
}

function check_pattern($value, $regex){
	if (preg_match($regex, $value) == 0){
		return false;
	} else {
		return true;
	}
}
}

class Send_Mail{

}



?>