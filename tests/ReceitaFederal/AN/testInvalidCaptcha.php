<?php namespace tests\ReceitaFederal\AN;

use zServices\ReceitaFederal\Search;

class testInvalidCaptcha extends \PHPUnit_Framework_TestCase
{
    /**
     * Testa retorno de captcha inválido
     * @expectedException \zServices\Miscellany\Exceptions\InvalidCaptcha
     * @expectedExceptionMessageRegExp #Captcha.*#
     * @group receita-captcha
     */
    public function testInvalidCaptchResponse()
    {
    	$search = (new Search)->service();

    	$crawler = $search->data('54787138000101', 'ASPSESSIONIDCQBTACCD=FPLIJJJDCCDHPBFKEHECKNGJ', 'AIUJD', []);

        $crawler->scraping();
    }
}