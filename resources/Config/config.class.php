<?php

namespace Config;


class Config {
    private $config;

    public function __construct() {
        $this->config = $this->setConfig();
    }

    private function setConfig() {
        return [
            "sitename" => "GoPortlethen"
        ];
    }

    /**
     * Get a value from the config array with passed key
     * @param $key array key
     * @return mixed array value for key
     */
    public function get($key) {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        }
    }

    /**
     * Add a key and value in the config array
     * @param $key array key
     * @param $value array value
     */
    public function add($key, $value) {
        $this->config[$key] = $value;
    }

    /**
     * Returns the entire config array
     * @return array config aray
     */
    public function getall() {
        return $this->config;
    }
}