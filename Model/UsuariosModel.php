<?php 

    class UsuariosModel extends Model{
        private $id_user;

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
                    $this->id_user = $row['ID_USER'];
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
            return $this->id_user;
        }
    }

?>