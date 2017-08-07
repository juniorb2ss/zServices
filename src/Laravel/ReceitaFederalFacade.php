<?php

namespace zServices\Laravel;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Weidner\Goutte\Goutte
 */
class ReceitaFederalFacade extends Facade {

  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor() { return 'ReceitaFederal'; }
}