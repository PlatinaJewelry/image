<?php

namespace Platina\Image;

use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Загрузка всех необходимых сервисов пакета.
     *
     * @return void
     */
    public function boot(): void
    {
        // Публикация необходима только при использовании командной строки (CLI).
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Регистрация всех сервисов пакета
     *
     * @return void
     */
    public function register(): void
    {
        // Объединение конфигурации пакета, если это необходимо.
        $this->mergeConfigFrom(__DIR__ . '/../config/image.php', 'image');

        // Регистрация сервиса, предоставляемого пакетом.
        $this->app->singleton('PLImage', function ($app) {
            return new Image();
        });
    }

    /**
     * Получение списка сервисов, предоставляемых сервис-провайдером
     *
     * @return array
     */
    public function provides()
    {
        return ['PLImage'];
    }

    /**
     * Дополнительные действия после регистрации сервисов в командной строке (CLI)
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Публикация файла конфигурации.
        $this->publishes([
            __DIR__ . '/../config/image.php' => config_path('image.php'),
        ], 'image.config');
    }
}
