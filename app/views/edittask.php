<h1>Редактирование задачи</h1>
<p><?= $error_message?></p>
<form method="GET" action="/edit">
  <div>
    <label>Имя пользователя</label>
    <input type="text" name="user_name" value="<?= $user_name?>">
  </div>
  <div>
    <label>Эл. почта</label>
    <input type="text" name="user_email" value="<?= $user_email?>">
  </div>
  <div>
    <label>Название</label>
    <input type="text" name="task_name" value="<?= $task_name?>">
  </div>
  <div>
    <label>Задача</label>
    <textarea type="text" name="task_body"><?= $task_body?></textarea>
  <div>
  <div>
    <input id="task_closed" type="checkbox" name="task_closed" <?= ( $task_closed ? 'checked="checked"': '' ) ?>>
    <label for="task_closed">Задача выполнена</label>
  <div>
    <div>
    <input type="hidden" name="task_id" value="<?= $task_id?>">
  <div>
  <div>
    <input type="submit" name="submit" value="<?= $submit_text?>">
  <div>
</form>