<?php
namespace Sword\Swoole;

use Illuminate\Http\Request as IlluminateRequest;
use Symfony\Component\HttpFoundation\Response;

class Server{
    private $http_server = null;
    private $_SERVER = [];

    public function __construct($config = [], $setting = [], $app)
    {
        $this->init($config, $setting, $app);
    }

    public function init($config, $setting, $app)
    {
        $this->http_server = new \swoole_http_server($config['host'], $config['port']);
        $this->http_server->on('Request', [$this, 'onRequest']);
        $this->lumen = $app;
    }

    public function onRequest($request, $response)
    {
        $illuminate_request  = $this->dealWithRequest($request);

        try{
            $illuminate_response = $this->lumen->dispatch($illuminate_request);
            $this->dealWithResponse( $response, $illuminate_response);
        }catch(\Exception $e){
            fwrite(STDOUT, $e->getMessage() . "\n");
        }finally{
            if (count($this->lumen->getMiddleware()) > 0) {
                $this->lumen->callTerminableMiddleware($illuminate_response);
            }
        }
    }

    public function start()
    {
        return $this->http_server->start();
    }

    private function dealWithRequest($request)
    {
        $get    = isset($request->get) ? $request->get : array();
        $post   = isset($request->post) ? $request->post : array();
        $cookie = isset($request->cookie) ? $request->cookie : array();
        $server = isset($request->server) ? $request->server : array();
        $header = isset($request->header) ? $request->header : array();
        $files  = isset($request->files) ? $request->files : array();

        // merge headers into server which ar filted by swoole
        // make a new array when php 7 has different behavior on foreach
        $new_server = [];
        foreach($header as $key => $value)
        {
            $new_server[strtoupper('http_' . $key)] = $value;
        }
        foreach($server as $key => $value)
        {
            $new_server[strtoupper($key)] = $value;
        }
        foreach($this->_SERVER as $key => $value)
        {
            $new_server[strtoupper($key)] = $value;
        }

        $content = $request->rawContent() ? :'';

        $illuminate_request = new IlluminateRequest($get, $post, []/* attributes */, $cookie, $files, $new_server,
            $content);

        return $illuminate_request;
    }

    private function dealWithResponse($response, $illuminate_response)
    {
        // status
        $response->status($illuminate_response->getStatusCode());
        // headers
        foreach ($illuminate_response->headers->allPreserveCase() as $name => $values) {
            foreach ($values as $value) {
                $response->header($name, $value);
            }
        }
        // cookies
        foreach ($illuminate_response->headers->getCookies() as $cookie) {
            $response->rawcookie(
                $cookie->getName(),
                $cookie->getValue(),
                $cookie->getExpiresTime(),
                $cookie->getPath(),
                $cookie->getDomain(),
                $cookie->isSecure(),
                $cookie->isHttpOnly()
            );
        }
        // content
        $content = $illuminate_response->getContent();


        $response->end($content);
    }

}


