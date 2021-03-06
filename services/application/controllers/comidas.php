<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comidas extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function list_comida() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');
           
        $comida = $this->app_model->get_comida();
            
        if ($comida) {
            $dato = $comida;
        } else {
            $dato = [];
        }
                
        echo json_encode($dato);
    }

    public function add_comida() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');
        
        //--- Decodificador ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dato = array();

            $comida = $request->comida;
            $descripcion = $request->descripcion;
            $ingrediente_x_comida = $request->ingrediente_x_comida;

            if (!empty($comida) && !empty($descripcion) && !empty($ingrediente_x_comida)) {

                //--- Agregamos una nueva comida ---//
                $comida = $this->app_model->add_comida($comida, $descripcion);
                
                //--- Obtenemos esta ultima comida añadido ---//
                $ultima_comida = $this->app_model->get_ultima_comida($comida, $descripcion);

                //--- Recorremos los ingredientes de la comida ---//
                foreach ($ingrediente_x_comida as $value) {
                    $this->app_model->add_ingrediente_x_comida($ultima_comida[0]['idComida'], $value->idIngrediente, $value->cantidad, $value->idUnidad);
                }

                if ($comida) {
                    $msg = "Se registro la comida de forma exitosa";
                    $dato = array("valid" => true, "msg" => $msg, "comida" => $comida);
                } else {
                    $msg = "Ha ocurrido un error en la inserccion de la comida";
                    $dato = array("valid" => false, "msg" => $msg);
                }
            } else {
                $msg = "Algun dato obligatorio falta";
                $dato = array("valid" => false, "msg" => $msg);
            }
        } else {
            $msg = "Error de sistema. Contacte con el Administrador.";
            $dato = array("valid" => false, "msg" => $msg);
        }

        echo json_encode($dato);
    }

    public function update_comida() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');

        //--- Decodificador ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dato = array();

            $idComida = $request->idComida;
            $comida = $request->comida;
            $descripcion = $request->descripcion;
            $ingrediente_x_comida = $request->ingrediente_x_comida;

            if (!empty($idComida) && !empty($comida) && !empty($descripcion) && !empty($ingrediente_x_comida)) {

                //--- Actualizamos los datos de la comida ---//
                $comida = $this->app_model->update_comida($idComida, $comida, $descripcion);

                //--- Actualizamos el detalle de la comida ---//

                //--- Primero borramos todos los ingrediente de las comidas ---//
                $this->app_model->delete_ingrediente_x_comida($idComida);
                //--- Agregamos todas nuevamente ---//
                foreach ($ingrediente_x_comida as $value) {
                    $this->app_model->add_ingrediente_x_comida($idComida, $value->idIngrediente, $value->cantidad, $value->idUnidad);
                }

                if ($comida) {
                    $msg = "Se actualizo correctamente la comida";
                    $dato = array("valid" => true, "msg" => $msg);
                } else {
                    $msg = "Ha ocurrido un error en la actualizacion de la comida";
                    $dato = array("valid" => false, "msg" => $msg);
                }
            } else {
                $msg = "Algun dato obligatorio falta";
                $dato = array("valid" => false, "msg" => $msg);
            }
        } else {

            $msg = "Error de sistema. Contacte con el Administrador.";
            $dato = array("valid" => false, "msg" => $msg);
        }

        echo json_encode($dato);
    }

    public function delete_comida() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');

        //--- Decodificador ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $dato = array();
            $idComida = $request->idComida;
            
            if (!empty($idComida)) {
                
                $comida = $this->app_model->delete_comida($idComida);
                $ingrediente_x_comida = $this->app_model->delete_ingrediente_x_comida($idComida);

                if ($comida && $ingrediente_x_comida) {
                    $msg = "La comida con sus ingredientes fueron eliminado con exito";
                    $dato = array("valid" => true, "msg" => $msg);
                } else {
                    $msg = "Error al eliminar registro";
                    $dato = array("valid" => false, "msg" => $msg);
                }
            } else {
                $msg = "Algun dato obligatorio falta";
                $dato = array("valid" => false, "msg" => $msg);
            }
        } else {
            $msg = "Error de sistema. Contacte con el Administrador.";
            $dato = array("valid" => false, "msg" => $msg);
        }
        echo json_encode($dato);
    }

    public function list_ingrediente_x_comida() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');
           
        //--- Decodificador ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $dato = array();
            $idComida = $request->idComida;
            
            if (!empty($idComida)) {
                
                $ingrediente = $this->app_model->get_ingrediente_x_comida_by_idComida($idComida);
                    
                if ($ingrediente) {
                    $dato = $ingrediente;
                } else {
                    $dato = [];
                }

            } else {
                $msg = "Algun dato obligatorio falta";
                $dato = array("valid" => false, "msg" => $msg);
            }

        } else {
            $msg = "Error de sistema. Contacte con el Administrador.";
            $dato = array("valid" => false, "msg" => $msg);
        }

        echo json_encode($dato);
    }

    public function add_ingrediente_x_comida() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');

        //--- Decodificador ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $dato = array();
            $idIngrediente = $request->idIngrediente;
            $cantidad = $request->cantidad;
            $idUnidad = $request->idUnidad;

            if (!empty($idIngrediente) && !empty($cantidad) && !empty($idUnidad)) {

                $ingrediente_x_comida = $this->app_model->add_ingrediente_x_comida($idIngrediente, $cantidad, $idUnidad);

                if ($ingrediente_x_comida) {
                    $msg = "Se añadio correctamente la comida";
                    $dato = array("valid" => true, "msg" => $msg);
                } else {
                    $msg = "Ha ocurrido un error en la insercion de la comida";
                    $dato = array("valid" => false, "msg" => $msg);
                }
            } else {
                $msg = "Algun dato obligatorio falta";
                $dato = array("valid" => false, "msg" => $msg);
            }
        } else {
            $msg = "Error de sistema. Contacte con el Administrador.";
            $dato = array("valid" => false, "msg" => $msg);
        }

        echo json_encode($dato);
    }

    public function update_ingrediente_x_comida() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');

        //--- Decodificador ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dato = array();

            $idIngredienteXComida = $request->idIngredienteXComida;
            $idIngrediente = $request->idIngrediente;
            $cantidad = $request->cantidad;
            $idUnidad = $request->idUnidad;

            if (!empty($idIngredienteXComida) && !empty($idIngrediente) && !empty($cantidad) && !empty($idUnidad)) {

                $ingrediente_x_comida = $this->app_model->update_ingrediente_x_comida($idIngredienteXComida , $idIngrediente, $cantidad, $idUnidad);

                if ($ingrediente_x_comida) {
                    $msg = "Se actualizo correctamente la comida";
                    $dato = array("valid" => true, "msg" => $msg);
                } else {
                    $msg = "Ha ocurrido un error en la actualizacion de la comida";
                    $dato = array("valid" => false, "msg" => $msg);
                }
            } else {
                $msg = "Algun dato obligatorio falta";
                $dato = array("valid" => false, "msg" => $msg);
            }
        } else {
            $msg = "Error de sistema. Contacte con el Administrador.";
            $dato = array("valid" => false, "msg" => $msg);
        }

        echo json_encode($dato);
    }

    public function delete_ingrediente_x_comida() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');

        //--- Decodificador ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $dato = array();
            $idIngredienteXComida = $request->idIngredienteXComida;
            
            if (!empty($idIngredienteXComida)) {
                
                $ingrediente_x_comida = $this->app_model->delete_ingrediente_x_comida_idIngredienteXComida($idIngredienteXComida);

                if ($ingrediente_x_comida) {
                    $msg = "El ingrediente fue eliminado con exito";
                    $dato = array("valid" => true, "msg" => $msg);
                } else {
                    $msg = "Error al eliminar registro";
                    $dato = array("valid" => false, "msg" => $msg);
                }
            } else {
                $msg = "Algun dato obligatorio falta";
                $dato = array("valid" => false, "msg" => $msg);
            }
        } else {

            $msg = "Error de sistema. Contacte con el Administrador.";
            $dato = array("valid" => false, "msg" => $msg);
        }

        echo json_encode($dato);
    }

}
