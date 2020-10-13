<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ingrediente extends MY_Controller {

    protected $data = array(
        'active' => 'ingrediente'
    );

    public function __construct() {
        parent::__construct();
    }

    public function list_ingrediente() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');

        $ingrediente = $this->app_model->get_ingrediente();
        $tipo_ingrediente = $this->app_model->get_tipo_ingrediente();

        if ($ingrediente && $tipo_ingrediente) {
            $dato = array("valid" => true, "ingrediente" => $ingrediente, "tipo_ingrediente" => $tipo_ingrediente);
        } else {
            $dato = [];
        }

        echo json_encode($dato);
    }

    public function add_ingrediente() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');
        
        //--- Decodificador ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dato = array();
            $nombre = $request->nombre;
            $tipo_ingrediente = $request->tipo_ingrediente;

            if (!empty($nombre) && !empty($tipo_ingrediente)) {
                
                $ingrediente = $this->app_model->add_ingrediente($nombre, $tipo_ingrediente, 0);

                if ($ingrediente) {
                    $msg = "Se agregó el ingrediente exitosamente";
                    $dato = array("valid" => true, "msg" => $msg, "nombre" => $nombre, "tipo_ingrediente" => $tipo_ingrediente);
                } else {
                    $msg = "Error al registrar el ingrediente, vuelva a intentarlo";
                    $dato = array("valid" => false, "msg" => $msg);
                }
            } else {
                $msg = "Algun dato obligatorio falta, vuelva a intentarlo";
                $dato = array("valid" => false, "msg" => $msg);
            }
        } else {
            $msg = "Error de sistema. Contacte con el Administrador.";
            $dato = array("valid" => false, "msg" => $msg);
        }

        echo json_encode($dato);
    }

    public function update_ingrediente() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');
        
        //--- Decodificador ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dato = array();

            $id = $request->id;
            $nombre = $request->nombre;
            $tipo_ingrediente = $request->tipo_ingrediente;

            if (!empty($id) && !empty($nombre) && !empty($tipo_ingrediente)) {

                $ingrediente = $this->app_model->update_ingrediente($id, $nombre, $tipo_ingrediente);

                if ($ingrediente) {
                    $msg = "Se actualizo el ingrediente de forma exitosa";
                    $dato = array("valid" => true, "msg" => $msg, "nombre" => $nombre, "tipo_ingrediente" => $tipo_ingrediente);
                } else {
                    $msg = "Error al actualizar el ingrediente, vuelva a intentarlo";
                    $dato = array("valid" => false, "msg" => $msg);
                }
            } else {
                $msg = "Algun dato obligatorio falta, vuelva a intentarlo";
                $dato = array("valid" => false, "msg" => $msg);
            }
        } else {
            $msg = "Error de sistema. Contacte con el Administrador.";
            $dato = array("valid" => false, "msg" => $msg);
        }

        echo json_encode($dato);
    }

    public function delete_ingrediente() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');
        
        //--- Decodificador ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dato = array();

            $id = $request->id;

            if (!empty($id)){

                $ingrediente = $this->app_model->delete_ingrediente_by_id($id);

                if ($ingrediente) {
                    $msg = "El ingrediente fue eliminado con exito";
                    $dato = array("valid" => true, "msg" => $msg);
                } else {
                    $msg = "Error al eliminar el ingrediente, vuelva a intentarlo";
                    $dato = array("valid" => false, "msg" => $msg);
                }
            } else {
                $msg = "Datos obligatorios faltantes, vuelva a intentarlo";
                $dato = array("valid" => false, "msg" => $msg);
            }
        } else {
            $msg = "Error de sistema. Contacte con el Administrador.";
            $dato = array("valid" => false, "msg" => $msg);
        }

        echo json_encode($dato);
    }

}
