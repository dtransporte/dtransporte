<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE INICIALIZACION DE LA APLICACION
|--------------------------------------------------------------------------
| Inicializa las variables globales a ser usadas en la aplicacion
| 
|
*/

class Init extends CI_Model
{
	public $activeUser = NULL;
	public $activeLang = NULL;
	//public $appMenu = NULL;
	public $activeRequirements = NULL;
	public $activeQuotations = NULL;
	public $cookieSession = NULL;
	public $isMobile = NULL;

	function __construct()
	{
		parent::__construct();
		$this->_setCookie();
		$this->_setActiveUser();
		$this->_checkUserActive();
		$this->_setLang();
		$this->_loadModels();
		$this->isMobile = $this->agent->is_mobile() === TRUE ? 1 : 0;
	}

	private function _setCookie()
	{
		$this->cookieSession = get_cookie($this->config->item('sess_cookie_name'));
		$cookieUser = $this->config->item('dtr-cookie-user');
		if(get_cookie($cookieUser['name']) === NULL)
		{
			delete_cookie($cookieUser);
			$cookieUser['value'] = (isset($_SESSION['DTRANSPORTE-USER']) OR isset($_SESSION['DTRANSPORTE-EMPLOYEE'])) ? 1 : 0;
			set_cookie($cookieUser);
		}
	}

	/*
	|--------------------------------------------------------------------------
	|	Chequea que el usuario tenga el estado activo.
	|	Si no lo tiene finaliza la sesion y redirige a la pagina publica
	|--------------------------------------------------------------------------
	|	@access private
	|	@params void
	|	@return void
	|--------------------------------------------------------------------------
	*/
	private function _checkUserActive()
	{
		if((isset($this->activeUser) AND $this->activeUser->user_active == 0))
		{
			session_destroy();
			$this->redirectTo('dtr-message-user-no-active');
		}
	}

	/*
	|--------------------------------------------------------------------------
	|	Establece los datos del usuario logueado
	|--------------------------------------------------------------------------
	|	@access private
	|	@params void
	|	@return void
	|--------------------------------------------------------------------------
	*/
	private function _setActiveUser()
	{
		if(isset($_SESSION['DTRANSPORTE-USER']))
		{
			$this->load->model('Users/getusers');
            $role = $_SESSION['DTRANSPORTE-USER']->user_role;
			$id = $_SESSION['DTRANSPORTE-USER']->id_user;
			$this->activeUser = $this->getusers->get($id);
			$this->activeUser->sess_start = $_SESSION['DTRANSPORTE-USER']->sess_start;
			$this->activeUser->userDir = base_url().'dtr-users/'.$id;
			$this->activeUser->userPath = FCPATH.'dtr-users/'.$id;
			$this->activeUser->image = base_url().$this->getusers->getImage($id);
			$this->activeUser->dtf = $this->activeUser->user_dformat . ' ' . $this->activeUser->user_tformat;
			//$this->appMenu = $this->activeUser->user_role === 'user' ? 'dtr-user-menu' : 'dtr-assoc-menu';
		}
		elseif (isset($_SESSION['DTRANSPORTE-EMPLOYEE']))
		{
			$this->load->model('Users/getusers');
			$id = $_SESSION['DTRANSPORTE-EMPLOYEE']->id_user;
			$role = $_SESSION['DTRANSPORTE-EMPLOYEE']->user_role;
			if($role === 'admin')
            {
                $this->load->database('admin');
            }
			$this->activeUser = $this->getusers->get($id);
			$this->activeUser->userDir = base_url().'dtr-employees/'.$id;
			$this->activeUser->userPath = FCPATH.'dtr-employees/'.$id;
			$this->activeUser->image = base_url().$this->getusers->getImage($id);
			$this->activeUser->dtf = $this->activeUser->user_dformat . ' ' . $this->activeUser->user_tformat;
			//$this->appMenu = "dtr-{$this->activeUser->user_role}-menu";
		}
	}

	/*
	|--------------------------------------------------------------------------
	|	Establece el idioma de la aplicacion
	|--------------------------------------------------------------------------
	|	@access private
	|	@params void
	|	@return void
	|--------------------------------------------------------------------------
	*/
	private function _setLang()
	{
		if(! isset($_SESSION['DTRANSPORTE-USER']))
		{
			$this->activeLang = $this->config->item('dtr-default-lang');
		}
		else
		{
			$this->activeLang = $this->activeUser->user_lang;
		}
		$this->lang->load('common', $this->activeLang);
		$this->lang->load('menu', $this->activeLang);
		$this->lang->load('message', $this->activeLang);
	}

	/*
	|--------------------------------------------------------------------------
	|	Carga los modelos
	|--------------------------------------------------------------------------
	|	@access private
	|	@params void
	|	@return void
	|--------------------------------------------------------------------------
	*/
	private function _loadModels()
	{
		$this->load->model('Users/getusers');
		if(isset($_SESSION['DTRANSPORTE-USER']))
		{
			// $this->load->model('Products/getproducts');
		}
	}

	/*
	|--------------------------------------------------------------------------
	|	Redirirge a la pagina home del usuario logueado
	|--------------------------------------------------------------------------
	|	@access private
	|	@params void
	|	@return void
	|--------------------------------------------------------------------------
	*/
	public function redirectTo($idMessage=NULL)
	{
		if(isset($_SESSION['DTRANSPORTE-USER']))
		{
			$user = $this->activeUser;
			$file = ucwords($user->user_role);
			if($user->user_first_time == 1)
			{
				redirect(base_url()."index.php/First/{$file}", 'refresh');
			}
			if(isset($idMessage))
			{
				redirect(base_url()."index.php/Place/{$file}/index/{$idMessage}", 'refresh');
			}
			else
			{
				redirect(base_url()."index.php/Place/{$file}", 'refresh');
			}
		}
		elseif(isset($_SESSION['DTRANSPORTE-EMPLOYEE']))
		{
			$user = $this->activeUser;
			$file = ucwords($user->user_role);
			redirect(base_url()."index.php/Place/{$file}", 'refresh');
		}
		if(isset($idMessage))
		{
			redirect(base_url()."index.php/home/index/{$idMessage}", 'refresh');
		}
		redirect(base_url(), 'refresh');
	}

	/*
	|--------------------------------------------------------------------------
	|	Establece la variable de configuracion de captcha
	|--------------------------------------------------------------------------
	|	@access public
	|	@params void
	|	@return array
	|--------------------------------------------------------------------------
	*/
	public function setCaptcha()
	{
		$captcha = $this->config->item('dtr-captcha');
		$captcha['img_path'] = FCPATH.$captcha['img_path'];
		$captcha['img_url'] = base_url().$captcha['img_url'];
		return $captcha;
	}
}

/*
	https://dtransporte.com/demo/index.php/First/Assoc
	https://dtransporte.com/demo/index.php/Home/Assoc
*/