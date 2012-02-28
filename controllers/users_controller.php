<?php 
class UsersController extends AppController
{
	var $name = "Users";
	var $helpers = array('Html', 'Form');
	
	function index()
	{
		
	}
	
	function beforeFilter()
	{
		$this->__validateLoginStatus();
	}
	
	function login()
	{
		if(empty($this->data) == false)
		{
			if(($user = $this->User->validateLogin($this->data['User'])) == true)
			{
				$this->Session->write('User', $user);
				$this->Session->setFlash('Bienvenido!');
				$this->redirect(array('controller' => 'pages', 'action' => 'welcome'));
				exit();
			}
			else
			{
				$this->Session->setFlash('Lo siento, tu usuario o contrase�a no son correctos.');
				$this->redirect(array('controller' => 'users', 'action' => 'login'));
				exit();
			}
		}
        $this->set('title', 'Login');
		$this->layout = 'login';
	}
	
	function logout()
	{
		$this->Session->destroy('user');
		$this->Session->setFlash('You\'ve successfully logged out.');
		$this->redirect('login');
	}
		
	function __validateLoginStatus()
	{
		if($this->action != 'login' && $this->action != 'logout')
		{
			if($this->Session->check('User') == false)
			{
				$this->redirect('login');
				$this->Session->setFlash('The URL you\'ve followed requires you login.');
			}
		}
	}
	
}

?>