<?php
namespace App;

class Application extends \Laravel\Lumen\Application
{

    public function getMiddleware()
    {
        return $this->middleware;
    }

    public function callTerminableMiddleware($response)
    {
        parent::callTerminableMiddleware($response);
    }
}
