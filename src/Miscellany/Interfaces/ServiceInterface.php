<?php namespace zServices\Miscellany\Interfaces;

interface ServiceInterface {

	/**
	 * [request description]
	 * @return [type] [description]
	 */
	public function request();

	/**
	 * [search description]
	 * @return [type] [description]
	 */
	public function captcha();

	/**
	 * [cookie description]
	 * @return [type] [description]
	 */
	public function cookie();

	/**
	 * [data description]
	 * @return [type] [description]
	 */
	public function data($document, $cookie, $captcha, array $params = []);
}