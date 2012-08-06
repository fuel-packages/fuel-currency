<?php

return array(

	/**
	 * Default settings
	 */

	/**
	 * Default currency converter driver
	 */
	'default_driver' =>	'openexchangerates',

	'default_currency_from'   => 'eur',
	'default_currency_to'     => 'usd',

	'formatters' => array(
		'eur' => function($value)
		{
			return '€'.number_format($value, 2, ',', '.');
		},
		'usd' => function($value)
		{
			return '$'.number_format($value, 2, '.', ',');
		},
		'ltl' => function($value)
		{
			return 'LT '.number_format($value, 2, '.', ',');
		},
	),

	/*
	 * Sets timeout for Request cURL
	 * */
	'timeout' => 5,

	/*
	 * How long to cache the response
	 * */
	'cache' => 1800,

	/*
	 * Drivers default config
	 * */
	'drivers' => array(
		'openexchangerates' => array(
			'url' => 'http://openexchangerates.org/api/latest.json',
			'app_id' => 'cdea87da3e8e46a5951857a5f44712b1',
			'currency_base' => 'usd', // openexchangerates.org has all ratios based on USD
		),
		// TODO Google, Yahoo ?
	),

);
