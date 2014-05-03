<?php

class Tw_Terminal
{
	public $tw;
	public $last_tweet_id;
	public function __construct(Tw $tw)
	{
		$this->tw = $tw;
	}
	public function get_home_timeline($reverse = true)
	{
		$tweets = $this->tw->get_home_timeline();
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
