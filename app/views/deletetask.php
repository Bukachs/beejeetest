<div class="container d-flex justify-content-center">
  <div class="col-md-7 col-lg-8">
    <div class="py-5 text-center">
      <h4 class="mb-3 pb-2 border-bottom">Подтвердите удаление задачи</h4>
      <p><?= $error_message?></p>
    </div>
    <form method="GET" action="/delete">
      <div class="row g-3">
        <div class="col-sm-6">
          <label class="form-label">Название</label>
          <input type="text" class="form-control" name="task_name" value="<?= $task_name?>" readonly="readonly">
        </div>
        <div>
          <input type="hidden" name="task_id" value="<?= $task_id?>">
          <input type="hidden" name="confirm" value="1">
        </div>
        <div class="mt-5 input-group my-5">
          <input class="btn btn-primary btn-lg" type="submit" value="<?= $submit_text?>">
          <a class="btn btn-secondary btn-lg" href="<?= $_SERVER['HTTP_REFERER'] ?>"><?= $submit_decline_text?></a>
        </div>
      <div>
    </form>
  </div>
</div>