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
    		array('username', 'email'),
    		'message' => 'Já existe um usuário com este email e/ou nome de usuário cadastrado.'
    	)
 	);


	public static function cadastrar(array $post){
		
		$callbakObj = new \stdClass;
		$callbakObj->user = null;
		$callbakObj->status = false;
		$callbakObj->errors= array();

		$role = Role::find_by_role('user');

		if(is_null($role)){
			array_push($callbakObj->errors, 'A role user não existe. Contate o administrador');

			return callbakObj;
		}

		$user_data = array(
			'role_id' => $role->id,
			'status' => 1
		));

		$password = Tools::hashHX($post['password']);

		$post = array_merge($post, $user_data, $password);

		$cadastrar =  self::create($post);

		if($cadastrar->is_valid()){
			$callbakObj->user = $cadastrar;
			$callbakObj->status = true;
			return $callbakObj;
		}

		$errors = $cadastrar->errors->get_raw_errors();
		foreach ($errors as $field => $message) {
			array_push($callbakObj->errors, $message[0]);
		}

		return $callbakObj;
	}
}