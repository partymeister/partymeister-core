<?php

namespace Partymeister\Core\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Partymeister\Core\Console\Commands\PartymeisterCoreCheckCallbacksCommand;
use Partymeister\Core\Console\Commands\PartymeisterCoreImportTicketsApiCommand;
use Partymeister\Core\Console\Commands\PartymeisterCoreImportTicketsCSVCommand;
use Partymeister\Core\Http\Middleware\Frontend\Visitor;
use Partymeister\Core\Models\Callback;
use Partymeister\Core\Models\Component\ComponentSchedule;
use Partymeister\Core\Models\Component\ComponentVisitorLogin;
use Partymeister\Core\Models\Event;
use Partymeister\Core\Models\EventType;
use Partymeister\Core\Models\Guest;
use Partymeister\Core\Models\MessageGroup;
use Partymeister\Core\Models\Schedule;

/**
 * Class PartymeisterServiceProvider
 *
 * @package Partymeister\Core\Providers
 */
class PartymeisterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app('router')->pushMiddlewareToGroup('frontend', Visitor::class);

        $this->config();
        $this->routes();
        $this->routeModelBindings();
        $this->translations();
        $this->views();
        $this->navigationItems();
        $this->permissions();
        $this->registerCommands();
        $this->migrations();
        $this->publishResourceAssets();
        $this->components();
        merge_local_config_with_db_configuration_variables('partymeister-core');
    }

    public function config()
    {
    }

    public function routes()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/../../routes/web.php';
            require __DIR__.'/../../routes/api.php';
        }
    }

    public function routeModelBindings()
    {
        // Modules
        Route::bind('callback', function ($id) {
            return Callback::findOrFail($id);
        });
        Route::bind('schedule', function ($id) {
            return Schedule::findOrFail($id);
        });
        Route::bind('event', function ($id) {
            return Event::findOrFail($id);
        });
        Route::bind('event_type', function ($id) {
            return EventType::findOrFail($id);
        });
        Route::bind('guest', function ($id) {
            return Guest::findOrFail($id);
        });
        Route::bind('visitor', function ($id) {
            return \Partymeister\Core\Models\Visitor::findOrFail($id);
        });
        Route::bind('message_group', function ($id) {
            return MessageGroup::findOrFail($id);
        });

        // Components
        Route::bind('component_schedule', function ($id) {
            return ComponentSchedule::findOrFail($id);
        });

        Route::bind('component_visitor_login', function ($id) {
            return ComponentVisitorLogin::findOrFail($id);
        });
    }

    public function translations()
    {
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'partymeister-core');

        $this->publishes([
            __DIR__.'/../../resources/lang' => resource_path('lang/vendor/partymeister-core'),
        ], 'motor-backend-translations');
    }

    public function views()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'partymeister-core');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/partymeister-core'),
        ], 'motor-backend-views');
    }

    public function navigationItems()
    {
        $config = $this->app['config']->get('motor-backend-navigation', []);
        $this->app['config']->set('motor-backend-navigation', array_replace_recursive(require __DIR__.'/../../config/motor-backend-navigation.php', $config));
    }

    public function permissions()
    {
        $config = $this->app['config']->get('motor-backend-permissions', []);
        $this->app['config']->set('motor-backend-permissions', array_replace_recursive(require __DIR__.'/../../config/motor-backend-permissions.php', $config));
    }

    public function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PartymeisterCoreImportTicketsApiCommand::class,
                PartymeisterCoreImportTicketsCSVCommand::class,
                PartymeisterCoreCheckCallbacksCommand::class,
            ]);
        }
    }

    public function migrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }

    public function publishResourceAssets()
    {
        $assets = [
            __DIR__.'/../../resources/assets/images' => resource_path('assets/images'),
        ];

        $this->publishes($assets, 'partymeister-core-install-resources');
    }

    public function components()
    {
        $config = $this->app['config']->get('motor-cms-page-components', []);
        $this->app['config']->set('motor-cms-page-components', array_replace_recursive(require __DIR__.'/../../config/motor-cms-page-components.php', $config));
    }
}
