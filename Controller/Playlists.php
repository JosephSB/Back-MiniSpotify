<?php

    class Playlist extends Controller{
        function __construct(){
            parent::__construct();
        }

        public function newPlaylist()
        {
            $data = json_decode(file_get_contents('php://input'), true);

            if(count($data)==4){

                if($this->model->findUserbyId( $data['IDusuario'])){
                    if(strlen(trim($data['NamePlaylist']))>=5 && 
                    !empty($data['Descripcion']))
                    {
                        if($this->model->addPlaylist($data)){

                            echo $this->sendJson('Playlist creada exitosamente', true);
                            
                        }else echo $this->sendJson('Ocurrio un error al crear la playlist', false);

                    }else echo $this->sendJson('Datos vacios', false);
                }else echo $this->sendJson('El usuario no existe', false);
            }else echo $this->sendJson('Datos Incompletos', false);
        }

    }


?>