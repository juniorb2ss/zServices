<?php namespace zServices\Sintegra\Services\Sintegra\SP;

use zServices\Sintegra\Services\Sintegra\Interfaces\SearchInterface;
use zServices\Sintegra\Services\Sintegra\SP\Crawler;

/**
* 
*/
class Search extends Crawler implements SearchInterface
{
	/**
	 * [search description]
	 * @return [type] [description]
	 */
	public function getCaptcha($configurations)
	{ 
		return 'captcha';
	}

	/**
	 * [cookie description]
	 * @return [type] [description]
	 */
	public function getCookie($configurations)
	{ 
		return 'cookie';
	}

	/**
	 * [params description]
	 * @return [type] [description]
	 */
	public function getParams($configurations)
	{ 
		return [];
	}

	/**
	 * [getData description]
	 * @param  [type] $configurations [description]
	 * @return [type]                 [description]
	 */
	public function getData($document, $cookie, $captcha, $params)
	{
		return [];
	}
}