<?php
    require './Helpers/validate.php';

    class Usuarios extends Controller{
        function __construct(){
            parent::__construct();
        }

        public function AddUser()
        {
            $data = json_decode(file_get_contents('php://input'), true);

            $validate = new Validate();

            if(count($data) == 5){
                if($validate -> validateUser($data['Username']) &&
                $validate -> validatePass($data['Password'])&&
                $validate -> validateEmail($data['Email'])
                ){
                    
                    if($this->model->add($data)){
                        echo json_encode(array('status' => 200, 'error'=> false, 'message' => 'Usuario Añadido Correctamente'));
                    }else{
                        echo json_encode(array('status' => 400, 'error'=> true, 'message' => 'No se puedo Anadir al usuario'));
                    }
                }
                else echo json_encode(array('status' => 400, 'error'=> true, 'message' => 'Los datos que envio son invalidos'));
            }else{
                echo json_encode(array('status' => 400, 'error'=> true, 'message' => 'Los datos estan incompletos'));
            }
        
        }

        public function ValidateUser()
        {
            $data = json_decode(file_get_contents('php://input'), true);
            if(isset($data['Username']) && isset($data['Password'])){
                if($this->model->findUser($data['Username'],$data['Password'])){
                    echo json_encode(
                        array(
                            'status' => 200, 
                            'operation'=> true, 
                            'message' => 'Usuario validado Correctamente',
                            'usuario' => $this->model->getUserId()
                        ));
                }else{
                    echo json_encode(
                        array('
                        status' => 200, 
                        'operation'=> false, 
                        'message' => 'No se pudo encontrar al usuario'
                    ));
                }
            }else{
                echo json_encode(
                    array(
                        'status' => 200, 
                        'operation'=> false, 
                        'message' => 'No se envio parametros'
                    ));
            }

        }


    }

?>