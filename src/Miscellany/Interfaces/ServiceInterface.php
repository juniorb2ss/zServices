<?php namespace zServices\Miscellany\Interfaces;

interface ServiceInterface {

	/**
	 * Return request
	 * @return object
	 */
	public function request();

	/**
	 * Return captcha string
	 * @return string
	 */
	public function captcha();

	/**
	 * Return cookie string
	 * @return string
	 */
	public function cookie();

	/**
	 * Return data
	 * @return array
	 */
	public function data($document, $cookie, $captcha, array $params = []);
}