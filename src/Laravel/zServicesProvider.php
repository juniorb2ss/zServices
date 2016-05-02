<?php namespace zServices\Laravel;

use zServices\Sintegra\Search;
use zServices\ReceitaFederal\Search as RFSearch;
use Illuminate\Support\ServiceProvider;

class zServicesProvider extends ServiceProvider {

  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = false;

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    $this->registerSintegra();
    $this->registerReceitaFederal();

    $this->app->alias('Sintegra', 'zServices\Sintegra\Search');
    $this->app->alias('ReceitaFederal', 'zServices\ReceitaFederal\Search');
  }

  /**
   * Register the Sintegra instance.
   *
   * @return void
   */
  protected function registerReceitaFederal()
  {
    $this->app->bind('ReceitaFederal', function(){
        return new RFSearch;
    });
  }

  /**
   * Register the Sintegra instance.
   *
   * @return void
   */
  protected function registerSintegra()
  {
    $this->app->bind('Sintegra', function(){
        return new Search;
    });
  }
}