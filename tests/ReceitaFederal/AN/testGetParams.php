<?php namespace tests\ReceitaFederal\AN;

use zServices\ReceitaFederal\Search;

class testGetParams extends \PHPUnit_Framework_TestCase
{
    /**
     * @group receita-request
     */
    public function testGetParamsArray()
    {
    	$search = (new Search)->service()->request();

    	$paramsRequest = $search->params();
    	
    	$this->assertTrue(
	    		is_array($paramsRequest), 
	    		'Params returned not is valid array'
	    );
    }
}