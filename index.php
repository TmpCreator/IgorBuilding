<?php

require_once 'Libs/Autoload.php';

use Libs\Route;
use Libs\Globals;

$route = new Route();

// Инициализация основных классов (шаблонизатор, запрос...)
// В Globals передаем имя шаблона
new Globals('Default');

$route->add('', 'Index');
$route->add('index', 'Index', false);
$route->add('home', 'Index', false);
$route->add('admin', 'Admin');

// Регистрация изображений и стилей
$route->registerResources('Default');

$route->render();
/*
$reader = new Libs\Annotations\Reader('\Model\User');
echo '<br><br><pre>';
print_r($reader->getParameters());*/