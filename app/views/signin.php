<h1>Вход на сайт</h1>
<p><?= $error_message?></p>
<form method="GET" action="/signin">
  <div>
    <label>Логин</label>
    <input type="text" name="user_login" value="<?= $user_login?>">
  </div>
  <div>
    <label>Пароль</label>
    <input type="text" name="user_pass" value="<?= $user_pass?>">
  </div>
  <div>
    <input type="submit" name="submit" value="<?= $submit_text?>">
  <div>
</form>