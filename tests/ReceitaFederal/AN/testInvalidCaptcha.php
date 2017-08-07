<?php

namespace zServices\Tests\ReceitaFederal\AN;

use zServices\Tests\TestCase;
use zServices\ReceitaFederal\Search;

class testInvalidCaptcha extends TestCase
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