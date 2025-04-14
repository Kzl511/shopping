<?php

session_start();
require '../config/config.php';
require '../config/common.php';


if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
}

if ($_SESSION['role'] != 1) {
  header('Location: login.php');
}

if ($_POST) {
  if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || strlen($_POST['password']) < 4 || empty($_POST['address']) || empty($_POST['phone'])) {
    if (empty($_POST['name'])) {
      $nameError = 'Name cannot be empty.';
    }
    if (empty($_POST['email'])) {
      $emailError = 'Email cannot be empty.';
    }
    if (empty($_POST['password'])) {
      $passwordError = 'Password cannot be empty.';
    } else if (strlen($_POST['password']) < 4) {
      $passwordError = 'Password should be at least 4 characters.';
    }
    if (empty($_POST['address'])) {
      $addressError = 'Adress cannot be empty.';
    }
    if (empty($_POST['phone'])) {
      $phoneError = 'Phone number cannot be empty.';
    }
  } else {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    if (!empty($_POST['isAdmin'])) {
      $role = 1;
      $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
      $stmt->bindValue(':email', $email);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
        echo "<script>alert('Email Duplicated!');</script>";
      } else {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, address, phone, role) VALUES(:name, :email, :password, :address, :phone, :role)");
        $result = $stmt->execute(
          array(
            ':name' => $name,
            ':email' => $email,
            ':password' => $password,
            ':address' => $address,
            ':phone' => $phone,
            ':role' => $role
          )
        );

        if ($result) {
          echo "<script>alert('New Admin Account Created Successfully!');  window.location.href='user_list.php';</script>";
        }
      }
    } else {
      $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
      $stmt->bindValue(':email', $email);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
        echo "<script>alert('Email Duplicated!');</script>";
      } else {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, address, phone) VALUES(:name, :email, :password, :address, :phone)");
        $result = $stmt->execute(
          array(
            ':name' => $name,
            ':email' => $email,
            ':password' => $password,
            ':address' => $address,
            ':phone' => $phone
          )
        );

        if ($result) {
          echo "<script>alert('New User Account Created Successfully!');  window.location.href='user_list.php';</script>";
        }
      }
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blog | Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Blog</b>Admin</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Register New Account</p>

        <form action="" method="post">
          <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
          <div class="input-group mb-3">
            <input type="text" name="name" class="form-control" placeholder="Name">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <p style="color: red"><?php echo empty($nameError) ? '' : '*' . $nameError ?></p>
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <p style="color: red"><?php echo empty($emailError) ? '' : '*' . $emailError ?></p>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <p style="color: red"><?php echo empty($passwordError) ? '' : '*' . $passwordError ?></p>
          <div class="input-group mb-3">
            <input type="text" name="address" class="form-control" placeholder="Address">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-home"></span>
              </div>
            </div>
          </div>
          <p style="color: red"><?php echo empty($addressError) ? '' : '*' . $addressError ?></p>
          <div class="input-group mb-3">
            <input type="tel" name="phone" class="form-control" placeholder="Phone">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
          </div>
          <p style="color: red"><?php echo empty($phoneError) ? '' : '*' . $phoneError ?></p>
          <div class="input-group mb-3">
            <input type="checkbox" id="isAdmin" name="isAdmin" value="1" style="margin-right: 5px;">
            <label for="isAdmin" class="mb-0"> Create as Admin?</label>
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="container">
              <button type="submit" class="btn btn-primary btn-block">Create Account</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <!-- <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
</body>

</html>