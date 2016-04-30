<?php namespace zServices\Sintegra\Services\Sintegra\Interfaces;

interface SearchInterface {

	/**
	 * [search description]
	 * @return [type] [description]
	 */
	public function getCaptcha($configurations);

	/**
	 * [cookie description]
	 * @return [type] [description]
	 */
	public function getCookie($configurations);

	/**
	 * [params description]
	 * @return [type] [description]
	 */
	public function getParams($configurations);

	/**
	 * [getData description]
	 * @param  [type] $configurations [description]
	 * @return [type]                 [description]
	 */
	public function getData($document, $cookie, $captcha, $params);
}