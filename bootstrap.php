<?php

Autoloader::add_core_namespace('Currency');

Autoloader::add_classes(array(
	/**
	 * Rates classes.
	 */
	'Currency\\Currency'							=> __DIR__.'/classes/currency.php',
	'Currency\\Currency_Driver'					    => __DIR__.'/classes/currency/driver.php',
	'Currency\\Currency_Driver_Openexchangerates'	=> __DIR__.'/classes/currency/driver/openexchangerates.php',
//	'Pingsearch\\Pingsearch_Driver_Google'				=> __DIR__.'/classes/pingsearch/driver/google.php',
//	'Pingsearch\\Pingsearch_Driver_Yahoo'				=> __DIR__.'/classes/pingsearch/driver/yahoo.php',
));