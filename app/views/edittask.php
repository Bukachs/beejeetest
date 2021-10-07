<div class="container d-flex justify-content-center">
  <div class="col-md-7 col-lg-8">
    <div class="py-5 text-center">
      <h4 class="mb-3 pb-2 border-bottom">Редактирование задачи</h4>
      <p><?= $error_message?></p>
    </div>
    <form method="GET" action="/edit">
      <div class="row g-3">
        <div class="col-sm-6">
          <label class="form-label">Имя пользователя</label>
          <input type="text" class="form-control" name="user_name" value="<?= $user_name?>">
        </div>
        <div class="col-sm-6">
          <label class="form-label">Эл. почта</label>
          <input type="email" class="form-control" name="user_email" value="<?= $user_email?>">
        </div>
        <div class="col-sm-6">
          <label class="form-label">Название</label>
          <input type="text" class="form-control" name="task_name" value="<?= $task_name?>">
        </div>
        <div class="col-sm-6">
          <label class="form-label">Задача</label>
          <textarea type="text" class="form-control" name="task_body"><?= $task_body?></textarea>
        </div>
        <div class="col-sm-6">
          <input id="task_closed" class="form-check-input" type="checkbox" name="task_closed" <?= ( $task_closed ? 'checked="checked"': '' ) ?>>
          <label for="task_closed" class="form-check-label">Задача выполнена</label>
        <div>
        <div>
          <input type="hidden" name="task_id" value="<?= $task_id?>">
        </div>
        <div class="mt-5">
          <input class="btn btn-primary btn-lg" type="submit" name="submit" value="<?= $submit_text?>">
        </div>
      <div>
    </form>
  </div>
</div>