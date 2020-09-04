<?php

namespace Dorcas\ModulesMarketplace;
use Illuminate\Support\ServiceProvider;

class ModulesMarketplaceServiceProvider extends ServiceProvider {

	public function boot()
	{
		$this->loadRoutesFrom(__DIR__.'/routes/web.php');
		$this->loadViewsFrom(__DIR__.'/resources/views', 'modules-marketplace');
		$this->publishes([
			__DIR__.'/config/modules-marketplace.php' => config_path('modules-marketplace.php'),
		], 'dorcas-modules');
		/*$this->publishes([
			__DIR__.'/assets' => public_path('vendor/modules-marketplace')
		], 'dorcas-modules');*/
	}

	public function register()
	{
		//add menu config
		$this->mergeConfigFrom(
	        __DIR__.'/config/navigation-menu.php', 'navigation-menu.addons.sub-menu.modules-marketplace.sub-menu'
	     );
	}

}


?>