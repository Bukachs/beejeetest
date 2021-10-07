<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title><?= $page_title ?></title>
        <link href="/bootstrap/assets/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
          <header class="d-flex justify-content-center py-3">
            <nav>
            <ul class="nav nav-pills">
              <li class="nav-item"><a href="/home" class="nav-link <?= ( preg_match('/^(\/home)|(\/$)/ui', $_SERVER['REQUEST_URI'] )  ? ' active' : '' ) ?>">Домой</a></li>
              <li class="nav-item"><a href="/add" class="nav-link<?= ( preg_match('/^\/add/ui', $_SERVER['REQUEST_URI'] )  ? ' active' : '' ) ?>">Добавить задачу</a></li>
              <li class="nav-item"><?= $_SESSION['is_admin'] ? '<a href="/signout" class="nav-link">Выход</a>' : '<a href="/signin" class="nav-link'.( preg_match('/^\/signin/ui', $_SERVER['REQUEST_URI'] )  ? ' active' : '' ).'">Вход</a>' ?></li>
            </ul>
            </nav>
          </header>
        </div>
        <div class="main">
            <?= $body ?>
        </div>
    </body>
</html>