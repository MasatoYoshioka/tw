<?php

require __DIR__ . '/../vendor/autoload.php';
define('CONSUMER_KEY','vJVvMwGlnl87do4zKFoX5deEu');
define('CONSUMER_SECRET','0V5yjRtdTmCCdbOhOXQfqG0VYjwS7FWU8O2yO3PW1IiasZCLap');
define('ACCESS_TOKEN','207861098-OpjeftpCKWALA6y9j7oEuTL0aIrL9akArHK84q5v');
define('ACCESS_SECRET','oqFVk1we4spet6mvbldksYh0sxclku18qsYRyI82PEP6W');

class Tw
{
	public function __construct($consumer_key, $consumer_secret, $access_token = NULL, $access_secret = NULL)
	{
		$this->tw_connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_secret);
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
class Tw_Terminal
{
	public $tw;
	public $user;
	public $last_tweet_id;
	public function __construct(Tw $tw)
	{
		$this->tw = $tw;
	}
	public function get_home_timeline($reverse = true)
	{
		$tweets = $this->tw->get_home_timeline($this->user);
		if($reverse) sort($tweets);
		return $tweets;
	}
	public function home_timeline()
	{
		$tweets = $this->get_home_timeline();
		$this->display_tw($tweets);
	}
	/* tweet表示再起処理 */
	public function display_tw($tweet)
	{
		if(!is_object($tweet)){
			foreach($tweet as $one_tweet) $this->display_tw($one_tweet);
		}else{
			$this->print_tw($tweet);
		}
	}
	/* tweetの表示 フォーマットとかで出力制限できたらな.*/
	public function print_tw($tweet)
	{
		echo $tweet->user->name . "@" . $tweet->user->screen_name . "\n" . $tweet->text . "\n\n";
		$this->last_tweet_id = $tweet->id;
	}
	/* ループ */
	public function loop_home_timeline($time)
	{
		sleep($time);
		$tweets = $this->get_home_timeline();
		if($this->last_tweet_question($tweets)) $this->last_display_tweet_rm($tweets);
		$this->display_tw($tweets);
		//ループ処理
		$this->loop_home_timeline($time);
	}
	/*
	* 最後に表示したtweetまで削除
	* 参照渡し
	*/
	public function last_display_tweet_rm(&$tweets)
	{
		foreach($tweets as $key => $tweet){
			unset($tweets[$key]);
			if($tweet->id === $this->last_tweet_id) break;
		}
	}
	/* 取得したtweetsの中に最後に表示したtweetがあるか */
	public function last_tweet_question($tweets)
	{
		foreach($tweets as $tweet){
			if($tweet->id === $this->last_tweet_id) return true;
		}
		return false;
	}
}
$tw = new Tw(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_SECRET);
$terminal = new Tw_Terminal($tw);
$terminal->home_timeline();
$terminal->loop_home_timeline(60);
