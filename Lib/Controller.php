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

        
        /*---------FUNCIONES DE AYUDA--------------*/

        public function generarJson($query)
        {
            $data = array();
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $item = array(
                    'USERNAME' => $row['USERNAME'],
                    'IDSONG' => $row['ID_SONG'],
                    'SONGNAME' => $row['SONGNAME'],
                    'GENDER' => $row['GENDER'],
                    'URLPORTADA' => $row['URL_PORTADA'],
                    'URL_AUDIO' => $row['URL_AUDIO'],
                    'DATEUPLOAD' => $row['DATE_UPLOAD']
                );
                array_push($data, $item);
            }
            return $data;
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