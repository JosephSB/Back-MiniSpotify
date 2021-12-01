<?php 

    class UsuariosModel extends Model{
        private $dataUser;

        function __construct(){
            parent::__construct();
        }

        public function add($data){
            try {
                $query = $this->db->connect()->prepare(
                    'INSERT INTO usuarios VALUES (:id,:username,:pass,:email,:nombre,:lastname)'
                );
                $id ="#".substr(uniqid(),3,8).substr($data['Name'],0,2).substr($data['LastName'],0,2);
                $query->execute([
                    'id'=>$id,//generar id
                    'username'=>$data['Username'],
                    'pass'=> md5($data['Password']),
                    'email' => $data['Email'],
                    'nombre' => $data['Name'],
                    'lastname' => $data['LastName']
                ]);
                return true;
            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        }

        public function findUser($user,$pass)
        {
            try {
                $query = $this->db->connect()->prepare(
                    'SELECT * FROM usuarios WHERE USERNAME = :user and PASSWORD = :pass'
                );
                $query->execute([
                    'user'=>$user,
                    'pass'=> md5($pass)
                ]);

                while($row = $query->fetch()){
                    $this->dataUser = array(
                        'UserID' => $row['ID_USER'],
                        'Username' => $row['USERNAME'],
                        'Token' => '',
                        'Name' => $row['NAME']." ".$row['LASTNAME'],
                        'Email' => $row['EMAIL']
                    );
                    return true;
                }
                return false;
            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        }

        public function generarToken($idUser)
        {
            try {
                $query = $this->db->connect()->prepare(
                    'SELECT * FROM `token` WHERE ID_USER = :idUser'
                );
                $query->execute(['idUser'=>$idUser]);

                $token = bin2hex(openssl_random_pseudo_bytes(16,$val));
                
                while($query->fetch()){
                    return $this->updateToken($token,$idUser);
                }
                return $this->insertToken($token,$idUser);

            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        }

        public function updateToken($token,$idUser)
        {
            try {
                $query = $this->db->connect()->prepare(
                    'UPDATE TOKEN SET TOKEN=:token WHERE ID_USER=:idUser'
                );
                $query->execute([
                    'idUser'=>$idUser,
                    'token' => $token
                ]);

                $this->dataUser['Token'] =$token;
                return true;
            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        }

        public function insertToken($token,$idUser)
        {
            try {
                $query = $this->db->connect()->prepare(
                    'INSERT INTO TOKEN values (:idUser,:token,CURRENT_TIME())'
                );
                $query->execute([
                    'idUser'=>$idUser,
                    'token' => $token
                ]);

                $this->dataUser['Token'] =$token;
                return true;
            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        }

        public function searchToken($token)
        {
            try {
                $query = $this->db->connect()->prepare(
                    'SELECT u.ID_USER,u.USERNAME,t.TOKEN,u.NAME,u.LASTNAME,u.EMAIL FROM TOKEN t 
                    INNER JOIN usuarios u on(t.ID_USER = u.ID_USER) WHERE TOKEN = :token'
                );
                $query->execute(['token' => $token]);

                while($row = $query->fetch()){
                    $this->dataUser = array(
                        'UserID' => $row['ID_USER'],
                        'Username' => $row['USERNAME'],
                        'Token' => $row['TOKEN'],
                        'Name' => $row['NAME']." ".$row['LASTNAME'],
                        'Email' => $row['EMAIL']
                    );
                    return true;
                }

                return false;
            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        }

        public function getUserId()
        {
            return $this->dataUser['UserID'];
        }
        
        public function getDataUser()
        {
            return $this->dataUser;
        }
    }

?>