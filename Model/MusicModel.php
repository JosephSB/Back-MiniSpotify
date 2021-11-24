<?php

    class MusicModel extends Model{
        function __construct(){
            parent::__construct();
        }

        public function addSong($data,$type)
        {
            try {
                $query = $this->db->connect()->prepare(
                    "INSERT INTO song VALUES (:idSong,:songname,:gender,:url_portada,:url_aud,CURRENT_TIME(),:datePremiere)"
                );
                $id ="#".substr(uniqid(),3,8).substr($data['gender'],0,2).substr(uniqid(),0,2);
                $urlSong= constant('URL')."/Uploads/Musics/".$data['songname'].".mp3";
                $urlImg= constant('URL')."/Uploads/Img/".$data['songname'].".".$type;

                $query->execute([
                    'idSong'=>$id,//generar id
                    'songname'=>$data['songname'],
                    'gender'=> $data['gender'],
                    'url_portada' => $urlImg,
                    'url_aud' =>$urlSong,
                    'datePremiere' => $data['date_premiere']
                ]);

                $this->addAutorSong($data['id_user'],$id);
                return true;

            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        }


        public function addAutorSong($idAutor,$idSong)
        {
            try {
                $query = $this->db->connect()->prepare(
                    'INSERT INTO usuarios_song VALUES (:idSong,:iduser)'
                );

                $query->execute([
                    'idSong'=>$idSong,//generar id
                    'iduser'=>$idAutor
                ]);
                return true;
            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        }

    }

?>