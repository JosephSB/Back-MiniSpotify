<?php 

    class Api extends Controller{
        function __construct(){
            parent::__construct();
        }

        function render(){
            $this->view->Render('Api/Index');
        }

        public function usuarios($params){
            require_once 'Usuarios.php';
            $controler = new Usuarios();
            $controler->loadModel('usuarios');
            $controler-> {$params[0]}();
        }

        public function music($params){
            require_once 'Music.php';
            $controler = new Music();
            $controler->loadModel('music');
            $controler-> {$params[0]}();
        }

    }

?>