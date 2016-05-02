<?php namespace zServices\Sintegra\Services\Interfaces;

interface CrawlerInterface {
	public function __construct($html, $selectors);
}