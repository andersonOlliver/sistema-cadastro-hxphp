<?php
//Constantes
$configs = new HXPHP\System\Configs\Config;

$configs->env->add('development');

$configs->env->add('development');
$configs->env->development->baseURI = '/sistema/';

$configs->env->development->database->setConnectionData(array('host' => 'localhost',
    'user' => 'root',
    'password' => '12345678',
    'dbname' => 'sistemahx',
    'charset' => 'utf8'
));

$configs->env->development->auth->setURLs('/sistema/home/','/sistema/login/');

return $configs;