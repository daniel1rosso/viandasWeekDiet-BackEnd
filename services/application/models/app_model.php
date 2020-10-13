<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class App_model extends CI_Model {
    
    //--- Usuarios ---//

    public function compare_correo_password($user, $password) {
        $values = array(
            'email' => $user,
            'password' => $password
        );
        $this->db->where($values);
        $result = $this->db->get('usuarios');
        return ($result != '') ? $result->result_array() : false;
    }

    public function get_usuario_byCorreo($correo) {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('eliminado', 0);
        $this->db->where('email', $correo);
        $result = $this->db->get();

        return ($result->num_rows() > 0) ? true : false;
    }

    public function add_usuario($nombre, $apellido, $password, $correo, $telefono, $direccion, $idGenUsuario) {
        $values = array(
            'email' => $correo,
            'telefono' => $telefono,
            'nombreCompleto' => $nombre,
            'apellido' => $apellido,
            'direccion' => $direccion,
            'password' => $password,
            'idGenUsuario' => $idGenUsuario,
            'eliminado' => 0
        );
        $result = $this->db->insert('usuarios', $values);

        return (($this->db->affected_rows() > 0) ? true : false);
    }

    //--- Tipo Ingrediente ---//

    public function add_tipo_ingrediente($nombre, $eliminado) {
        $values = array(
            'nombre' => $nombre,
            'eliminado' => $eliminado
        );
        $result = $this->db->insert('tipo_ingrediente', $values);

        return ($result != '') ? true : false;
    }

    public function update_tipo_ingrediente($id, $nombre) {
        $values = array(
            'nombre' => $nombre
        );
        $this->db->where('idTipoIngrediente', $id);
        $result = $this->db->update('tipo_ingrediente', $values);

        return ($result != '') ? true : false;
    }

    public function delete_tipo_ingrediente_by_id($id) {
        $values = array(
            'eliminado' => 1
        );
        $this->db->where('idTipoIngrediente', $id);
        $result = $this->db->update('tipo_ingrediente', $values);
        return ($result != '') ? true : false;
    }
    
    public function get_tipo_ingrediente() {
        $this->db->where('eliminado', 0);
        $result = $this->db->get('tipo_ingrediente');
        
        return ($result != '') ? $result->result_array() : false;
    }

    //--- Ingrediente ---//

    public function get_ingrediente() {
        $this->db->select('i.idIngrediente, i.nombre as nombreIngrediente, i.idTipoIngrediente, ti.nombre as nombreTipoIngrediente');
        $this->db->where('i.eliminado', 0);
        $this->db->from('ingrediente as i');
        $this->db->join('tipo_ingrediente as ti', 'ti.idTipoIngrediente = i.idTipoIngrediente');
        $result = $this->db->get();
        
        return ($result != '') ? $result->result_array() : false;
    }

    public function add_ingrediente($nombre, $tipo_ingrediente, $eliminado) {
        $values = array(
            'nombre' => $nombre,
            'idTipoIngrediente' => $tipo_ingrediente,
            'eliminado' => $eliminado
        );
        $result = $this->db->insert('ingrediente', $values);

        return ($result) ? true : false;
    }
    
    public function update_ingrediente($id, $nombre, $tipo_ingrediente) {
        $values = array(
            'nombre' => $nombre,
            'idTipoIngrediente' => $tipo_ingrediente,
        );
        $this->db->where('idIngrediente', $id);
        $result = $this->db->update('ingrediente', $values);
        return ($result) ? true : false;
    }
    
    public function delete_ingrediente_by_id($idIngrediente) {
        $values = array(
            'eliminado' => 1
        );
        $this->db->where('idIngrediente', $idIngrediente);
        $result = $this->db->update('ingrediente', $values);
        return ($result) ? true : false;
    }

    //--- Comida ---//
    
    public function get_comida() {
        $this->db->where('eliminado', 0);
        $result = $this->db->get('comida');

        return ($result != '') ? $result->result_array() : false;
    }
    
    public function get_ultima_comida() {
        $this->db->where('eliminado', 0);
        $this->db->limit(1);
        $this->db->order_by('idComida', 'DESC');
        $result = $this->db->get('comida');

        return ($result != '') ? $result->result_array() : false;
    }

    public function add_comida($comida, $descripcion) {
        $values = array(
            'nombre' => $comida,
            'descripcion' => $descripcion,
            'eliminado' => 0
        );
        $result = $this->db->insert('comida', $values);

        return ($result != '') ? true : false;
    }
    
    public function update_comida($idComida, $comida, $descripcion) {
        $values = array(
            'nombre' => $comida,
            'descripcion' => $descripcion
        );
        $this->db->where('idComida', $idComida);
        $result = $this->db->update('comida ', $values);

        return ($result != '') ? true : false;
    }
        
    public function delete_comida($idComida) {
        $values = array(
            'eliminado' => 1
        );
        $this->db->where('idComida', $idComida);
        $result = $this->db->update('comida', $values);

        return ($result != '') ? true : false;
    }

    public function add_ingrediente_x_comida($idComida, $idIngrediente, $cantidad, $idUnidad) {
        $values = array(
            'idComida' => $idComida,
            'idIngrediente' => $idIngrediente,
            'cantidad' => $cantidad,
            'idUnidad' => $idUnidad
        );
        $result = $this->db->insert('ingrediente_x_comida', $values);

        return ($result != '') ? true : false;
    }

    public function update_ingrediente_x_comida($idIngredienteXComida , $idIngrediente, $cantidad, $idUnidad) {
        $values = array(
            'idIngrediente' => $idIngrediente,
            'cantidad' => $cantidad,
            'idUnidad' => $idUnidad
        );
        $this->db->where('idIngredienteXComida', $idIngredienteXComida);
        $result = $this->db->update('ingrediente_x_comida', $values);

        return ($result != '') ? true : false;
    }

    public function delete_ingrediente_x_comida($idComida) {
        $values = array(
            'eliminado' => 1
        );
        $this->db->where('idComida', $idComida);
        $result = $this->db->update('ingrediente_x_comida', $values);

        return ($result != '') ? true : false;
    }

    public function delete_ingrediente_x_comida_idIngredienteXComida($idIngredienteXComida) {
        $values = array(
            'eliminado' => 1
        );
        $this->db->where('idIngredienteXComida', $idIngredienteXComida);
        $result = $this->db->update('ingrediente_x_comida', $values);

        return ($result != '') ? true : false;
    }

    public function get_ingrediente_x_comida_by_idComida($idComida) {
        $this->db->select('i.idIngrediente, i.nombre as ingrediente, ixc.cantidad, u.idUnidad, u.nombre as unidad');
        $this->db->where('ixc.eliminado', 0);
        $this->db->where('ixc.idComida', $idComida);
        $this->db->from('ingrediente_x_comida as ixc');
        $this->db->join('ingrediente as i', 'i.idIngrediente = ixc.idIngrediente');
        $this->db->join('unidad as u', 'u.idUnidad = ixc.idUnidad');
        $result = $this->db->get();
        
        return ($result != '') ? $result->result_array() : false;
    }
    
    //--- Vianda ---//
    
    public function get_vianda() {
        $this->db->where('eliminado', 0);
        $result = $this->db->get('vianda');

        return ($result != '') ? $result->result_array() : false;
    }
    
    public function get_ultima_vianda() {
        $this->db->where('eliminado', 0);
        $this->db->limit(1);
        $this->db->order_by('idVianda', 'DESC');
        $result = $this->db->get('vianda');

        return ($result != '') ? $result->result_array() : false;
    }

    public function add_vianda($vianda, $idEstado, $precio) {
        $values = array(
            'nombre' => $vianda,
            'idEstado' => $idEstado,
            'precio' => $precio,
            'eliminado' => 0
        );
        $result = $this->db->insert('vianda', $values);

        return ($result != '') ? true : false;
    }
    
    public function update_vianda($idVianda, $vianda, $idEstado, $precio) {
        $values = array(
            'nombre' => $vianda,
            'idEstado' => $idEstado,
            'precio' => $precio
        );
        $this->db->where('idVianda', $idVianda);
        $result = $this->db->update('vianda', $values);

        return ($result != '') ? true : false;
    }
        
    public function delete_vianda($idVianda) {
        $values = array(
            'eliminado' => 1
        );
        $this->db->where('idVianda', $idVianda);
        $result = $this->db->update('vianda', $values);

        return ($result != '') ? true : false;
    }

    public function add_comida_x_vianda($idVianda, $idComida, $cantidad) {
        $values = array(
            'idVianda' => $idVianda,
            'idComida' => $idComida,
            'cantidad' => $cantidad
        );
        $result = $this->db->insert('comida_x_vianda', $values);

        return ($result != '') ? true : false;
    }

    public function update_comida_x_vianda($idComidaXVianda , $idVianda, $idComida, $cantidad) {
        $values = array(
            'idVianda' => $idVianda,
            'idComida' => $idComida,
            'cantidad' => $cantidad
        );
        $this->db->where('idComidaXVianda', $idComidaXVianda);
        $result = $this->db->update('comida_x_vianda', $values);

        return ($result != '') ? true : false;
    }

    public function delete_comida_x_vianda($idVianda) {
        $values = array(
            'eliminado' => 1
        );
        $this->db->where('idVianda', $idVianda);
        $result = $this->db->update('comida_x_vianda', $values);

        return ($result != '') ? true : false;
    }

    public function delete_comida_x_vianda_idComidaXVianda($idComidaXVianda) {
        $values = array(
            'eliminado' => 1
        );
        $this->db->where('idComidaXVianda', $idComidaXVianda);
        $result = $this->db->update('comida_x_vianda', $values);

        return ($result != '') ? true : false;
    }
    
    public function get_comida_x_vianda_by_idVianda($idVianda) {
        $this->db->select('c.idComida, c.nombre as comida, c.descripcion as descripcionComida, cxv.cantidad');
        $this->db->where('cxv.eliminado', 0);
        $this->db->where('cxv.idVianda', $idVianda);
        $this->db->from('comida_x_vianda as cxv');
        $this->db->join('comida as c', 'c.idComida = cxv.idComida');
        $this->db->join('vianda as v', 'v.idVianda = cxv.idVianda');
        $result = $this->db->get();
        
        return ($result != '') ? $result->result_array() : false;
    }

}
