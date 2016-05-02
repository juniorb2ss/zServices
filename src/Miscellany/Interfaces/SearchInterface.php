<?php namespace zServices\Miscellany\Interfaces;

interface SearchInterface {

	/**
	 * Executa primeira requisição no serviço
	 * @param  [type] $configurations [description]
	 * @return [type]                 [description]
	 */
	public function request($configurations);

	/**
	 * Get Captcha
	 * @return string
	 */
	public function getCaptcha();

	/**
	 * Get Cookie string
	 * @return string 
	 */
	public function getCookie();

	/**
	 * Get params
	 * @return array
	 */
	public function getParams();

	/**
	 * Get Data from request
	 * @param  integer $document      
	 * @param  string $cookie   Cookie request
	 * @param  string $captcha  Captcha response     
	 * @param  array $params   Params
	 * @param  array $configurations Configurations
	 * @return array                
	 */
	public function getData($document, $cookie, $captcha, $params, $configurations);
}