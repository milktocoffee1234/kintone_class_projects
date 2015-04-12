<?php

class Kintone{

private $post_data = array();
private $check_items = array();


function __construct(array $arg){
	$this -> post_data = $arg;
}

function set_check_items(...$array){
	$this -> check_items += $array;
}

function print_item_list(){
	print_r($this -> check_items);
}

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

function check_required($value) {
	if(empty($value)) {
		return false;
	}
	return true;
}

function get_post_data_array($check_items_name) {
	$send_data = array();

	foreach ($check_items_name as $name) {
		$send_data += array($name => get_post_string($name));
	}
	return $send_data;
}


function get_post_string($name) {
	global $post_data;
	return isset( $post_data[$name] ) ? $post_data[$name] : "";
}

function get_post_array($name) {
	global $post_data;
	return isset( $post_data[$name] ) ? $post_data[$name] : array();
}

}
?>