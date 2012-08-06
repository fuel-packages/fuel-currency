<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package		Fuel
 * @version		1.0
 * @author 		Fuel Development Team
 * @license		MIT License
 * @copyright	2010 - 2011 Fuel Development Team
 * @link 		http://fuelphp.com
 */

namespace Currency;

abstract class Currency_Driver
{
	/**
	 * Driver config
	 */
	protected $config = array();

	/**
	 * URL to driver
	 * $param string $url
	 */
	protected $url = null;

	/*
	 * Currency you convert from
	 * */
	protected $currency_from = null;

	/*
	 * Currency you convert to
	 * */
	protected $currency_to = null;

	/*
	 * Currency you have all ratios in
	 * */
	//protected $currency_base = null; not used yet

	/**
	 * @var $sum amount of money
	 */
	protected $amount = null;


	/**
	 * Driver constructor
	 *
	 * @param	array	$config		driver config
	 */
	public function __construct(array $config)
	{
		$this->url = \Config::get('currency.drivers.'.$config['driver'].'.url');

		$this->config = $config;
	}

	/**
	 * Get a driver config setting.
	 *
	 * @param	string		$key		the config key
	 * @return	mixed					the config setting value
	 */
	public function get_config($key, $default = null)
	{
		return \Arr::get($this->config, $key, $default);
	}

	/**
	 * Set a driver config setting.
	 *
	 * @param	string		$key		the config key
	 * @param	mixed		$value		the new config value
	 * @return	object					$this
	 */
	public function set_config($key, $value)
	{
		\Arr::set($this->config, $key, $value);

		return $this;
	}

	/**
	 * Sets the driver
	 *
	 * @param	string		$driver			the message body
	 * @return	object		$this
	 */
	public function driver($driver)
	{
		$this->driver = (string) $driver;

		return $this;
	}

	/**
	 * @param $amount
	 * @return Currency_Driver or converted $amount
	 */
	public function convert($amount = null, $currency = null)
	{
		if ( ! $amount)
		{
			throw new \FuelException('$currency_from should be passed.');
		}

		$this->amount = $amount;
		$this->currency_from = ($currency) ? $currency : \Config::get('rates.default_currency_from', 'eur');

		return ($result = $this->_validate()) ? $result : $this;
	}

	/*
	 * Alias for convert()
	 * */
	public function from($sum = null, $currency = null)
	{
		return $this->convert($sum, $currency);
	}

	/**
	 * @param null $this
	 * @return Currency_Driver
	 */
	public function to($currency = null)
	{
		$currency = $currency ?: \Config::get('currency.default_currency_to', 'usd');
		$this->currency_to = $currency;
		$result = $this->_validate();

		return ($result) ? $this->_format($result, $currency) : $this;
	}

	// _execute would return this formatted
	protected function _format($value)
	{
		$formatter = $this->get_config('formatters.'.$this->currency_to);

		return ($formatter instanceof \Closure) ? $formatter($value) : number_format($value, 2);
	}

	/*
	 * Fires the request then both currency_from and currency_to are set
	 * */
	protected function _validate()
	{
		if ($this->currency_to and $this->currency_from)
		{
			return $this->_execute();
		}

		return false;
	}

	abstract protected function _execute();
}
