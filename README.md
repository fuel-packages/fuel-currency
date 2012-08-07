#FuelPHP currency converter

Currently work with OpenXChangeRates.org, Google, Yahoo

TODO: any other drivers?

Usage example:

    \Package::load('currency');

    // This will use the default driver:
    echo \Currency::forge()->convert(100, 'usd')->to('eur');
    // €80,88
    echo \Currency::forge()->convert(10, 'eur')->to('usd');
    // $12.36

    // This will use specific driver
    echo \Currency::forge('google')->convert(10, 'eur')->to('usd');
    // $12.37

    // to() method accepts formatter closure as 2nd argument, like:
    echo \Currency::forge('google')->convert(110, 'USD')->to('eur', function($value) {return number_format($value, 4).' EUR/min';})
    // 88.8961 EUR/min

Config supports formatters, config looks like:

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
