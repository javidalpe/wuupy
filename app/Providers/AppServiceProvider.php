<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;
use Laravel\Dusk\DuskServiceProvider;
use Laravel\Dusk\Browser;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Blade::directive('money', function ($amount) {
          return "<?php echo('$' . $amount/100.0); ?>";
      });

      Blade::directive('plan', function ($plan) {
          return "<?php echo('$' . config('plans.' . $plan)/100.0); ?>/month";
      });

      Blade::directive('date', function ($epoch) {
          return '<?php $dt=new DateTime("@' . $epoch . '");echo($dt->format("Y-m-d")); ?>';
      });

      Browser::$storeScreenshotsAt = storage_path() . '/logs/';
      Browser::$storeConsoleLogAt = storage_path() . '/logs/';

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(DuskServiceProvider::class);
    }
}
