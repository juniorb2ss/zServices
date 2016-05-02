<?php namespace zServices\Sintegra\Services\Sintegra\SP;

use zServices\Sintegra\Services\Sintegra\Interfaces\SearchInterface;
use zServices\Sintegra\Services\Sintegra\SP\Crawler;
use zServices\Sintegra\Exceptions\NoServiceCall;
use zServices\Sintegra\Exceptions\NoCaptchaResponse;
use zServices\Sintegra\Exceptions\NoServiceResponse;
use zServices\Sintegra\Exceptions\ImageNotFound;
use zServices\Sintegra\Services\ClientHttp;
use zServices\Sintegra\Services\Curl;

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
		if(!$this->instanceResponse) {
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

		$imageSrc = $this->instanceResponse->filter(
						array_get($this->configurations, 'selectors.image')
					);

		if(!$imageSrc->count()){
			throw new ImageNotFound("Impossible to crawler image from response", 1);
		}

        $paramBot = $this->instanceResponse->filter(
        				array_get($this->configurations, 'selectors.paramBot')
        			);

        if(!$paramBot->count()){
			throw new ImageNotFound("Impossible to crawler parambot from response", 1);
		}

		// Inicia instancia do cURL
        $curl = new Curl;

        // Inicia uma requisição para capturar a imagem do captcha
        // informando cookie da requisição passada e os headers
        //
        // to-do: implementar guzzlehttp?
        // ele é melhor que o curl? ou mais organizado?
        $curl->init($this->configurations['base'] . $imageSrc->attr('src'));

        $this->params['parambot'] = trim($paramBot->attr('value'));

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
                            "Referer: " . $this->configurations['captcha'],
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
            'cnpj' => $document, // apenas números
            'Key' => $captcha,
            'botao' => 'Consulta por CNPJ',
            'hidFlag' => '1',
            'ie' => '',
            'servico' => 'cnpj',
            'paramBot' => $params['parambot']
        ];

        // inicia o cURL
        $curl = new Curl;

        // vamos registrar qual serviço será consultado
        $curl->init($configurations['data']);

        // define os headers para requisição curl.
        $curl->options(
            array(
                CURLOPT_HTTPHEADER => array(
                    "Origin: http://pfeserv1.fazenda.sp.gov.br",
                    "Host: pfeserv1.fazenda.sp.gov.br",
                    "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/49.0.2623.108 Chrome/49.0.2623.108 Safari/537.36",
                    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
                    "Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.6,en;q=0.4,es;q=0.2",
                    "Accept-Encoding: gzip, deflate",
                    "Referer: http://pfeserv1.fazenda.sp.gov.br/sintegrapfe/consultaSintegraServlet",
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