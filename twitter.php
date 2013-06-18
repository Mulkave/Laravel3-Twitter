<?php

Class Twitter {

	public static function timeline($screen_name, $count = 10, $exclude_replies = true, $include_retweets = false)
	{
		$cache_key = static::cacheKey($screen_name);

		if(Cache::has($cache_key))
		{
			return Cache::get($cache_key);
		} else {

			$authenticator = new TwitterAuthenticator(Config::get('twitter.key'), Config::get('twitter.secret'));
			$access_token = $authenticator->getBearerAccessToken();

			$timeline_request = array(
				'url'    => 'https://api.twitter.com/1.1/statuses/user_timeline.json',
				'params' => array(
					'screen_name'     => $screen_name,
					'count'           => is_int($count) ? $count : 10,
					'exclude_replies' => $exclude_replies,
					'include_rts'=> $include_retweets
				),
				'headers'=> array(
					'Authorization: Bearer '.$access_token
				)
			);

			$timeline = json_decode(HTTP::get($timeline_request));

			if(!isset($timeline->errors))
			{
				Cache::put($cache_key, $timeline, 3);
			}

			return $timeline;
		}
	}

	public static function cacheKey($screen_name)
	{
		return sprintf('twitter_timeline_%s', $screen_name);
	}
}