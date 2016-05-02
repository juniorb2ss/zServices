<?php namespace zServices\ReceitaFederal;

use zServices\ReceitaFederal\Services\Portais\AN\Service;

/**
* Providencias os serviços e configurações
*/
class Search
{
	/**
	 * [$service description]
	 * @var [type]
	 */
	private $service;

	/**
	 * [service description]
	 * @return [type] [description]
	 */
	public function service()
	{
		$service = new Service;

		return $this->service = $service;
	}
}