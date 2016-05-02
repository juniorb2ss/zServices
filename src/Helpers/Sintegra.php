<?php
if (!function_exists('sintegra'))
{
	/**
	 * Helper retorna informações do sintegra
	 * @param  integer $document CNPJ or IE
	 * @param  string $cookie   cookie request
	 * @param  string $captcha  Captcha resolvido
	 * @param  array $params   
	 * @return array
	 */
	function sintegra($portal = 'SP', $document = false, $cookie = false, $captcha = false, $params = false)
	{	
		/**
		 * Inicia a classe
		 * @var object \zServices\Sintegra\Services\Portais\{$portal}\Service
		 */
		$search = (new \zServices\Sintegra\Search)->service($portal);

		/**
		 * @var array data
		 */
		if ($document == true && $cookie == true && $captcha == true && $params == true) {
			$crawler = $search->data($document, $cookie, $captcha, $params);

			return $crawler->scraping();
		}

		// Se não retorna requisição inicial
		// com cookie e captcha
		$search->request();

		return  [
            'cookie' => $search->cookie(),
            'image'  => $search->captcha(),
            'paramBot' => $search->params()['parambot']
        ];
	}
}