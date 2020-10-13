<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuarios extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function login() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');
        
        //--- Guardo ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dato = array();
            $contrasena = $request->contrasena;
            $correo = $request->correo;

            $comparacion = $this->app_model->compare_correo_password($correo, md5($contrasena));

            if ($comparacion) {
                $dato['msg'] = "Usuario y contraseña";
                $dato['valid'] = true;
                $dato['usuario'] = $comparacion;
            } else {
                $dato['msg'] = "Usuario o contraseña incorrecta";
                $dato['valid'] = false;
            }

        } else {
            $dato['msg'] = "No hay post";
            $dato['valid'] = false;
        }

        echo json_encode($dato);
    }

    public function add_usuario() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin,access-control-allow-methods, access-control-allow-headers');
                
        //--- Guardo ---//
        $postdata = file_get_contents("php://input");
        $request  = json_decode($postdata);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //--- Definimos $dato ---//
            $dato = array();

            //--- Tomamos valores del registro ---//
            $nombre = $request->nombre;
            $apellido = $request->apellido;
            $password = $request->password;
            $correo = $request->correo;
            $telefono = $request->telefono;
            $direccion = $request->direccion;
            $idGenUsuario = $this->generarID();

            //--- Validamos que todos los datos esten con un valor ---//
            if (!empty($telefono) && !empty($correo) && !empty($nombre) && !empty($apellido) && !empty($direccion) && !empty($password)) {
                
                //--- Validamos que no exista otro usuarion con este correo recibido ---//
                $existe_usuario = $this->app_model->get_usuario_byCorreo($correo);

                if (!$existe_usuario) {
                    //--- Registramos un usuario ---//
                    $result = $this->app_model->add_usuario($nombre, $apellido, md5($password), $correo, $telefono, $direccion, $idGenUsuario);

                    if ($result) {
                        $dato['msg'] = "Usuario registrado";
                        $dato['valid'] = true;
                        $dato['usuario'] = $result;
                    } else {
                        $dato['msg'] = "Error al registrar el usuario, vuelva a intentarlo";
                        $dato['valid'] = false;
                    }
                } else {
                    $msg = "Hay un usuario registrado con el correo ingresado, ingrese otro distinto";
                    $dato = array("valid" => false, "msg" => $msg);
                }
            } else {
                $msg = "Algun dato obligatorio esta faltando ingresar";
                $dato = array("valid" => false, "msg" => $msg);
            }
        } else {
            $msg = "Error de sistema. Contacte con el Administrador.";
            $dato = array("valid" => false, "msg" => $msg);
        }

        echo json_encode($dato);
    }
}