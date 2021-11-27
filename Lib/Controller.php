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

                
        public function sendJson($data, $operation)
        {
            return json_encode(
                array(
                    'status' => 200, 
                    'operation'=> $operation, 
                    'data' => $data
                ));
        }

    }

?>