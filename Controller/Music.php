<?php
    require './Helpers/validateFiles.php';

    class Music extends Controller{
        function __construct(){
            parent::__construct();
        }

        public function Upload()
        {
            //validar que se estan mandando todos los datos
            if( count($_POST) == 4 && count($_FILES) == 2 ){
                $fileSONG = $_FILES['file_song'];
                $fileIMG = $_FILES['file_img'];

                //validar que el userid exista
                if($this->model->findUserbyId( $_POST['id_user'])){

                    //validar que no esten vacios los datos
                    if( !empty($_POST['id_user']) && !empty($_POST['songname']) && 
                    !empty($_POST['gender']) ){

                        //generar id
                        $id ="S".substr(uniqid(),3,8).substr($_POST['gender'],0,2).substr(uniqid(),0,2);

                        //valida y guarda los archivos enviados
                        if($this->saveMusic($fileSONG,$id) &&
                        $this->saveImg($fileIMG,$id)){

                            $type = explode("/",$fileIMG['type'])[1];
                            if($this->model->addSong($_POST,$type,$id)) echo $this->sendJson('Archivos agregados', true);
                            else echo $this->sendJson('error al guardar sus archivos a la bd', false);

                        }else echo $this->sendJson('error al guardar sus archivos', false);

                    }else{
                        echo $this->sendJson('Parametros vacios', false);
                    }

                }else{
                    echo $this->sendJson('El usuario no existe', false);
                }

            }else{
                echo $this->sendJson('Datos incompletos', false);
            }
        }

        public function getSongs($page)
        {
            $dataQuery = $this->model->getSongs($page);

            echo $this->sendJson($this->generarJson($dataQuery), true);

        }

        public function getSongsbyGender()
        {
            $data = json_decode(file_get_contents('php://input'), true);

            if(isset($data['Gender']) &&  isset($data['Pagina'])){

                $dataQuery = $this->model->getSongsByGender($data);
                echo $this->sendJson($this->generarJson($dataQuery), true);

            }else echo $this->sendJson("No se enviaron los parametros", false);
        }

        /*---------FUNCIONES QUE GUARDAN LOS FILES--------------*/

        private function saveMusic($fileSONG,$name)
        {
            $directorio = "Uploads/Musics/";
            $archivo = $directorio . basename($fileSONG["name"]);

            $validate = new ValidateFiles();

            if($validate->testAUD($fileSONG)){
                if(move_uploaded_file($fileSONG["tmp_name"], $archivo)){
                    rename ($archivo, $directorio.$name.'.mp3');
                    return true;
                }else return false;
            }else return false;

            
        }

        private function saveImg($fileIMG,$name)
        {
            $directorio = "Uploads/Img/";
            $archivo = $directorio . basename($fileIMG["name"]);

            $validate = new ValidateFiles();

            if($validate->testIMG($fileIMG)){
                if(move_uploaded_file($fileIMG["tmp_name"], $archivo)){
                    $type = explode("/",$fileIMG['type'])[1];
                    rename ($archivo, $directorio.$name.".".$type);
                    return true;
                }else return false;
            }else return false;
        }

    }

?>