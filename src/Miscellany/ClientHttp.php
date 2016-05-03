<?php
namespace zServices\Miscellany;

use Goutte\Client as BaseClient;

/**
*
*/
class ClientHttp extends BaseClient
{
	/**
	 * Method request
	 * @var string
	 */
	protected $method;

	/**
	 * URL to Request
	 * @var string
	 */
	protected $url;

	/**
	 * Cookie string
	 * @var string
	 */
	protected $cookie;

	/**
	 * Response from request
	 * @var string
	 */
	protected $response;

	/**
	 * Request to URL
	 * @SuppressWarnings(PHPMD)
	 * @param  string  $method        
	 * @param  string  $url           
	 * @param  array   $parameters    
	 * @param  array   $files        
	 * @param  array   $server        
	 * @param  string  $content       
	 * @param  boolean $changeHistory 
	 * @return @instance
	 */
	public function request($method, $url, array $parameters = array(), array $files = array(), array $server = array(), $content = null, $changeHistory = true)
	{
		$this->method = $method;
		$this->url = $url;

		return parent::request($this->method, $this->url, $parameters, $files, $server, $content, $changeHistory);
	}

	/**
	 * get headers from response
	 * @return string
	 */
	private function headers()
	{
		return $this->response->getHeaders();
	}

	/**
	 * get cookie from response
	 * @return string
	 */
	public function cookie()
	{
		return $this->headers()['Set-Cookie'][0];
	}
}