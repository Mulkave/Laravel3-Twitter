<?php

/**
 * @file
 * A single location to store configuration.
 */

	$social_config = require path('app').DS.'config'.DS.Request::env().DS.'social.php';
	$config = $social_config['twitter'];

	define('CONSUMER_KEY', $config['CONSUMER_KEY']);
	define('CONSUMER_SECRET', $config['CONSUMER_SECRET']);
	define('OAUTH_CALLBACK', $config['OAUTH_CALLBACK']);