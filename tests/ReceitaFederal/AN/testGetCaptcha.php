<?php

namespace zServices\Tests\ReceitaFederal\AN;

use zServices\Tests\TestCase;
use zServices\ReceitaFederal\Search;

class testGetCaptcha extends TestCase
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