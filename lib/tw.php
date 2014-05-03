<?php

require __DIR__ . '/../vendor/autoload.php';

define('CONFIG_PATH', __DIR__ . '/../config/config.yml');

use Symfony\Component\Yaml\Yaml;

class Tw
{
	public function __construct()
	{
		$config = Yaml::parse(CONFIG_PATH);
		$this->tw_connection = new TwitterOAuth($config['consumer_key'], $config['consumer_secret'], $config['access_token'], $config['access_secret']);

	}
	public function check_err($tweets)
	{
		if(!isset($tweets->errors)) return $tweets;
		echo "Faild  " ;
		foreach($tweets->errors as $error) echo $error->message . " " . $error->code . "\n";
		//エラーが発生したら終了
		exit;
	}
	public function get($endpoint,$parameter = NULL)
	{
		return $this->check_err($this->tw_connection->get($endpoint,$parameter));
	}
	public function get_home_timeline()
	{
		$endpoint = 'statuses/home_timeline';
		return $this->get($endpoint);
	}
}
