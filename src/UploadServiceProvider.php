<?php

namespace Upload;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Upload\Console\BuildRedisHashesCommand;
use Upload\Console\CleanUpDirectoryCommand;
use Upload\Console\ListGroupDirectoryCommand;
use Upload\Console\PublishCommand;
use League\Flysystem\Filesystem;

class UploadServiceProvider extends ServiceProvider
{

    protected $defer = false;

    public function boot()
    {

        $this->loadViewsFrom(__DIR__ . '/../views', 'upload');

        $this->loadTranslationsFrom(__DIR__ . '/../translations', 'upload');

        $this->publishes([
            __DIR__ . '/../config/upload.php'         => config_path('upload.php'),
            __DIR__ . '/../assets/upload-all.js'      => public_path('vendor/upload/js/upload-all.js'),
            __DIR__ . '/../assets/upload-core.js'     => public_path('vendor/upload/js/upload-core.js'),
            __DIR__ . '/../uploads/upload_file'       => storage_path('app/upload/file'),
            __DIR__ . '/../uploads/upload_header'     => storage_path('app/upload/_header'),
            __DIR__ . '/../translations/zh/messages.php'    => base_path('resources/lang/vendor/upload/zh/messages.php'),
            __DIR__ . '/../translations/en/messages.php'    => base_path('resources/lang/vendor/upload/en/messages.php'),
            __DIR__ . '/../middleware/UploadCORS.php' => app_path('Http/Middleware/UploadCORS.php'),
        ], 'upload');

        if ( ! $this->app->routesAreCached() ) {
            require __DIR__ . '/../routes/routes.php';
        }

        Storage::extend('redis', function ($app, $config) {
            return new Filesystem(new RedisAdapter(new RedisClient()), $config);
        });

        if ( $this->app->runningInConsole() ) {
            $commands = [PublishCommand::class];
            if ( Util::isStorageHost() ) {
                array_push($commands, BuildRedisHashesCommand::class, CleanUpDirectoryCommand::class, ListGroupDirectoryCommand::class);
            }
            $this->commands($commands);
        }
    }

    public function register()
    {
        //
    }


}
