<?php namespace zServices\ReceitaFederal;

use zServices\ReceitaFederal\Services\Portais\AN\Service;

/**
* Providencias os serviços e configurações
*/
class Search
{
	/**
	 * Service instance
	 * @var object
	 */
	private $service;

	/**
	 * Get service instance
	 * @return object
	 */
	public function service()
	{
		$service = new Service;

		return $this->service = $service;
	}
}