<?php

namespace app\components;

class CurlRequest
{
	/**
	 * @var string
	 */
	public $url;

	/**
	 * @var string
	 */
	public $postBody;

	/**
	 * @var string
	 */
	public $headers;

	/**
	 * @var string
	 */
	public $username;
	/**
	 * @var string
	 */
	public $password;


	public function send($decode = true, $auth = false, $timeout = 120)
	{
		$ch = curl_init();

		curl_setopt_array($ch, [
			CURLOPT_URL => $this->url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => $timeout,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $this->postBody,
			CURLOPT_HTTPHEADER => $this->headers,
		]);
		if($auth == true) {
			curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);
		}

		$response = curl_exec($ch);

		if (curl_error($ch)) {
			return curl_error($ch);
		}

		curl_close($ch);

		if ($decode == true) {
			$originalResponse = json_decode($response, true);//asArray
			if ($originalResponse !== null) {
				return $originalResponse;
			}
		}

		return $response;
	}

	public function sendPut($decode = true, $auth = false)
	{
		$ch = curl_init();

		curl_setopt_array($ch, array(
			CURLOPT_URL => $this->url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 120,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "PUT",
			CURLOPT_POSTFIELDS => $this->postBody,
			CURLOPT_HTTPHEADER => $this->headers,
		));
		if($auth == true) {
			curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);
		}

		$response = curl_exec($ch);

		if (curl_error($ch)) {
			return curl_error($ch);
		}

		curl_close($ch);

		if ($decode == true) {
			$response = json_decode($response, true);//asArray
		}

		return $response;
	}

	public function sendGet($decode = true, $auth = false, $customConfig = [])
	{
		$ch = curl_init();

		curl_setopt_array($ch, [
				CURLOPT_URL => $this->url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 120,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => $this->headers ? $this->headers : []
			] + $customConfig);

		if($auth == true) {
			curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);
		}

		$response = curl_exec($ch);

		if (curl_error($ch)) {
			return curl_error($ch);
		}

		curl_close($ch);

		if ($decode == true) {
			return json_decode($response, true);//asArray
		} else {
			return $response;
		}
	}

	public function sendAsForm($decode = true)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postBody);
		curl_setopt($ch, CURLOPT_USERAGENT,
			"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_HTTPHEADER, []);

		$response = curl_exec($ch);

		if (curl_error($ch)) {
			return curl_error($ch);
		}

		curl_close($ch);

		if ($decode == true) {
			return json_decode($response, true);//asArray
		} else {
			return $response;
		}
	}


}