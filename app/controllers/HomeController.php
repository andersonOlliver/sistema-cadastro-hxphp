<?php
use \HXPHP\System\Controller;

class HomeController extends Controller
{
    public function __construct($configs){
        parent::__construct($configs);

        $this->load(
            'Services\Auth',
            $configs->auth->after_login,
            $configs->auth->after_logout,
            true
        );

        $this->auth->redirectCheck();

        $user_id = $this->auth->getUserId();

        $this->view->setTitle('Administrativo')
            ->setVar('user', User::find($user_id));
    }
}