<?php
class Session{
    public  $session_message = "The session required is not active";
    static private $instance;

    static function getInstance() {
        if(!(Session::$instance instanceof Session)) {
        	Session::$instance = new Session();
        }		
        return Session::$instance;
    }

    public function start(){
        @session_start();
    }
    
    public function init($timeLife = null){
        $_SESSION['ACTIVITY_ID'] = md5(uniqid(time()));
        $_SESSION['LAST_ACTIVITY'] = time();
        if($timeLife != null){
            $_SESSION['LIFE_TIME'] = $timeLife;
        }else{
            $_SESSION['LIFE_TIME'] = 1800;
        }
    }

    public function getLeftTime(){
        $minutos = floor(($_SESSION['LIFE_TIME'] - (time() - $_SESSION['LAST_ACTIVITY']) ) / 60 );
        $segundos = (($_SESSION['LIFE_TIME'] - (time() - $_SESSION['LAST_ACTIVITY']) ) % 60 );
        if($segundos <=9){
            $segundos = "0".$segundos;
        }
        return "$minutos:$segundos";
    }

    public function addNode($key, $value){
        $_SESSION['node'][$key] = $value;
        return $this;
    }
    
    public function getNode($key){
        if(isset($_SESSION['node'][$key])){
            return $_SESSION['node'][$key];
        }
    }
    
    public function remNode($key){
        if(isset($_SESSION['node'][$key])){
            unset($_SESSION['node'][$key]);
        }
        return $this;
    }

    public function destroyNodes(){
        if(isset($_SESSION['node'])){
            unset($_SESSION['node']);
        }
        return $this;
    }
	
    public function check($showMessage = null){
        if(!isset($_SESSION['LAST_ACTIVITY']) || (time() - $_SESSION['LAST_ACTIVITY'] >= $_SESSION['LIFE_TIME'])){
            $this->destroy();
            return false;
        }else{
            return true;
        }
    }
    
    public function setMsg($msg){
        $this->session_message = $msg;
    }	
    public function getId()  {
        if(isset($_SESSION['ACTIVITY_ID'])){
            return $_SESSION['ACTIVITY_ID'];
        }else{
            $this->setMsg("session null");
            return $this->session_message;
        }
    }
    public function status(){
        return $this->session_message;
    }
    public function destroy(){
        if(isset($_SESSION['LAST_ACTIVITY']))	{
           unset($_SESSION['LAST_ACTIVITY'] );
        }
        if(isset($_SESSION['LIFE_TIME'])){
            unset($_SESSION['LIFE_TIME']);
        }
        if(isset($_SESSION['ACTIVITY_ID'])){
            unset($_SESSION['ACTIVITY_ID']);
        }
        if(isset($_SESSION)) {
            session_destroy();
        }
        return false;
    }
}