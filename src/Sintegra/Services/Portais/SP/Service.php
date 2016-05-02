<?php namespace zServices\Sintegra\Services\Portais\SP;

use zServices\Miscellany\Interfaces\ServiceInterface;
use zServices\Sintegra\Services\Portais\SP\Search;

/**
* 	
*/
class Service implements ServiceInterface
{
	/**
	 * Armazena as URLs e selectors do serviço a ser consultado
	 * @var array
	 */
	public $configurations = [
		'base' 		=> 'http://pfeserv1.fazenda.sp.gov.br',
		'home' 		=> 'http://pfeserv1.fazenda.sp.gov.br/sintegrapfe/consultaSintegraServlet',
		'captcha' 	=> 'http://pfeserv1.fazenda.sp.gov.br/sintegrapfe/consultaSintegraServlet',
		'data'		=> 'http://pfeserv1.fazenda.sp.gov.br/sintegrapfe/sintegra',
		'selectors'	=> [
			'image' 	=> 'body > center > table > tr > td > form > table > tbody > tr:nth-child(1) > td:nth-child(3) > img',
			'paramBot' 	=> 'body > center > table > tr > td > form > input[type="hidden"]:nth-child(2)',			
			'data'		=> [
				'error' => 'body > center:nth-child(8) > table > tr > td > font > b',
				'inscricao_estadual'  => 'body > center:nth-child(9) > table > tr > td:nth-child(4) > font',
				'razao_social' => 'body > center:nth-child(10) > table > tr > td:nth-child(2) > font',
				'logradouro' => 'body > center:nth-child(13) > table > tr > td:nth-child(2) > font',
				'numero'    => 'body > center:nth-child(14) > table > tr > td:nth-child(2) > font',
				'complemento' => 'body > center:nth-child(14) > table > tr > td:nth-child(4) > font',
				'bairro'    => 'body > center:nth-child(15) > table > tr > td:nth-child(2) > font',
				'municipio' => 'body > center:nth-child(16) > table > tr > td:nth-child(2) > font',
				'uf'        => 'body > center:nth-child(16) > table > tr > td:nth-child(4) > font',
				'cep'  => 'body > center:nth-child(17) > table > tr > td:nth-child(2) > font',
				'atividade_economica' => 'body > center:nth-child(20) > table > tr > td:nth-child(2) > font',
				'situacao'  => 'body > center:nth-child(21) > table > tr > td:nth-child(2) > font',
				'situacao2'  => 'body > center:nth-child(21) > table > tr > td:nth-child(3) > font',
				'data_situacao' => 'body > center:nth-child(22) > table > tr > td:nth-child(2) > font',
				'regime'    => 'body > center:nth-child(23) > table > tr > td:nth-child(2) > font',
				'data_emissor_nfe'  => 'body > center:nth-child(24) > table > tr > td:nth-child(2) > font',
				'indicator_obrigatoriedade_nfe' => 'body > center:nth-child(25) > table > tr > td:nth-child(2) > font',
				'data_inicio_obrigatoriedade_nfe'   => 'body > center:nth-child(26) > table > tr > td:nth-child(2) > font',
				'consulta'  => 'body > center:nth-child(28) > table > tr:nth-child(2) > td:nth-child(2) > font > b',
				'observacoes'   => 'body > center:nth-child(30) > table > tr > td > font:nth-child(1)',
			]
		],
		'headers' => [
			'Origin'			=> 'http://pfeserv1.fazenda.sp.gov.br',
			'User-Agent' 		=> 'Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0',
			'Accept' 			=> 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
			'Accept-Language' 	=> 'pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3',
			'Accept-Encoding'	=> 'gzip, deflate',
			'Host'				=> 'pfeserv1.fazenda.sp.gov.br'
		]
	];

	/**
	 * Search instance
	 * @var object
	 */
	private $search;

	/**
	 * Get search instance
	 * @return void
	 */
	public function __construct()
	{
		$this->search = new Search;
	}

	/**
	 * Executa primeira requisição preparando
	 * o cookie e captcha
	 * @return  void
	 */
	public function request()
	{
		$this->search->request($this->configurations);

		return $this;
	}

	/**
	 * Retorna o base64 da imagem do captcha
	 * @return string base64_image
	 */
	public function captcha()
	{
		return $this->search->getCaptcha();
	}

	/**
	 * Cookie da requisição
	 * @return string
	 */
	public function cookie()
	{
		return $this->search->getCookie();
	}

	/**
	 * Get params
	 * @return array
	 */
	public function params()
	{
		return $this->search->getParams();
	}

	/**
	 * Informações da entidade no serviço
	 * @return array
	 */
	public function data($document, $cookie, $captcha, array $params = [])
	{
		return $this->search->getData($document, $cookie, $captcha, $params, $this->configurations);
	}
}