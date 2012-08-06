<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2012 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Currency;


class Currency_Driver_Openexchangerates extends \Currency_Driver
{

	/**
	 * Gets data from Openxchangerates site
	 *
	 * @return	bool	success boolean
	 */
	protected function _execute()
	{
		//http://openexchangerates.org/api/latest.json?app_id=XXXXXXXXXXXX
		$app_id = $this->get_config('drivers.openexchangerates.app_id');

		if ( ! $app_id)
		{
			throw new \FuelException('_execute() error in driver : '.$this->config['driver']. '. app_id not set.');
		}

		// try to retrieve the cache
		try
		{
			$request = \Cache::get('currency_openexchangerates');
		}
		catch (\CacheNotFoundException $e)
		{
			try
			{
				$url = $this->url.'?app_id='.$app_id;

				$request = \Request::forge($url, 'curl')->execute();
				\Cache::set('currency_openexchangerates', $request, $this->get_config('currency.cache', 1800));
			}
			catch (\Exception $e)
			{
				throw new \FuelException('_execute() error in driver : '.$this->config['driver']. '. Error message returned: '.$e->getMessage());
			}
		}

		if ($request and $request->response()->status === 200 and $request->response()->body())
		{
			$return = json_decode($request->response()->body());

			$currency_from = strtoupper($this->currency_from);
			$currency_to = strtoupper($this->currency_to);
			$amount = $this->amount;

			if (isset($return->rates->$currency_to) and isset($return->rates->$currency_from))
			{
				$part1 = bcdiv($amount, $return->rates->$currency_from, 6);
				return bcmul($part1, $return->rates->$currency_to, 6);
			}
			else
			{
				throw new \FuelException('Driver: '.$this->config['driver'].' does not support $currency_to '.$currency_to.' and $currency_from: '.$currency_from);
			}
		}

		return false;
	}

}
