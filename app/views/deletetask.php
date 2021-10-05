<h1>Подтвердите удаление задачи</h1>
<p><?= $error_message?></p>
<form method="GET" action="/delete">
  <div>
    <label>Название</label>
    <input type="text" name="task_name" value="<?= $task_name?>" readonly="1">
  </div>
  <div>
    <input type="hidden" name="task_id" value="<?= $task_id?>">
  <div>
  <div>
    <input type="hidden" name="confirm" value="1">
    <input type="submit" value="<?= $submit_text?>">
  <div>
</form>
<form method="GET" action="/home">
  <input type="submit" value="<?= $submit_decline_text?>">
</fotm>