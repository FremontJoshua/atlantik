<?php

chdir('..');

session_start();

require './vendor/autoload.php';

\Kernel\Connection::setup('mysql:host=localhost;dbname=roc_atlantik', 'root', 'pwsio', array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

$controllerName=  '\\Controllers\\'.Kernel\Utils::request('controller','TestModels');
$actionName=  Kernel\Utils::request('action','dashboard');

call_user_func($controllerName.'::_setAction',$actionName);

Kernel\Controller::getView()->display();
