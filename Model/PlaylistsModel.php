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

        public function addSong_Playlist($data)
        {
            try {
                $query = $this->db->connect()->prepare(
                    'INSERT INTO playlist_song VALUES (:idPlaylist, :idsong)'
                );

                $query->execute([
                    'idPlaylist'=>$data['IDplaylist'],//generar id
                    'idsong'=>$data['IDsong']
                ]);
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

        public function existSongID($idsong)
        {
            try {
                $query = $this->db->connect()->prepare(
                    'SELECT ID_SONG,SONGNAME FROM song WHERE ID_SONG = :idsong'
                );

                $query->execute(['idsong'=>$idsong]);
                while($query->fetch()){
                    return true;
                }
                return false;
            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        }

        public function existPlaylistID($idplaylist)
        {
            try {
                $query = $this->db->connect()->prepare(
                    'SELECT ID_PLAYLIST FROM playlist WHERE ID_PLAYLIST = :idplaylist'
                );

                $query->execute(['idplaylist'=>$idplaylist]);
                while($query->fetch()){
                    return true;
                }
                return false;
            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        }

    }

?>