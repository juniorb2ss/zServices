<?php namespace zServices\ReceitaFederal\Services\Portais\AN;

use zServices\Miscellany\Interfaces\SearchInterface;
use zServices\ReceitaFederal\Services\Portais\AN\Crawler;
use zServices\Miscellany\Exceptions\NoServiceCall;
use zServices\Miscellany\Exceptions\NoCaptchaResponse;
use zServices\Miscellany\Exceptions\NoServiceResponse;
use zServices\Miscellany\Exceptions\ImageNotFound;
use zServices\Miscellany\Exceptions\InvalidInputs;
use zServices\Miscellany\Exceptions\InvalidCaptcha;
use zServices\Miscellany\ClientHttp;
use zServices\Miscellany\Curl;

/**
* 
*/
class Search implements SearchInterface
{	
	/**
	 * Armazena a instãncia atual do request no serviço
	 * @var object
	 */
	private $instanceResponse;

	/**
	 * Armazena o cookie atual
	 * @var string
	 */
	private $cookie;

	/**
	 * Captcha request response
	 * @var string
	 */
	private $captcha;

	/**
	 * Armazena o base64 da imagem do captcha
	 * @var string base64
	 */
	private $captchaImage;

	/**
	 * @var object zServices\Sintegra\Services\ClientHttp
	 */
	private $client;

	/**
	 * Armazena as configurações para as requisições e crawler
	 * @var array
	 */
	private $configurations;

	/**
	 * [$params description]
	 * @var array
	 */
	private $params = [];

	/**
	 * Antes de chamar o cookie e o captcha, é preciso efetuar uma requisição
	 * primária no serviço. Capturando tais informações.
	 * Este método deverá fazer essa requisição, armazenando o request
	 * para os método como cookie e captcha prepararem suas informações
	 * 
	 * @param  array $configurations  @ref zServices\Sintegra\Services\Sintegra\{Service}\Service::$configurations
	 * @return object
	 */
	public function request($configurations)
	{
		$this->configurations = $configurations;

		// instancia o client http
		$this->client = new ClientHttp();

		// Executa um request para URL do serviço, retornando o cookie da requisição primária
		$this->instanceResponse = $this->client->request('GET', $this->configurations['home']);

		// Captura o cookie da requisição, será usuado posteriormente
		$this->cookie = $this->client->cookie();

		return $this;
	}

	/**
	 * Verifica se existe existencia de request
	 * @return boolean
	 */
	private function hasRequested()
	{
		if (!$this->instanceResponse) {
			throw new NoServiceCall("No request from this service, please call first method request", 1);			
		}

		return true;
	}

	/**
	 * Retorna o captcha do serviço para o usuário
	 * @return string base64_image
	 */
	public function getCaptcha()
	{ 
		$this->hasRequested();

		// Inicia instancia do cURL
		$curl = new Curl;

		// Inicia uma requisição para capturar a imagem do captcha
		// informando cookie da requisição passada e os headers
		//
		// to-do: implementar guzzlehttp?
		// ele é melhor que o curl? ou mais organizado?
		$curl->init($this->configurations['captcha']);

		// headers da requisição
		$curl->options([
						CURLOPT_COOKIEJAR => 'cookiejar',
						CURLOPT_HTTPHEADER => array(
							"Pragma: no-cache",
							"Origin: " . $this->configurations['base'],
							"Host: ". array_get($this->configurations, 'headers.Host'),
							"User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0",
							"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
							"Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3",
							"Accept-Encoding: gzip, deflate",
							"Referer: " . $this->configurations['home'],
							"Cookie: flag=1; ". $this->cookie,
							"Connection: keep-alive"
						),
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_FOLLOWLOCATION => 1,
						CURLOPT_BINARYTRANSFER => TRUE,
						CURLOPT_CONNECTTIMEOUT => 10,
						CURLOPT_TIMEOUT => 10,
				]);

		// executa o curl, logo após fechando a conexão
		$curl->exec();
		$curl->close();

		// captura do retorno do curl
		// o esperado deverá ser o HTML da imagem
		$this->captcha = $curl->response();

		// é uma imagem o retorno?
		if(@imagecreatefromstring($this->captcha) == false)
		{
			throw new NoCaptchaResponse('Não foi possível capturar o captcha');
		}

		// constroe o base64 da imagem para o usuário digitar
		// to-do: um serviço automatizado para decifrar o captcha?
		// talvez deathbycaptcha?
		$this->captchaImage = 'data:image/png;base64,' . base64_encode($this->captcha);

		return $this->captchaImage;
	}

	/**
	 * Retorna o cookie da requisição para as
	 * próximas requisições
	 * @return string $cookie
	 */
	public function getCookie()
	{ 
		$this->hasRequested();

		return $this->cookie;
	}

	/**
	 * Alguns serviços possuem outros parametros.
	 * Como por exemplo o serviço de SP.
	 * No formulário possui o input "parambot"
	 * e nas requisições posteriores é preciso enviá-lo.
	 *
	 * Este método irá buscar no crawler estes parametros avulsos.
	 * @return array $params
	 */
	public function getParams()
	{ 
		$this->hasRequested();

		return $this->params;
	}

	/**
	 * Retorna as informações da empresa/pessoa consultada.
	 * @param  integer $document Documento de identificação da entidade
	 * @param  string  $cookie   Referencia: $service->cookie()
	 * @param  string  $captcha  Texto do captcha resolvido pelo usuário
	 * @param  array   $params   Parametros avulsos de requisição. Referência $service->params()
	 * @return array   $data     Informações da entidade no serviço.
	 */
	public function getData($document, $cookie, $captcha, $params, $configurations)
	{
		// prepara o form
		$postParams = [
			'origem' => 'comprovante',
			'cnpj' => $document, // apenas números
			'txtTexto_captcha_serpro_gov_br' => $captcha,
			'submit1' => 'Consultar',
			'search_type' => 'cnpj'
		];

		$postParams = array_merge($postParams, $params);

		// inicia o cURL
		$curl = new Curl;

		// vamos registrar qual serviço será consultado
		$curl->init($configurations['data']);

		// define os headers para requisição curl.
		$curl->options(
			array(
				 CURLOPT_HTTPHEADER => array(
					"Pragma: no-cache",
					"Origin: " . $this->configurations['base'],
					"Host: ". array_get($configurations, 'headers.Host'),
					"User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0",
					"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
					"Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3",
					"Accept-Encoding: gzip, deflate",
					"Referer: " . $this->configurations['home'] .'?cnpj='. $document,
					"Cookie: flag=1; ". $cookie,
					"Connection: keep-alive"
				),
				CURLOPT_RETURNTRANSFER  => 1,
				CURLOPT_BINARYTRANSFER => 1,
				CURLOPT_FOLLOWLOCATION => 1,
			)
		);

		// efetua a chamada passando os parametros de form
		$curl->post($postParams);
		$curl->exec();

		// completa a chamda
		$curl->close();

		// vamos capturar retorno, que deverá ser o HTML para scrapping
		$html = $curl->response();

		if(empty($html)) {
			throw new NoServiceResponse('No response from service', 99);
		}

		$crawler = new Crawler($html, array_get($configurations, 'selectors.data'));

		return $crawler;
	}
}