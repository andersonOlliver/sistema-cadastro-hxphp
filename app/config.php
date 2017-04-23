<?php
//Constantes
$configs = new HXPHP\System\Configs\Config;

$configs->env->add('development');

$configs->env->add('development');
$configs->env->development->baseURI = '/sistema/';

$configs->env->development->database->setConnectionData(array('host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'dbname' => 'blog',
    'charset' => 'utf8'
));

return $configs;