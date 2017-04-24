<?php namespace zServices\ReceitaFederal\Services\Portais\AN;

use Captcha\Interfaces\ServiceInterface as DecaptcherServiceInterface;
use zServices\Miscellany\Interfaces\ServiceInterface;
use zServices\ReceitaFederal\Services\Portais\AN\Search;

/**
 *
 */
class Service implements ServiceInterface {
	/**
	 * Armazena as URLs e selectors do serviço a ser consultado
	 * @var array
	 */
	public $configurations = [
		'base' => 'http://www.receita.fazenda.gov.br',
		'home' => 'http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/Cnpjreva_Solicitacao2.asp',
		'captcha' => 'http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/captcha/gerarCaptcha.asp',
		'data' => 'http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/valida.asp',
		'selectors' => [
			'image' => '',
			'data' => [
				'error' => '#principal > table:nth-child(3) > tr:nth-child(2) > td > b > font',
				'numero_inscricao' => '#principal > table:nth-child(3) > tr > td > table:nth-child(3) > tr > td:nth-child(1) > font:nth-child(3) > b:nth-child(1)',
				'classificacao' => '#principal > table:nth-child(3) > tr > td > table:nth-child(3) > tr > td:nth-child(1) > font:nth-child(3) > b:nth-child(3)',
				'data_abertura' => '#principal > table:nth-child(3) > tr > td > table:nth-child(3) > tr > td:nth-child(3) > font:nth-child(3) > b',
				'nome_empresarial' => '#principal > table:nth-child(3) > tr > td > table:nth-child(5) > tr > td > font:nth-child(3) > b',
				'nome_fantasia' => '#principal > table:nth-child(3) > tr > td > table:nth-child(7) > tr > td > font:nth-child(3) > b',
				'cnae_principal' => '#principal > table:nth-child(3) > tr > td > table:nth-child(9) > tr > td > font:nth-child(3) > b',
				'cnae_secundarios' => ['#principal > table:nth-child(3) > tr > td > table:nth-child(11) > tr > td' => 'td > font > b'],
				'natureza_juridica' => '#principal > table:nth-child(3) > tr > td > table:nth-child(13) > tr > td > font:nth-child(3) > b',
				'endereco' => '#principal > table:nth-child(3) > tr > td > table:nth-child(15) > tr > td:nth-child(1) > font:nth-child(3) > b',
				'numero' => '#principal > table:nth-child(3) > tr > td > table:nth-child(15) > tr > td:nth-child(3) > font:nth-child(3) > b',
				'complemento' => '#principal > table:nth-child(3) > tr > td > table:nth-child(15) > tr > td:nth-child(5) > font:nth-child(3) > b',
				'cep' => '#principal > table:nth-child(3) > tr > td > table:nth-child(17) > tr > td:nth-child(1) > font:nth-child(3) > b',
				'distrito' => '#principal > table:nth-child(3) > tr > td > table:nth-child(17) > tr > td:nth-child(3) > font:nth-child(3) > b',
				'municipio' => '#principal > table:nth-child(3) > tr > td > table:nth-child(17) > tr > td:nth-child(5) > font:nth-child(3) > b',
				'uf' => '#principal > table:nth-child(3) > tr > td > table:nth-child(17) > tr > td:nth-child(7) > font:nth-child(3) > b',
				'email' => '#principal > table:nth-child(3) > tr > td > table:nth-child(19) > tr > td:nth-child(1) > font:nth-child(3) > b',
				'telefone' => '#principal > table:nth-child(3) > tr > td > table:nth-child(19) > tr > td:nth-child(3) > font:nth-child(3) > b',
				'efr' => '#principal > table:nth-child(3) > tr > td > table:nth-child(21) > tr > td > font:nth-child(3) > b',
				'situacao' => '#principal > table:nth-child(3) > tr > td > table:nth-child(23) > tr > td:nth-child(1) > font:nth-child(3) > b',
				'data_situacao' => '#principal > table:nth-child(3) > tr > td > table:nth-child(23) > tr > td:nth-child(3) > font:nth-child(3) > b',
				'motivo_situacao' => '#principal > table:nth-child(3) > tr > td > table:nth-child(25) > tr > td:nth-child(3) > font:nth-child(3) > b',
				'situacao_especial' => '#principal > table:nth-child(3) > tr > td > table:nth-child(27) > tr > td:nth-child(1) > font:nth-child(3) > b',
				'data_situacao_especial' => '#principal > table:nth-child(3) > tr > td > table:nth-child(27) > tr > td:nth-child(3) > font:nth-child(3) > b',
			],
		],
		'headers' => [
			'Origin' => 'http://www.receita.fazenda.gov.br',
			'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0',
			'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
			'Accept-Language' => 'pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3',
			'Accept-Encoding' => 'gzip, deflate',
			'Host' => 'www.receita.fazenda.gov.br',
		],
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
	public function __construct() {
		$this->search = new Search;
	}

	/**
	 * Executa primeira requisição preparando
	 * o cookie e captcha
	 * @return  Service
	 */
	public function request() {
		$this->search->request($this->configurations);

		return $this;
	}

	/**
	 * Retorna o base64 da imagem do captcha
	 * @return string base64_image
	 */
	public function captcha() {
		return $this->search->getCaptcha();
	}

	/**
	 * Cookie da requisição
	 * @return string
	 */
	public function cookie() {
		return $this->search->getCookie();
	}

	/**
	 * DecaptcherServiceInterface from decaptcher
	 *
	 * Impoe o serviço a ser utilizado para efetuar a quebra do captcha
	 * @param  DecaptcherServiceInterface $decaptcher
	 * @return Search
	 */
	public function decaptcher(DecaptcherServiceInterface $decaptcher) {
		$this->search->decaptcher = $decaptcher;

		return $this;
	}

	/**
	 * Get params
	 * @return array
	 */
	public function params() {
		return $this->search->getParams();
	}

	/**
	 * Informações da entidade no serviço
	 * @param boolean $document
	 * @param false|string $cookie
	 * @param false|string $captcha
	 * @return array
	 */
	public function data($document, $cookie, $captcha, array $params = []) {
		return $this->search->getData($document, $cookie, $captcha, $params, $this->configurations);
	}
}
