<?php namespace zServices\Sintegra\Services\Sintegra\Interfaces;

interface SearchInterface {

	/**
	 * Executa primeira requisição no serviço
	 * @param  [type] $configurations [description]
	 * @return [type]                 [description]
	 */
	public function request($configurations);

	/**
	 * [search description]
	 * @return [type] [description]
	 */
	public function getCaptcha();

	/**
	 * [cookie description]
	 * @return [type] [description]
	 */
	public function getCookie();

	/**
	 * [params description]
	 * @return [type] [description]
	 */
	public function getParams();

	/**
	 * [getData description]
	 * @param  [type] $configurations [description]
	 * @return [type]                 [description]
	 */
	public function getData($document, $cookie, $captcha, $params, $configurations);
}