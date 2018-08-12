<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|---------------------------------------------------------------------------------------
| MANEJA LA ESTRUCTURA DE DIRECTORIOS DE USUARIOS
|---------------------------------------------------------------------------------------
| 
|
*/

class Dirstruct extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	/*
	|----------------------------------------------------------------------------------
	|	Crea la estructura de directorios del usuario
	|----------------------------------------------------------------------------------
	|	@access public
	|	@params int
	|	@return bool
	|----------------------------------------------------------------------------------
	*/
	public function create($id_user)
	{
		$user = $this->getusers->get($id_user);
		$path = ($user->user_role === 'user' OR $user->user_role === 'assoc') ? FCPATH.'dtr-users/' : FCPATH.'dtr-employees/';
		$path .= $id_user;
		if(! file_exists($path) AND mkdir($path))
		{
			$dirs = ['me', 'temp'];
			
			if($user->user_role === 'assoc')
			{
				$dirs[] = 'assets';
			}
			foreach ($dirs as $dir)
			{
				if(! mkdir($path.'/'.$dir))
				{
					return FALSE;
				}
			}
			return TRUE;
		}
		return TRUE;
	}

	/*
	|----------------------------------------------------------------------------------
	|	Elimina la estructura de directorios del usuario
	|----------------------------------------------------------------------------------
	|	@access public
	|	@params int
	|	@return bool
	|----------------------------------------------------------------------------------
	*/
	public function delete($id_user)
	{
		$user = $this->getusers->get($id_user);
		$path = ($user->user_role === 'user' OR $user->user_role === 'assoc') ? FCPATH.'dtr-users/' : FCPATH.'dtr-employees/';
		$path .= $id_user;
		if(file_exists($path))
		{
			return delete_files($path, TRUE);
		}
		return TRUE;
	}
}