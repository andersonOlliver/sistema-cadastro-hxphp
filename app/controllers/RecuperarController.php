<?php

/**
* 
*/
class RecuperarController extends \HXPHP\System\Controller
{
	public function __construct($configs){
		parent::__construct($configs);

		$this->load(
			'Services\Auth',
			$configs->auth->after_login,
			$configs->auth->after_logout,
			true
		);
	}

	public function solicitarAction(){

		$this->view->setFile('index');

		$this->load('Modules\Messages', 'password-recovery');
		$this->messages->setBlock('alerts');

		$this->request->setCustomFilters(array(
			'email' => FILTER_VALIDATE_EMAIL
		));

		$email = $this->request->post('email');

		$error = null;

		if(!is_null($email) && $email !== false){
			$validar = Recovery::validar($email);

			if($validar->status === false){
				$error = $this->messages->getByCode($validar->code);
			} else{
				$this->load(
					'Services\PasswordRecovery',
					$this->configs->site->url . $this->configs->baseURI . 'recuperar/redefinir/'
				);

				Recovery::create(array(
					'users_id' => $validar->user->id,
					'token' => $this->passwordrecovery->token,
					'status' => 0
				));

				$message = $this->messages->messages->getByCode('link-enviado', array(
					'message'=>array(
						$validar->user->name,
						$this->passwordrecovery->link,
						$this->passwordrecovery->link
					)

				));

				$this->load('Services\Email');

				$envioDoEmail = $this->email->send(
					$validar->user->email,
					$message['subject'],
					$message['message'] . 'IntegralSeg',
					array(
						'to' => $this->configs->email->from_mail,
						'subject'=> $this->configs->email->from
					)
				);

				if($envioDoEmail === false){
					$error = $this->messages->getByCode('email-nao-enviado');
				}
			}
		}else{
			$error = $this->messages->getByCode('nenhum-usuario-encontrado');
		}

		if(!is_null($error)){
			$this->load('Helpers\Alert', $error);
		} else{
			$success = $this->messages->getByCode('link-enviado');

			$this->view->setFile('blank');

			$this->load('Helpers\Alert', $success);
		}
	}


	public function redefinirAction($token){

	}
	
	public function alterarSenhaAction($token){

	}
}