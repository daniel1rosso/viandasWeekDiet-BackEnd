<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vianda extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function list_vianda() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');
           
        $vianda = $this->app_model->get_vianda();
            
        if ($vianda) {
            $dato = $vianda;
        } else {
            $dato = [];
        }
                
        echo json_encode($dato);
    }

    public function add_vianda() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');
        
        //--- Decodificador ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dato = array();

            $vianda = $request->nombre;
            $idEstado = $request->idEstado;
            $precio = $request->precio;
            $comida_x_vianda = $request->comida_x_vianda;

            if (!empty($vianda) && !empty($idEstado) && !empty($precio) && !empty($comida_x_vianda)) {

                //--- Agregamos una nueva vianda ---//
                $vianda = $this->app_model->add_vianda($vianda, $idEstado, $precio);
                
                //--- Obtenemos esta ultima vianda añadido ---//
                $ultima_vianda = $this->app_model->get_ultima_vianda($vianda, $idEstado);

                //--- Recorremos las comidas de la vianda ---//
                foreach ($comida_x_vianda as $value) {
                    $this->app_model->add_comida_x_vianda($ultima_vianda[0]['idVianda'], $value->idComida, $value->cantidad);
                }

                if ($vianda) {
                    $msg = "Se registro la vianda de forma exitosa";
                    $dato = array("valid" => true, "msg" => $msg, "nombre" => $vianda);
                } else {
                    $msg = "Ha ocurrido un error en la inserccion de la vianda";
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

    public function update_vianda() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');

        //--- Decodificador ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dato = array();

            $idVianda = $request->idVianda;
            $vianda = $request->nombre;
            $idEstado = $request->idEstado;
            $precio = $request->precio;
            $comida_x_vianda = $request->comida_x_vianda;

            if (!empty($idVianda) && !empty($vianda) && !empty($idEstado) && !empty($precio) && !empty($comida_x_vianda)) {

                //--- Actualizamos la vianda ---//
                $vianda = $this->app_model->update_vianda($idVianda, $vianda, $idEstado, $precio);

                //--- Actualizamos el detalle de la vianda ---//

                //--- Primero borramos el detalle de la vianda ---//
                $delete_comida_x_vianda = $this->app_model->delete_comida_x_vianda($idVianda);

                //--- Agregamos todas las comidas que componen la vianda ---//
                foreach ($comida_x_vianda as $value) {
                    $this->app_model->add_comida_x_vianda($idVianda, $value->idComida, $value->cantidad);
                }

                if ($vianda) {
                    $msg = "Se actualizo correctamente la vianda";
                    $dato = array("valid" => true, "msg" => $msg);
                } else {
                    $msg = "Ha ocurrido un error en la actualizacion de la vianda";
                    $dato = array("valid" => false, "msg" => $msg);
                }
            } else {
                $msg = "Algun dato obligatorio falta";
                $dato = array("valid" => false, "msg" => $msg, 'precio' => $precio);
            }
        } else {
            $msg = "Error de sistema. Contacte con el Administrador.";
            $dato = array("valid" => false, "msg" => $msg);
        }

        echo json_encode($dato);
    }

    public function delete_vianda() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');

        //--- Decodificador ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $dato = array();
            $idVianda = $request->idVianda;
            
            if (!empty($idVianda)) {
                
                $vianda = $this->app_model->delete_vianda($idVianda);
                $comida_x_vianda = $this->app_model->delete_comida_x_vianda($idVianda);

                if ($vianda && $comida_x_vianda) {
                    $msg = "La vianda con sus comidas fueron eliminado con exito";
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

    public function list_comida_x_vianda() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');
           
        //--- Decodificador ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $dato = array();
            $idVianda = $request->idVianda;
            //$idVianda = 1;

            if (!empty($idVianda)) {
                
                $comida = $this->app_model->get_comida_x_vianda_by_idVianda($idVianda);
                    
                if ($comida) {
                    $dato = $comida;
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

    public function add_comida_x_vianda() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');

        //--- Decodificador ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $dato = array();
            $idVianda = $request->idVianda;
            $idComida = $request->idComida;
            $cantidad = $request->cantidad;

            if (!empty($idVianda) && !empty($idComida) && !empty($cantidad)) {

                $comida_x_vianda = $this->app_model->add_comida_x_vianda($idVianda, $idComida, $cantidad);

                if ($comida_x_vianda) {
                    $msg = "Se añadio correctamente la vianda";
                    $dato = array("valid" => true, "msg" => $msg);
                } else {
                    $msg = "Ha ocurrido un error en la insercion de la vianda";
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

    public function update_comida_x_vianda() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');

        //--- Decodificador ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dato = array();

            $idComidaXVianda = $request->idComidaXVianda;
            $idVianda = $request->idVianda;
            $idComida = $request->idComida;
            $cantidad = $request->cantidad;

            if (!empty($idComidaXVianda) && !empty($idVianda) && !empty($idComida) && !empty($cantidad)) {

                $comida_x_vianda = $this->app_model->update_comida_x_vianda($idComidaXVianda , $idVianda, $idComida, $cantidad);

                if ($comida_x_vianda) {
                    $msg = "Se actualizo correctamente la vianda";
                    $dato = array("valid" => true, "msg" => $msg);
                } else {
                    $msg = "Ha ocurrido un error en la actualizacion de la vianda";
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

    public function delete_comida_x_vianda() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');

        //--- Decodificador ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $dato = array();
            $idComidaXVianda = $request->idComidaXVianda;
            
            if (!empty($idComidaXVianda)) {
                
                $comida_x_vianda = $this->app_model->delete_comida_x_vianda_idComidaXVianda($idComidaXVianda);

                if ($comida_x_vianda) {
                    $msg = "La vianda fue eliminado con exito";
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
