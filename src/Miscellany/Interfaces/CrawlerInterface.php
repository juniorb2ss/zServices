<?php namespace zServices\Miscellany\Interfaces;

interface CrawlerInterface {
	public function __construct($html, $selectors);
}