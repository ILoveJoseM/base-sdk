<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2019-12-03
 * Time: 18:08
 */

namespace JoseChan\Base\Sdk;


use GuzzleHttp\Client;

/**
 * Class BaseSdk
 * @package JoseChan\Base\Sdk
 */
class BaseSdk
{
    /**
     * @var Client $client
     */
    protected $client;

    /**
     * @var array $config 配置项
     */
    protected $config;

    public function __construct(Client $client, $config)
    {
        $this->client = $client;

        $this->config = $config;
    }

    /**
     * 获取配置项
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function getConfig($key, $default = null)
    {
        return isset($this->config[$key]) ? $this->config[$key] : $default;
    }

    /**
     * 获取所有配置
     * @return array
     */
    public function fetchConfig()
    {
        return $this->config;
    }

    /**
     * 设置配置项
     * @param $key
     * @param $value
     * @return $this
     */
    public function setConfig($key, $value)
    {
        $this->config[$key] = $value;

        return $this;
    }
}
