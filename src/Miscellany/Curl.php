<?php
namespace zServices\Miscellany;

/**
*
*/
class Curl
{

	/**
	 * URL to Request
	 * @var string
	 */
	private $url;

	/**
	 * Options to request
	 * @var array
	 */
	private $options = [];

	/**
	 * Object instance
	 * @var object
	 */
	private $instance;

	/**
	 * Response from request
	 * @var string
	 */
	private $response;

	/**
	 * Initialize
	 * @param string $url
	 * @return Curl
	 */
	public function init($url)
	{
		$this->instance = curl_init($url);

		$this->url = $url;

		return $this;
	}

	/**
	 * Set option
	 * @param  array  $options
	 * @return Curl
	 */
	public function options(array $options)
	{
		$this->options = $options;

		curl_setopt_array($this->instance, $this->options);

		return $this;
	}

	/**
	 * POST Params
	 * @return Curl
	 */
	public function post(array $fields)
	{
		$this->option(CURLOPT_POST, count($fields));
		$this->option(CURLOPT_POSTFIELDS, http_build_query($fields));

		return $this;
	}

	/**
	 * Set option in cURL
	 * @param  integer $option 
	 * @param  mix $value 
	 */
	public function option($option, $value)
	{
		curl_setopt($this->instance, $option, $value);
	}

	/**
	 * Request
	 */
	public function exec()
	{
		$this->response = curl_exec($this->instance);
	}

	/**
	 * Close connection
	 * @return Curl
	 */
	public function close()
	{
		curl_close($this->instance);

		return $this;
	}

	/**
	 * Return response from request
	 * @return string
	 */
	public function response()
	{
		return $this->response;
	}
}