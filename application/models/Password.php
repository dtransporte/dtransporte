<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| MODELO DE GESTION DE CONTRASENIAS
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/models
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : Password.php
|--------------------------------------------------------------------------
|
*/
class Password extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/*
	---------------------------------------------------------------------------
		Descripcion: Obtiene la contrasena de usuario.
		
		@access public
		@params int
		@return string
	---------------------------------------------------------------------------
	*/
	function get($id_user)
	{
		$query = $this->db->get_where('dtr_users', ['id_user' => $id_user]);
		$pwd = $query->row();
		return $pwd->user_pwd;
	}

	/*
	---------------------------------------------------------------------------
		Descripcion: Crea una contrasena de usuario.
		
		@access public
		@params string
		@return string
	---------------------------------------------------------------------------
	*/
	function setPwd($pwd){
		$cost = $this->_setPwdCost($pwd);
		return password_hash($pwd, PASSWORD_DEFAULT, ['cost'=> $cost]);
	}

	/*
	---------------------------------------------------------------------------
		Descripcion: Comprueba que la contrasena coincida con un hash.
		
		@access public
		@params string
		@return boolean
	---------------------------------------------------------------------------
	*/
	function pwdVerify($pwd, $hash, $iduser){
		if(password_verify($pwd, $hash)){
			$this->_checkRehash($pwd, $hash, $iduser);
			return TRUE;
		}
		return FALSE;
	}

	function _setPwdCost($pwd){
		$timeTarget = 0.05; // 50 milisegundos 
		$coste = 8;
		do {
		    $coste++;
		    $ini = microtime(true);
		    password_hash($pwd, PASSWORD_DEFAULT, ["cost" => $coste]);
		    $end = microtime(true);
		} while (($end - $ini) < $timeTarget);
		return $coste;
	}

	/*
	---------------------------------------------------------------------------
		Descripcion: comprueba si el hash facilitado implementa el algoritmo y 
			opciones proporcionadas. 
			Si no, asume que el hash necesita volver a ser generado.
		@access private
		@params string
		@return void
	---------------------------------------------------------------------------
	*/
	function _checkRehash($pwd, $hash, $iduser){
		$cost = $this->_setPwdCost($pwd);
		if(password_needs_rehash($hash, PASSWORD_DEFAULT, ['cost'=> $cost])){
			// Si es así, crear un nuevo hash y reemplazar el antiguo
			$newHash = password_hash($pwd, PASSWORD_DEFAULT, ['cost'=> $cost]);
			$this->db->where('id_user', $iduser);
			$data['user_pwd'] = $newHash;
			$this->db->update('dtr_users', $data);
		}
	}

	/*
	---------------------------------------------------------------------------
		Descripcion: Actualiza contrasena de usuario.
		
		@access public
		@params string
		@return boolean
	---------------------------------------------------------------------------
	*/
	function update($curpwd, $newpwd, $iduser){
		$user = $this->user->get($iduser);
		if($this->pwdVerify($curpwd, $user->user_pwd, $iduser)){
			$pwd = $this->setPwd($newpwd);
			$data['user_pwd'] = $pwd;
			$this->db->where('id_user', $iduser);
			return $this->db->update('dtr_users', $data);
		}
		return FALSE;
	}

	/*
	---------------------------------------------------------------------------
		Descripcion: Establece las opciones de validacion la contrasenia de usuario.
		
		@access public
		@params string
		@return array
	---------------------------------------------------------------------------
	*/
	public function setLength()
	{
		$pwdSettings = $this->config->item('dtr-password');
		$validFields = $this->lang->line('dtr-password-length');
		$search = ['%min%', '%max%'];
		$replace = [$pwdSettings['minlength'], $pwdSettings['maxlength']];
		return [
			'min' => $pwdSettings['minlength'],
			'max' => $pwdSettings['maxlength'],
			'msg' => str_replace($search, $replace, $validFields)
		];
	}
}