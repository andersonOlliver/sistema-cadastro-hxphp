<?php

use \HXPHP\System\Model;

class Recovery extends Model
{

    static $belongs_to = array(
        array('user')
    );

    public static function validar($user_email)
    {

        $callBackObj = new \stdClass;
        $callBackObj->user = null;
        $callBackObj->code = null;
        $callBackObj->status = false;

        $user_exists = User::find_by_email($user_email);

        if (!is_null($user_exists)) {
            $callBackObj->status = true;
            $callBackObj->user = $user_exists;

            self::delete_all(array(
                'conditions' => array(
                    'user_id = ?',
                    $user_exists->id
                )
            ));
        } else {
            $callBackObj->code = 'nenhum-usuario-encontrado';
        }

        return $callBackObj;
    }

    public static function validarToken($token)
    {
        $callBackObj = new \stdClass;
        $callBackObj->user = null;
        $callBackObj->code = null;
        $callBackObj->status = false;

        $validar = self::find_by_token($token);


        if (!is_null($validar)) {
            $callBackObj->status = true;
            $callBackObj->user = $validar->user;
        } else {
            $callBackObj->code = 'token-invalido';
        }

        return $callBackObj;
    }

    public static function limpar($user_id){
        return self::delete_all(array(
            'conditions' => array(
                'user_id = ?',
                $user_id
            )
        ));
    }
}