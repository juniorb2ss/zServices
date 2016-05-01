<?php namespace zServices\Sintegra\Services\Sintegra\Interfaces;

interface CrawlerInterface {
	public function __construct($html, $selectors);
}