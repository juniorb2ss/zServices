<?php namespace tests\ReceitaFederal\AN;

use zServices\ReceitaFederal\Search;

class testGetCaptcha extends \PHPUnit_Framework_TestCase
{
	/**
     * @group receita-request
     */
    public function testGetCaptchaImage()
    {
    	$search = (new Search)->service()->request();

    	$captchaRequest = $search->captcha();

    	$this->assertTrue(
	    		is_string($captchaRequest), 
	    		'Captcha returned not is valid string'
	    );
    }
}