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

        public function addSongPlalist()
        {
            $data = json_decode(file_get_contents('php://input'), true);

            if(count($data)==2){

                if($this->model->existSongID($data['IDsong'])&&
                $this->model->existPlaylistID($data['IDplaylist'])
                ){

                    if($this->model->addSong_Playlist($data)){
                        echo $this->sendJson('Cancion agregada correctamente', true);
                    }else echo $this->sendJson('Error al guardar la cancion', false);
                    
                }else  echo $this->sendJson('Los datos no existen', false);

            }else echo $this->sendJson('Datos Incompletos', false);
        }

    }


?>