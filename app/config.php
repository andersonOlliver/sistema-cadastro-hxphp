<?php
//Constantes
$configs = new HXPHP\System\Configs\Config;


$configs->env->add('development');
$configs->env->development->baseURI = '/sistema/';

$configs->env->development->database->setConnectionData(array(
    'host' => 'localhost',
    'user' => 'root',
    'password' => '12345678',
    'dbname' => 'sistemahx',
    'charset' => 'utf8'
));

$configs->env->development->auth->setURLs('/sistema/home/', '/sistema/login/');

$configs->env->development->menu->setMenus(array(
    'Home/dashboard' => '%baseURI%/home',
    'Link/user' => 'http://www.google.com',
    'Submenus/cog' => array(
        'Painel/dashboard' => '%baseURI%/home',
        'Atualizações/hand-o-up' => '%baseURI%/atualizacoes'
    )
), 'user');

$configs->env->development->menu->setMenus(array(
    'Home/dashboard' => '%baseURI%/home'
));

$configs->env->development->menu->setConfigs(array(
    'container' => 'nav',
    'container_class' => 'navbar navbar-default',
    'menu_class' => 'nav navbar-nav'
));


$configs->env->development->email = new \HXPHP\System\Configs\Modules\Mail();

$configs->env->development->email->setFrom([
    'from' => 'Remetente',
    'from_mail' => 'email@remetente.com.br'
]);


/*
$configs->env->add('production');
$configs->env->production->baseURI = '/devStrong/sistema/';

$configs->env->production->database->setConnectionData(array(
	'host' => 'localhost',
    'user' => 'devStrong',
    'password' => 'BQNDlK8t',
    'dbname' => 'devStrong',
    'charset' => 'utf8'
));

$configs->env->production->auth->setURLs('/devStrong/sistema/home/','/devStrong/sistema/login/');
*/
return $configs;