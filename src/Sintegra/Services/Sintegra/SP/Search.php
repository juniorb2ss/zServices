<?php namespace zServices\Sintegra\Services\Sintegra\SP;

use zServices\Sintegra\Services\Sintegra\Interfaces\SearchInterface;
use zServices\Sintegra\Services\Sintegra\SP\Crawler;

/**
* 
*/
class Search extends Crawler implements SearchInterface
{
	/**
	 * Retorna o captcha do serviço para o usuário
	 * @return string base64_image
	 */
	public function getCaptcha($configurations)
	{ 
		return 'captcha';
	}

	/**
	 * Retorna o cookie da requisição para as
	 * próximas requisições
	 * @return string $cookie
	 */
	public function getCookie($configurations)
	{ 
		return 'cookie';
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
	public function getParams($configurations)
	{ 
		return [];
	}

	/**
	 * Retorna as informações da empresa/pessoa consultada.
	 * @param  integer $document Documento de identificação da entidade
	 * @param  string  $cookie   Referencia: $service->cookie()
	 * @param  string  $captcha  Texto do captcha resolvido pelo usuário
	 * @param  array   $params   Parametros avulsos de requisição. Referência $service->params()
	 * @return array   $data     Informações da entidade no serviço.
	 */
	public function getData($document, $cookie, $captcha, $params)
	{
		return [];
	}
}