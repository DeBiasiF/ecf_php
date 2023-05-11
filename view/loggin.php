<?php
//Importe le header et la navbar
require_once "./view/partial/header.php";
require_once "./view/partial/navbar.php";
?>
<div class="container">
  <div class="row justify-content-center mt-5">
      <div class="col-md-6">
          <div class="card">
              <div class="card-header">
                  <h3 class="text-center">Login</h3>
              </div>
              <div class="card-body">
                <?php if(isset($errorMessage)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errorMessage; ?>
                    </div>
                <?php endif; ?>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="login">Username</label>
                        <input type="text" class="form-control" id="login" name="userName" placeholder="Enter username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="userPassword" placeholder="Enter password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" required>Login</button>
                    <a href='<?=$_SERVER['HTTP_REFERER']?>' class="btn btn-secondary">Retour</a>
                </form>
              </div>
          </div>
      </div>
  </div>
</div>
<?php
//Importe le footer
require_once "./view/partial/footer.php";
?>