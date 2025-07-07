<?php

$router->get('/', 'homeController.php');
$router->get('/articles', 'articles/index.php');
$router->get('/articles-create', 'articles/create.php');
$router->post('/articles-create', 'articles/store.php');
$router->delete('/articles-delete', 'articles/destroy.php');
$router->get('/articles-edit', 'articles/edit.php');
$router->post('/articles-store-edited', 'articles/storeEdited.php');