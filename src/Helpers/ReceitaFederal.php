<?php

if (!function_exists('receitafederal'))
{
	/**
	 * Helper retorna informações da Receita Federal
	 * @param  integer $document CNPJ
	 * @param  string $cookie   cookie request
	 * @param  string $captcha  Captcha resolvido
	 * @return array
	 */
	function receitaFederal($document = false, $cookie = false, $captcha = false, $params = [])
	{	
		/**
		 * Inicia a classe
		 * @var object \zServices\ReceitaFederal\Services\Portais\{$portal}\Service
		 */
		$search = (new \zServices\ReceitaFederal\Search)->service();

		/**
		 * @var array data
		 */
		if($document && $cookie && $captcha) {
			$crawler = $search->data($document, $cookie, $captcha, $params);

			return $crawler->scraping();
		}

		// Se não retorna requisição inicial
		// com cookie e captcha
		$search->request();

		return  [
            'cookie' => $search->cookie(),
            'image'  => $search->captcha()
        ];
	}
}