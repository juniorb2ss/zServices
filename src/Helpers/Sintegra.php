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
	function sintegra($portal = 'SP', $document = null, $cookie = null, $captcha = null, $params = null )
	{	
		/**
		 * Inicia a classe
		 * @var object \zServices\Sintegra\Services\Portais\{$portal}\Service
		 */
		$search = (new \zServices\Sintegra\Search)->service($portal);

		// Esta pesquisando por um documento?
		if($document && $cookie && $captcha && $params) {
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