<?php

    class PlaylistsModel extends Model {
        function __construct(){
            parent::__construct();
        }

        public function addPlaylist($data)
        {
            try {
                $query = $this->db->connect()->prepare(
                    'INSERT INTO playlist VALUES (:idPlaylist, :namePlaylist, :urlPortada,CURRENT_TIME(),:description)'
                );

                $idplaylist ="#".substr(uniqid(),3,8).substr(uniqid(),0,2).substr(uniqid(),0,2);

                $query->execute([
                    'idPlaylist'=>$idplaylist,//generar id
                    'namePlaylist'=>$data['NamePlaylist'],
                    'urlPortada' => $data['URL_Portada'],
                    'description' => $data['Descripcion']
                ]);

                $this->addAutorPlaylist($data['IDusuario'],$idplaylist);
                return true;

            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        }

        public function addAutorPlaylist($idautor,$idplaylist)
        {
            try {
                $query = $this->db->connect()->prepare(
                    'INSERT INTO usuarios_playlist VALUES (:idplaylist,:iduser)'
                );

                $query->execute([
                    'idplaylist'=>$idplaylist,
                    'iduser'=>$idautor
                ]);
                return true;
            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        }

    }

?>