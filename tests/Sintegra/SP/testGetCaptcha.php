<?php

namespace tests\Sintegra\SP;

use PHPUnit\Framework\TestCase;
use zServices\Sintegra\Search;

class testGetCaptcha extends TestCase
{
	/**
     * @group sintegra-request
     */
    public function testGetCaptchaImage()
    {
    	$search = (new Search)->service('SP')->request();

    	$captchaRequest = $search->captcha();

    	$this->assertTrue(
	    		is_string($captchaRequest), 
	    		'Captcha returned not is valid string'
	    );
    }
}