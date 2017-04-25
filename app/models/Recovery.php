<?php

class Recovery extends \HXPHP\System\Model{

	public static function validar($user_email){
		
		$callBackObj = new \stdClass;
		$callBackObj->user = null;
		$callBackObj->code = null;
		$callBackObj->status = false;

		$user_exists = User::find_by_email($user_email);

		if(!is_null($user_exists)){
			$callBackObj->status = true;
			$callBackObj->user = $user_exists;

			self::delete_all(array(
				'conditions' => array(
					'users_id = ?',
					$user_exists->id
				)
			));	
		} else{
			$callBackObj->code = 'nenhum-usuario-encontrado';
		}

		return $callBackObj;
	}
}