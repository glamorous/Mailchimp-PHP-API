<?php
/**
 * Mailchimp PHP API class
 * API Documentation: http://www.mailchimp.com/api/
 * Documentation and usage in README file
 *
 * @author Jonas De Smet - Glamorous
 * @date 02.05.2010
 * @copyright Jonas De Smet - Glamorous
 * @version 0.5.1
 * @license BSD http://www.opensource.org/licenses/bsd-license.php
 */

class Mailchimp
{
	const REST = 'xml-rpc';
	const JSON = 'json';
	const XML = 'xml';
	const PHP = 'php';
	const LOL = 'lolcode';

	const API_URL = '.api.mailchimp.com/1.2/';

	const VERSION = '0.5.1';

	/**
	 * The available return formats
	 *
	 * @var array
	 */
	private static $_formats = array(Mailchimp::REST, Mailchimp::JSON, Mailchimp::XML, Mailchimp::PHP, Mailchimp::LOL);

	/**
	 * The default parameters-array to include with the API-call
	 *
	 * @var array
	 */
	private static $_defaults = array();

	/**
	 * The default format to include with the API-call
	 *
	 * @var const
	 */
	private static $_default_format = Mailchimp::JSON;

	/**
	 * The dc variable is taken from the API-key
	 *
	 * @var string
	 */
	private static $_dc;


	/**
	 * Default constructor
	 *
	 * @return void
	 */
	final private function __construct()
	{
		// This is a static class
	}


	/**
	 * Set API-key for all requests
	 *
	 * @param string $apikey
	 * @return void
	 */
	public static function setApikey($apikey)
	{
		self::$_defaults['apikey'] = (string) $apikey;
		self::$_dc = substr($apikey,-3);
	}

	/**
	 * Set default format for all requests
	 *
	 * @param const Mailchimp::REST, Mailchimp::JSON, Mailchimp::XML, Mailchimp::PHP, Mailchimp::LOL $format
	 * @return void
	 */
	public static function setFormat($format)
	{
		if(in_array($format, self::$_formats))
		{
			self::$_defaults['output'] = $format;
			self::$_default_format == $format;
		}
		else
		{
			self::$_defaults['output'] = self::$_default_format;
		}
	}


	/**
	 * Makes the call to the API
	 *
	 * @param array $params	parameters for the request
	 * @return mixed
	 */
	public static function makeCall($params)
	{
		$params += self::$_defaults;

		// check if an API-key is provided
		if(!isset($params['apikey']))
		{
			throw new Exception('API-key must be set');
		}

		// check if a method is provided
		if(!isset($params['method']))
		{
			throw new Exception("Without a method this class can't call the API");
		}

		// check if a format is provided
		if(!isset($params['output']))
		{
			$params['output'] = self::$_default_format;
		}

		$url = 'http://'.self::$_dc.Mailchimp::API_URL.'?'.http_build_query($params, NULL, '&');

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);

		$results = curl_exec($ch);
		$headers = curl_getinfo($ch);

		$error_number = (int) curl_errno($ch);
		$error_message = curl_error($ch);

		curl_close($ch);

		// invalid headers
		if ( ! in_array($headers['http_code'], array(0, 200)))
		{
			throw new Exception('Bad headercode', (int) $headers['http_code']);
		}

		// are there errors?
		if ($error_number > 0)
		{
			throw new Exception($error_message, $error_number);
		}

		return $results;
	}
}
?>