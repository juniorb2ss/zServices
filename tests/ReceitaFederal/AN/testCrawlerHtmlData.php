<?php namespace tests\ReceitaFederal\AN;

use zServices\ReceitaFederal\Search;
use zServices\ReceitaFederal\Services\Portais\AN\Crawler;
use zServices\ReceitaFederal\Services\Portais\AN\Service;

class testCrawlerHtmlData extends \PHPUnit_Framework_TestCase
{   
    /**
     * @group receita-crawler
     */
	public function testFileExist()
    {
    	$file = dirname(__FILE__) . '/data.html';
    	$this->assertFileExists($file, 'HTML Test file not present to crawler');
        $this->assertStringNotEqualsFile($file, '');

        return file_get_contents($file);
    }

    /**
     * @group receita-crawler
     * @depends testFileExist
     */
    public function testCrawlerHtmlBody($html)
    {
        $service = new Service;
        $configurations = $service->configurations;

    	$crawler = new Crawler($html, array_get($configurations, 'selectors.data'));
        $scraped = $crawler->scraping();

        $this->assertTrue(
                (is_array($scraped) && count($scraped) > 0), 
                'Params returned not is valid array'
        );

        $this->assertArrayHasKey('numero_inscricao', $scraped, 'Scraped fail');

        $this->assertEquals('14.050.180/0001-20', array_get($scraped, 'numero_inscricao'), 'Scraped fail');
    }
}