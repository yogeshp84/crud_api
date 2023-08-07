<?php
namespace App;

class Router{
    private array $handlers;
    private $notFoundHandler;
    private const METHOD_POST = 'POST';
    private const METHOD_GET = 'GET';
    private const METHOD_PUT = 'PUT';
    private const METHOD_DELETE = 'DELETE';


    public function get(string $path, $handler):void{
        $this->assignHandlers(self::METHOD_GET, $path, $handler);
    }


    public function post(string $path, $handler):void{
        $this->assignHandlers(self::METHOD_POST, $path,$handler);
    }

    public function put(string $path, $handler):void{
        $this->assignHandlers(self::METHOD_PUT, $path,$handler);
    }
    
    public function delete(string $path, $handler):void{
        $this->assignHandlers(self::METHOD_DELETE, $path,$handler);
    }

    public function addNotFoundHandler($handler):void{
        $this->notFoundHandler = $handler;
    }

    private function assignHandlers(string $method,string $path, $handler):void{
        $this->handlers[$method . $path] = [
            'path'=>$path,
            'method'=>$method,
            'handler'=>$handler
        ];
    }
    public function run():void{
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestedPath = $requestUri['path'];
        $method = $_SERVER['REQUEST_METHOD'];
        $callback = null;
        foreach($this->handlers as $handler){
            
            if($requestedPath === $handler['path'] && $method ===  $handler['method']){
                $callback = $handler['handler'];
            }
        }
        if(!$callback){
            header('HTTP/1.0 404 Not Found');
            if(!empty($this->notFoundHandler)){
                $callback = $this->notFoundHandler;
            }
        }
        if(is_string($callback)){
            $parts = explode('::',$callback);
            if(is_array($parts)){
                $className = array_shift($parts);
                $handler = new $className;
                $method = array_shift($parts);
                $callback = [$handler,$method];
            }
        }
        call_user_func_array($callback,[
            array_merge($_GET,$_POST)
        ]);
    }
}