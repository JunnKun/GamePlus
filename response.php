<?php
    class Response implements \JsonSerializable{
        private $error;
        private $message;
        private $status_code;
        private $content_type;
        private $redirect_url;

        // CONSTRUCTOR
        function __construct($error, $message, $status_code, $content_type, $redirect_url) {
            $this -> error = $error;
            $this -> message = $message;
            $this -> status_code = $status_code;
            $this -> content_type = $content_type;
            $this -> redirect_url = $redirect_url;
        }

        // SET
        public function set_error($error){
            $this -> error = $error;
        }
        public function set_message($message){
            $this -> message = $message;
        }
        public function set_statusCode($status_code){
            $this -> status_code = $status_code;
        }
        public function set_contentType($content_type){
            $this -> content_type = $content_type;
        }
        public function set_redirectURL($redirect_url){
            $this -> redirect_url = $redirect_url;
        }

        // GET
        public function get_error(){
            return $this->error;
        }
        public function get_message(){
            return $this->message;
        }
        public function get_statusCode(){
            return $this->status_code;
        }
        public function get_contentType(){
            return $this->content_type;
        }
        public function get_redirectURL(){
            return $this->redirect_url;
        }

        // FUNCTION
        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
    }
?>