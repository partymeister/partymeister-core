<?php

namespace Partymeister\Core\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Partymeister\Core\Console\Commands\PartymeisterCoreCheckCallbacksCommand;
use Partymeister\Core\Console\Commands\PartymeisterCoreImportTicketsApiCommand;
use Partymeister\Core\Console\Commands\PartymeisterCoreImportTicketsCSVCommand;
use Partymeister\Core\Console\Commands\PartymeisterCoreImportTimetableFromWebsiteCommand;
use Partymeister\Core\Models\Callback;
use Partymeister\Core\Models\Component\ComponentSchedule;
use Partymeister\Core\Models\Component\ComponentVisitorLogin;
use Partymeister\Core\Models\Event;
use Partymeister\Core\Models\EventType;
use Partymeister\Core\Models\Guest;
use Partymeister\Core\Models\MessageGroup;
use Partymeister\Core\Models\Schedule;
use Partymeister\Core\Models\Visitor;

/**
 * Class PartymeisterServiceProvider
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
        merge_local_config_with_db_configuration_variables('partymeister-core');
    }

    public function config() {}

    public function routes()
    {
        if (! $this->app->routesAreCached()) {
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
            return Visitor::findOrFail($id);
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
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'partymeister-core');

        $this->publishes([
            __DIR__.'/../../resources/lang' => resource_path('lang/vendor/partymeister-core'),
        ], 'motor-admin-translations');
    }

    public function views()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'partymeister-core');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/partymeister-core'),
        ], 'motor-admin-views');
    }

    public function navigationItems()
    {
        $config = $this->app['config']->get('motor-admin-navigation', []);
        $this->app['config']->set('motor-admin-navigation', array_replace_recursive(require __DIR__.'/../../config/motor-admin-navigation.php', $config));
    }

    public function permissions()
    {
        $config = $this->app['config']->get('motor-admin-permissions', []);
        $this->app['config']->set('motor-admin-permissions', array_replace_recursive(require __DIR__.'/../../config/motor-admin-permissions.php', $config));
    }

    public function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PartymeisterCoreImportTicketsApiCommand::class,
                PartymeisterCoreImportTicketsCSVCommand::class,
                PartymeisterCoreCheckCallbacksCommand::class,
                PartymeisterCoreImportTimetableFromWebsiteCommand::class,
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
}
