<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2019-12-03
 * Time: 18:08
 */

namespace JoseChan\Base\Sdk\Providers;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class ClientServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([__DIR__ . '/../../config/sdk.php' => config_path("sdk.php")], "sdk");
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $config = config("sdk");

        if (!$config) {
            $config = include __DIR__ . '/../../config/sdk.php';
        }
        $this->app->singleton(Client::class, function (Application $app) use ($config) {
            $stack = null;
            if (!empty($config['middlewares'])) {
                $stack = new HandlerStack();
                $stack->setHandler(new CurlHandler());
                foreach ($config['middlewares'] as $middleware) {
                    if ($middleware instanceof \Closure) {
                        $stack->push($middleware);
                    } elseif (class_exists($middleware)) {
                        $stack->push($app->make($middleware));
                    } elseif (is_array($middleware) && method_exists($middleware[0], $middleware[1])) {
                        $stack->push($middleware);
                    }
                }
            }

            $client = new Client(['handler' => $stack]);

            return $client;
        });
    }


}
