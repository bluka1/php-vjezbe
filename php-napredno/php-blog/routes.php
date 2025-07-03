<?php

$router->get('/', 'homeController.php');
$router->get('/articles', 'articles/index.php');
$router->get('/articles-create', 'articles/create.php');
$router->post('/articles-create', 'articles/store.php');