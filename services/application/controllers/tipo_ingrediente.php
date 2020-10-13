<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tipo_Ingrediente extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function list_tipo_ingrediente() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');
           
        $tipo_ingrediente = $this->app_model->get_tipo_ingrediente();
            
        if ($tipo_ingrediente) {
            $dato = $tipo_ingrediente;
        } else {
            $dato = [];
        }
                
        echo json_encode($dato);
    }

    public function add_tipo_ingrediente() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');
        
        //--- Decodificador ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dato = array();
            $nombre = $request->nombre;
            
            if (!empty($nombre)) {
                    
                $tipo_ingrediente = $this->app_model->add_tipo_ingrediente($nombre, 0);
                    
                if ($tipo_ingrediente) {
                    $msg = "El tipo de ingrediente a sido agregado con exito";
                    $dato = array("valid" => true, "msg" => $msg, "nombre" => $nombre);
                } else {
                    $msg = "Ha ocurrido un error en la insercción del tipo de ingrediente, vuelva a intenarlo";
                    $dato = array("valid" => false, "msg" => $msg);
                }
                
            } else {
                $msg = "Datos obligatorios faltantes";
                $dato = array("valid" => false, "msg" => $msg);
            }
        } else {
            $msg = "Error de sistema. Contacte con el Administrador.";
            $dato = array("valid" => false, "msg" => $msg);
        }

        echo json_encode($dato);
    }

    public function update_tipo_ingrediente() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');

        //--- Decodificar ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $dato = array();
            $id = $request->id;
            $nombre = $request->nombre;

            if (!empty($id) && !empty($nombre)) {

                $ti_editado = $this->app_model->update_tipo_ingrediente($id, $nombre); 
                
                if ($ti_editado) {           
                    $msg = "El tipo de ingrediente fue actualizado de forma exitosa";
                    $dato = array("valid" => true, "msg" => $msg, "id" => $id, "nombre" => $nombre);
                } else {
                    $msg = "Error al actualizar el tipo de ingrediente, vuelva a intentarlo";
                    $dato = array("valid" => false, "msg" => $msg);
                }
            } else {
                $msg = "Datos obligatorios faltantes";
                $dato = array("valid" => false, "msg" => $msg);
            }
        } else {
            $msg = "Error de sistema. Contacte con el Administrador.";
            $dato = array("valid" => false, "msg" => $msg);
        }

        echo json_encode($dato);
    }

    public function delete_tipo_ingrediente() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');

        //--- Decodificar ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $dato = array();
            $id = $request->id;

            if (!empty($id)) {

                $tipo_ingrediente = $this->app_model->delete_tipo_ingrediente_by_id($id);

                if ($tipo_ingrediente) {
                    $msg = "Tipo de ingrediente fue eliminado con exito";
                    $dato = array("valid" => true, "msg" => $msg);
                } else {
                    $msg = "Error al eliminar el tipo de ingrediente, vuelva a intentarlo";
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