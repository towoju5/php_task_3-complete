<?php

class Curl
{
	public function simple_get($url, array $params=null)
	{
		if(null !== $params){
			$url = $url."?".http_build_query($params);
		}
		$ch = curl_init();
		$config['useragent'] = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, $config['useragent']);
		curl_setopt($ch, CURLOPT_REFERER, base_url());

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);

		return $result;
	}
}
