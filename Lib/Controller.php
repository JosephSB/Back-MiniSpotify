<?php

    class Controller{

        function __construct()
        {
            $this->view = new View();
        }

        function loadModel($model){
            $url = 'Model/'.$model.'Model.php';

            if(file_exists($url)){
                require $url;
                $modelName = $model.'Model';
                $this->model = new $modelName();
            }
        }

    }

?>