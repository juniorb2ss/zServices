<?php

use zServices\Sintegra\Search;

class testInvalidCaptchaResponse extends PHPUnit_Framework_TestCase
{
    /**
     * Testa a sequência de request da classe
     * @expectedException zServices\Sintegra\Exceptions\NoServiceCall
     * @expectedExceptionMessageRegExp #No request.*#
     */
    public function testInvalidCaptcha()
    {
    	$search = (new Search)->service('SP');

    	$search = (new Sintegra)->service('SP')->request(); // initialize
		$crawler = $search->data($cnpj, $cookie, $captcha, $paramBot);
		$arrayData = $crawler->scraping(); // array com as informações da entidade
    }
}