<?php

namespace App\Logic;

/**
 * Class Api
 * @package App\Logic
 * @method public method
 *
 */

class Api
{
    private $_method;

    protected $_base_url;

    private $_endPoint;

    private $_params;

    private $_options = [];

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * @param $method string
     * @return mixed
     */
    protected function method($method)
    {
        return $this->_method = $method;
    }

    /**
     * @param $url string
     * @return mixed
     */
    protected function url($url)
    {
        return $this->_url = $url;
    }

    /**
     * @param $endPoint string
     * @return mixed
     */
    protected function endPoint(string $endPoint)
    {
        return $this->_endPoint = $endPoint;
    }

    /**
     * @param string $params
     * @return string
     */
    protected function params($params)
    {
        return $this->_params = $params;
    }

    /**
     * @param string $param
     * @param string $arg
     * @param string $operator
     * @return string
     */
    protected function paramBuilder($param, $arg, $operator = '=')
    {
        $query = $param . $operator . $arg;

        if(strlen($this->_params) == 0) {
            return $this->_params .= '?' . $query;
        }

        return $this->_params .= '&' . $query;
    }

    /**
     * @param $options array
     * @return mixed
     */
    public function options(array $options)
    {
        return $this->_options = $options;
    }

    /**
     * @return object
     */
    protected function execute()
    {
        $url = $this->_base_url . $this->_endPoint . $this->_params;

        $response = $this->client->request($this->_method, $url, $this->_options);

        return \GuzzleHttp\json_decode($response->getBody()->getContents());
    }

}