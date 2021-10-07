<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
      <div class="col-lg-7 text-center text-lg-start">
        <h1 class="display-4 fw-bold lh-1 mb-3">Вход на сайт</h1>
        <p class="col-lg-10 fs-4">Привет! Заходи в гости.</p>
      </div>
      <div class="col-md-10 mx-auto col-lg-5">
        <form class="p-4 p-md-5 border rounded-3 bg-light" method="GET" action="/signin">
          <p><?= $error_message?></p>
          <div class="form-floating mb-3">
            <input type="text" name="user_login" class="form-control" id="floatingInput" placeholder="admin" value="<?= $user_login?>">
            <label for="floatingInput">Логин</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" name="user_pass" class="form-control" id="floatingPassword" placeholder="Пароль" value="<?= $user_pass?>">
            <label for="floatingPassword">Пароль</label>
          </div>
          <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit" value="<?= $submit_text?>">Войти</button>
          <hr class="my-4">
          <small class="text-muted">Вы соглашаетесь с условиями использования сайта</small>
        </form>
      </div>
    </div>
  </div>