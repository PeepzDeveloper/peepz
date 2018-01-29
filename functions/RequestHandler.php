<?php

class RequestHandler
{
    /**
     * @param string $key
     * @param string $default
     * @return string
     */
    public function get($key, $default = '')
    {
        return (array_key_exists($key, $_GET)) ? $this->getCleanedRequestVariable($_GET[$key]) : $default;
    }

    /**
     * @param string $key
     * @param string $default
     * @return string
     */
    public function post($key, $default = '')
    {
        return (array_key_exists($key, $_POST)) ? $this->getCleanedRequestVariable($_POST[$key]) : $default;
    }

    /**
     * @param string $var
     * @return string
     */
    private function getCleanedRequestVariable($var)
    {
        return htmlentities($var, ENT_COMPAT, "UTF-8");
    }
}