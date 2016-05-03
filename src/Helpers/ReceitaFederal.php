<?php

if (!function_exists('receitafederal'))
{
	/**
	 * Helper retorna informações da Receita Federal
	 * @SuppressWarnings(PHPMD)
	 * @param  integer $document CNPJ
	 * @param  string $cookie   cookie request
	 * @param  string $captcha  Captcha resolvido
	 * @return array
	 */
	function receitaFederal($document = false, $cookie = false, $captcha = false)
	{	
		/**
		 * Inicia a classe
		 * @var object \zServices\ReceitaFederal\Services\Portais\{$portal}\Service
		 */
		$search = (new \zServices\ReceitaFederal\Search)->service();

		/**
		 * @var array data
		 */
		if ($document == true && $cookie == true && $captcha == true) {
			$crawler = $search->data($document, $cookie, $captcha, []);

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