<?php

$router->get('/', 'HomeController', 'index');
$router->get('/articles', 'ArticlesController', 'index');
$router->get('/articles-create', 'ArticlesController', 'create');
$router->post('/articles-create', 'ArticlesController', 'store');
$router->delete('/articles-delete', 'ArticlesController', 'destroy');
$router->get('/articles-edit', 'ArticlesController', 'edit');
$router->post('/articles-store-edited', 'ArticlesController', 'storeEdited');