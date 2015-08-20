<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider {

	public function register()
	{
    $this->app->bind(
			'\App\Helpers\Helper'
		);
	}

}
