<?php

/**
 *
 */
class PerfilController extends \HXPHP\System\Controller
{

    public function __construct($configs)
    {
        parent::__construct($configs);

        $this->load(
            'Services\Auth',
            $configs->auth->after_login,
            $configs->auth->after_logout,
            true
        );

        $this->auth->redirectCheck();

        $this->load(
            'Helpers\Menu',
            $this->request,
            $this->configs,
            $this->auth->getUserRole()
        );

        $user_id = $this->auth->getUserId();

        $this->view->setTitle('Editar perfil')
            ->setVar('user', User::find($user_id));
    }

    public function editarAction()
    {

    }

    public function atualizarAction()
    {
        $user_id = $this->auth->getUserId();

        $this->request->setCustomFilters(array(
            'email' => FILTER_VALIDATE_EMAIL
        ));

        $post = $this->request->post();


        if(!empty($post)){
            $atualizarUsuario = User::atualizar($user_id, $post);

            if($atualizarUsuario->status === false){
                $this->load('Helpers\Alert', array(
                    'danger',
                    'Oops! Não foi possível atualizar seu perfil. <br>
                        Verifique os erros abaixo',
                    $atualizarUsuario->errors
                ));
            }else{
                $this->load('Helpers\Alert', array(
                   'success',
                    'Uhuul! Perfil atualizado com sucesso!'
                ));
                $this->auth->login($atualizarUsuario->user-id, $atualizarUsuario->user->username);
            }
        }

    }


}