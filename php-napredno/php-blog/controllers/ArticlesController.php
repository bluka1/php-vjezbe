<?php

class ArticlesController {

  public function create() {
    view('articles/create.view.php');
  }

  public function destroy() {
    require __DIR__ . '/../models/Article.php';
    $articleModel = new Article();

    $id = $_POST['id'];

    $articleModel->deleteById($id);

    redirect('/articles');
  }

  public function edit() {
    require __DIR__ . '/../models/Article.php';

    $id = $_GET['id'];

    $articleModel = new Article();

    $article = $articleModel->getById($id);

    view('articles/edit.view.php', [
      'article' => $article
    ]);
  }

  public function index() {
    require __DIR__ . '/../models/Article.php';

    $articleModel = new Article();
    $articles = $articleModel->getAll();

    view('articles/index.view.php', [
      'articles' => $articles
    ]);
  }

  public function store() {
    require __DIR__ . '/../models/Article.php';
    $articleModel = new Article();
    // validacija inputa - DZ

    $naslov = $_POST['naslov'];
    $tijelo = $_POST['body'];

    $articleModel->create(htmlspecialchars($naslov), htmlspecialchars($tijelo));

    // redirect korisnika na sve clanke
    redirect('/articles');
  }

  public function storeEdited () {
    require __DIR__ . '/../models/Article.php';
    $articleModel = new Article();

    $id = $_POST['id'];
    $naslov = $_POST['naslov'];
    $tijelo = $_POST['tijelo'];

    $articleModel->updateById($id, $naslov, $tijelo);

    redirect('/articles');
  }
}