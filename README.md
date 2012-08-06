#FuelPHP currency converter

Currently work with http://openexchangerates.org
TODO: Google, Yahoo


Usage example:
    \Package::load('currency');

    echo \Currency::forge()->convert(100, 'usd')->to('eur');
    // €80,88
    echo \Currency::forge()->convert(10, 'eur')->to('usd');
    // $12.36


Config supports formatters, which work on to() currency, current config looks like:
	'formatters' => array(
		'eur' => function($value)
		{
			return '€'.number_format($value, 2, ',', '.');
		},
		'usd' => function($value)
		{
			return '$'.number_format($value, 2, '.', ',');
		},
	),
