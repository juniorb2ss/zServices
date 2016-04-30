<?php

use zServices\Sintegra\Search;
use zServices\Sintegra\Services\Sintegra\SP\Service;
use zServices\Sintegra\Services\Sintegra\Interfaces\ServiceInterface;

class testService extends PHPUnit_Framework_TestCase
{
	public function testServiceExist()
    {
    	$search = new Search;

    	$service = $search->service('SP');

    	$this->assertInstanceOf(ServiceInterface::class, $service);

    	if (!is_a($service, Service::class)) {
    		$this->assertNotTrue(true, 'Class returned invalid');
    	}
    }

    /**
     * @expectedException zServices\Sintegra\Exceptions\InvalidService
     * @expectedExceptionMessageRegExp #Portal.*#
     */
    public function testServiceNotExist()
    {
    	$search = (new Search)->service('no_service');
    }
}