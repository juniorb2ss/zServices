<?php namespace zServices\ReceitaFederal\Services\Portais\AN;

use zServices\Miscellany\Interfaces\ServiceInterface;
use zServices\ReceitaFederal\Services\Portais\AN\Search;

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
		'base' 		=> 'http://www.receita.fazenda.gov.br',
		'home' 		=> 'http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/Cnpjreva_Solicitacao2.asp',
		'captcha' 	=> 'http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/captcha/gerarCaptcha.asp',
		'data'		=> 'http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/valida.asp',
		'selectors'	=> [
			'image' 	=> '',		
			'data'		=> [
				'error' => 'body > table:nth-child(3) > tr:nth-child(2) > td > b > font',
				'numero_inscricao'  => 'body > table:nth-child(3) > tr > td > table:nth-child(3) > tr > td:nth-child(1) > font:nth-child(3) > b:nth-child(1)',
				'classificacao'     => 'body > table:nth-child(3) > tr > td > table:nth-child(3) > tr > td:nth-child(1) > font:nth-child(3) > b:nth-child(3)',
				'data_abertura'     => 'body > table:nth-child(3) > tr > td > table:nth-child(3) > tr > td:nth-child(3) > font:nth-child(3) > b',
				'nome_empresarial'  => 'body > table:nth-child(3) > tr > td > table:nth-child(5) > tr > td > font:nth-child(3) > b',
				'nome_fantasia'     => 'body > table:nth-child(3) > tr > td > table:nth-child(7) > tr > td > font:nth-child(3) > b',
				'cnae_principal'    => 'body > table:nth-child(3) > tr > td > table:nth-child(9) > tr > td > font:nth-child(3) > b',
				'cnae_secundarios'  => ['body > table:nth-child(3) > tr > td > table:nth-child(11) > tr > td' => 'td > font > b'],
				'natureza_juridica' => 'body > table:nth-child(3) > tr > td > table:nth-child(13) > tr > td > font:nth-child(3) > b',
				'endereco'          => 'body > table:nth-child(3) > tr > td > table:nth-child(15) > tr > td:nth-child(1) > font:nth-child(3) > b',
				'numero'            => 'body > table:nth-child(3) > tr > td > table:nth-child(15) > tr > td:nth-child(3) > font:nth-child(3) > b',
				'complemento'       => 'body > table:nth-child(3) > tr > td > table:nth-child(15) > tr > td:nth-child(5) > font:nth-child(3) > b',
				'cep'               => 'body > table:nth-child(3) > tr > td > table:nth-child(17) > tr > td:nth-child(1) > font:nth-child(3) > b',
				'distrito'          => 'body > table:nth-child(3) > tr > td > table:nth-child(17) > tr > td:nth-child(3) > font:nth-child(3) > b',
				'municipio'         => 'body > table:nth-child(3) > tr > td > table:nth-child(17) > tr > td:nth-child(5) > font:nth-child(3) > b',
				'uf'                => 'body > table:nth-child(3) > tr > td > table:nth-child(17) > tr > td:nth-child(7) > font:nth-child(3) > b',
				'email'             => 'body > table:nth-child(3) > tr > td > table:nth-child(19) > tr > td:nth-child(1) > font:nth-child(3) > b',
				'telefone'          => 'body > table:nth-child(3) > tr > td > table:nth-child(19) > tr > td:nth-child(3) > font:nth-child(3) > b',
				'efr'               => 'body > table:nth-child(3) > tr > td > table:nth-child(21) > tr > td > font:nth-child(3) > b',
				'situacao'          => 'body > table:nth-child(3) > tr > td > table:nth-child(23) > tr > td:nth-child(1) > font:nth-child(3) > b',
				'data_situacao'     => 'body > table:nth-child(3) > tr > td > table:nth-child(23) > tr > td:nth-child(3) > font:nth-child(3) > b',
				'motivo_situacao'   => 'body > table:nth-child(3) > tr > td > table:nth-child(25) > tr > td:nth-child(3) > font:nth-child(3) > b',
				'situacao_especial' => 'body > table:nth-child(3) > tr > td > table:nth-child(27) > tr > td:nth-child(1) > font:nth-child(3) > b',
				'data_situacao_especial' => 'body > table:nth-child(3) > tr > td > table:nth-child(27) > tr > td:nth-child(3) > font:nth-child(3) > b'
			]
		],
		'headers' => [
			'Origin'			=> 'http://www.receita.fazenda.gov.br',
			'User-Agent' 		=> 'Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0',
			'Accept' 			=> 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
			'Accept-Language' 	=> 'pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3',
			'Accept-Encoding'	=> 'gzip, deflate',
			'Host'				=> 'www.receita.fazenda.gov.br'
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