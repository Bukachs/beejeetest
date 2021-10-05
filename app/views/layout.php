<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title><?= $page_title ?></title>
    </head>
    <body>
        <header>
            <nav>
                <a href="/home">Домой</a>
                <a href="/add">Добавить задачу</a>
                <?= $_SESSION['is_admin'] ? '<a id="portfolio_button" href="/signout">Выход</a>' : '<a href="/signin">Вход</a>' ?>
                
            </nav>
        </header>
        <div class="main">
                <?= $body ?>
        </div>
    </body>
</html>