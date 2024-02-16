<?php

class Response{
    private $success ;
    private $httpStatusCode ;
    private $message  = array();
    private $data; 
    private $toCache = false;
    private $responseData = array();

    public function __construct($success, $httpStatusCode, $message, $data = null, $toCache = false){
        $this->success = $success;
        $this->httpStatusCode = $httpStatusCode;
        $this->message = $message;
        $this->data = $data;
        $this->toCache = $toCache;
    }

    public function send(){

        header('Content-Type: application/json');

        if ($this->toCache){
            header('Cache-Control: max-age=60');
        } else {
            header('Cache-Control: no-cache, no-store, must-revalidate');
        }

        if(!is_bool($this->success) || !is_numeric($this->httpStatusCode)){
            http_response_code(500);
            $this->responseData['success'] = false;
            $this->responseData['statusCode'] = $this->httpStatusCode;
            $this->addMessage('succes not set or  not numeric');
            $this->responseData['message'] = $this->message;
        } else {
            http_response_code($this->httpStatusCode);
            $this->responseData['success'] = $this->success;
            $this->responseData['statusCode'] = $this->httpStatusCode;
            $this->responseData['message'] = $this->message;
            if ($this->data!= null){
                $this->responseData['data'] = $this->data;
            }
        }

        echo json_encode($this->responseData);

    }

}



?>