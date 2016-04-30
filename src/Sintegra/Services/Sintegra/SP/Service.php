<?php namespace zServices\Sintegra\Services\Sintegra\SP;

use zServices\Sintegra\Services\Sintegra\Interfaces\ServiceInterface;
use zServices\Sintegra\Services\Sintegra\SP\Search;

/**
* 	
*/
class Service implements ServiceInterface
{
	/**
	 * Armazena as URLs e selectors do serviço a ser consultado
	 * @var array
	 */
	private $configurations = [
		'base' 		=> 'http://pfeserv1.fazenda.sp.gov.br',
		'home' 		=> 'http://pfeserv1.fazenda.sp.gov.br/sintegrapfe/consultaSintegraServlet',
		'captcha' 	=> 'http://pfeserv1.fazenda.sp.gov.br/sintegrapfe/consultaSintegraServlet',
		'data'		=> 'http://pfeserv1.fazenda.sp.gov.br/sintegrapfe/sintegra',
		'selectors'	=> [
			'image' 	=> 'body > center > table > tr > td > form > table > tr:nth-child(1) > td:nth-child(3) > img',
			'paramBot' 	=> 'body > center > table > tr > td > form > input[type="hidden"]:nth-child(2)'
		],
		'headers' => [
			'User-Agent' 		=> 'Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0',
			'Accept' 			=> 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
			'Accept-Language' 	=> 'pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3',
			'Accept-Encoding'	=> 'gzip, deflate',
			'Host'				=> 'http://pfeserv1.fazenda.sp.gov.br'
		]
	];

	/**
	 * [$search description]
	 * @var [type]
	 */
	private $search;

	/**
	 * [__construct description]
	 */
	public function __construct()
	{
		$this->search = new Search;
	}
	/**
	 * [search description]
	 * @return [type] [description]
	 */
	public function captcha()
	{
		return $this->search->getCaptcha($this->configurations);
	}

	/**
	 * [cookie description]
	 * @return [type] [description]
	 */
	public function cookie()
	{
		return $this->search->getCookie($this->configurations);
	}

	/**
	 * [params description]
	 * @return [type] [description]
	 */
	public function params()
	{
		return $this->search->getParams($this->configurations);
	}

	/**
	 * [data description]
	 * @return [type] [description]
	 */
	public function data($document, $cookie, $captcha, array $params = [])
	{
		return $this->search->getData($document, $cookie, $captcha, $params);
	}
}