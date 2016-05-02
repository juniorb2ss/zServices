<?php
namespace zServices\Miscellany;

/**
*
*/
class Curl
{

	/**
	 * [$url description]
	 * @var [type]
	 */
	private $url;

	/**
	 * [$options description]
	 * @var [type]
	 */
	private $options;

	/**
	 * [$instance description]
	 * @var [type]
	 */
	private $instance;

	/**
	 * [$response description]
	 * @var [type]
	 */
	private $response;

	/**
	 * [init description]
	 * @return [type] [description]
	 */
	public function init($url)
	{
		$this->instance = curl_init($url);

		$this->url = $url;

		return $this;
	}

	/**
	 * [options description]
	 * @param  array  $options [description]
	 * @return [type]          [description]
	 */
	public function options(array $options)
	{
		$this->options = $options;

		curl_setopt_array($this->instance, $this->options);

		return $this;
	}

	/**
	 * [post description]
	 * @return [type]         [description]
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
	 * [exec description]
	 * @return [type] [description]
	 */
	public function exec()
	{
		$this->response = curl_exec($this->instance);
	}

	/**
	 * [close description]
	 * @return [type] [description]
	 */
	public function close()
	{
		curl_close($this->instance);

		return $this;
	}

	/**
	 * [response description]
	 * @return [type] [description]
	 */
	public function response()
	{
		return $this->response;
	}
}