<?php

use zServices\Sintegra\Search;

class testCrawlerHtmlData extends PHPUnit_Framework_TestCase
{
	public function testFileExist()
    {
    	$file = dirname(__FILE__) . '/data.html';
    	$this->assertFileExists($file, 'HTML Test file not present to crawler');
        $this->assertStringNotEqualsFile($file, '');

        return file_get_contents($file);
    }
}