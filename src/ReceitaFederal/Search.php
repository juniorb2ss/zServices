<?php namespace zServices\Sintegra;

use zServices\Sintegra\Exceptions\InvalidService;
use zServices\Sintegra\Services\Sintegra\Interfaces\ServiceInterface;

/**
* Providencias os serviços e configurações
*/
class Search
{
	/**
	 * [$services description]
	 * @var [type]
	 */
	private $services = [
		'SP' => \zServices\Sintegra\Services\Sintegra\SP\Service::class,
	];

	/**
	 * [$service description]
	 * @var [type]
	 */
	private $service;

	/**
	 * [service description]
	 * @return [type] [description]
	 */
	public function service($service)
	{
		if(array_key_exists($service, $this->services) && class_exists($this->services[$service])){
			$service = new $this->services[$service];

			if($service instanceof ServiceInterface){
				return $this->service = $service;
			}
		}

		throw new InvalidService("Portal $service invalid", 1);
	}
}