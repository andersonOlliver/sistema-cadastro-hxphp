<?php

use \HXPHP\System\Tools;

class User extends \HXPHP\System\Model {

	static $validates_presence_of = array(
		array(
			'name',
			'message' => 'O nome é um campo obrigatório.'
		),
		array(
			'email',
			'message' => 'O e-mail é um campo obrigatório.'
		),
		array(
			'username',
			'message' => 'O nome de usuário é um campo obrigatório.'
		),
		array(
			'password',
			'message' => 'A senha é um campo obrigatório.'
		)
	);

	static $validates_uniqueness_of = array(
    	array(
    		'username', 
    		'message' => 'Já existe um usuário com este nome de usuário cadastrado.'
    	),
    	array(
    		'email',
    		'message' => 'Já existe um usuário com este email cadastrado.'
    	)
 	);


	public static function cadastrar(array $post){
		
		$callBackObj = new \stdClass;
		$callBackObj->user = null;
		$callBackObj->status = false;
		$callBackObj->errors= array();

		$role = Role::find_by_role('user');

		if(is_null($role)){
			array_push($callBackObj->errors, 'A role user não existe. Contate o administrador');

			return callBackObj;
		}

		$user_data = array(
			'role_id' => $role->id,
			'status' => 1
		);

		$password = Tools::hashHX($post['password']);

		$post = array_merge($post, $user_data, $password);

		$cadastrar =  self::create($post);

		if($cadastrar->is_valid()){
			$callBackObj->user = $cadastrar;
			$callBackObj->status = true;
			return $callBackObj;
		}

		$errors = $cadastrar->errors->get_raw_errors();
		foreach ($errors as $field => $message) {
			array_push($callBackObj->errors, $message[0]);
		}

		return $callBackObj;
	}


	public static function login(array $post){
		$user = self::find_by_username($post['username']);

		if(!is_null($user)){
			$password = Tools::hashHX($post['password'], $user->salt);

			if(LoginAttempt::existemTentativas($user->id)){

				if($password['password'] === $user->password){
					LoginAttempt::limparTentativas($user->id);
					
				}else{
					LoginAttempt::registrarTentativa($user->id);
				}
			}
		}

	}
}