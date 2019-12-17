<?php

namespace App\Logic;

use Illuminate\Support\Facades\App;
use phpDocumentor\Reflection\Types\Parent_;

class ApiAfas extends Api
{
    protected $_base_url;
    private $_childClass;

    /**
     * ApiAfas constructor.
     */
    public function __construct($baseUrl, $token)
    {
        $this->_base_url = $baseUrl;
        $encodedToken = base64_encode($token);

        $this->options([
            'verify' => false,
            'headers' => [
                'Authorization' => 'AfasToken '.$encodedToken
            ]
        ]);

        parent::__construct();
    }

    /**
     * @param $skip integer
     * @return integer
     */
    protected function skip($skip)
    {
        return $this->paramBuilder('skip', $skip);
    }

    /**
     * @param $take integer
     * @return integer
     */
    protected function take($take)
    {
        return $this->paramBuilder('take', $take);
    }

    public function prepare($childClass, $method, $endPoint, $take = 1000, $skip = 0)
    {
        $this->_childClass = $childClass;
        $this->method($method);
        $this->endPoint($endPoint);
        $this->take($take);
        $this->skip($skip);
    }

    public function get()
    {
        return $this->execute();
    }

    /**
     * @return mixed
     */
    protected function execute()
    {
        $result = parent::execute();

        return $result->rows;
    }

}