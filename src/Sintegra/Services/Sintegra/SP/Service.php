<?php namespace zServices\Sintegra\Services\Sintegra\SP;

use zServices\Sintegra\Services\Sintegra\Interfaces\ServiceInterface;
use zServices\Sintegra\Services\Sintegra\SP\Search;

/**
* 	
*/
class Service implements ServiceInterface
{

	/**
	 * [$search description]
	 * @var [type]
	 */
	private $search;

	/**
	 * [__construct description]
	 */
	public function __construct()
	{
		$this->search = new Search;
	}
	/**
	 * [search description]
	 * @return [type] [description]
	 */
	public function captcha(){
		return 'captcha';
	}

	/**
	 * [cookie description]
	 * @return [type] [description]
	 */
	public function cookie(){
		return 'cookie';
	}

	/**
	 * [data description]
	 * @return [type] [description]
	 */
	public function data($document, $cookie, $captcha, array $params = [])
	{
		# code...
	}
}