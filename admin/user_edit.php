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
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $address = $_POST['address'];
        $phone = $_POST['phone'];

        if (!empty($_POST['isAdmin'])) {
            $role = 1;
        } else {
            $role = 0;
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email AND id!=:id");
        $stmt->execute(
            array(
                ':id' => $id,
                ':email' => $email
            )
        );
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo "<script>alert('Email Duplicated!');</script>";
        } else {
            $stmt = $pdo->prepare("UPDATE users SET name=:name, email=:email, password=:password, address=:address, phone=:phone, role=:role WHERE id=:id");
            $result = $stmt->execute(
                array(
                    ':name' => $name,
                    ':email' => $email,
                    ':password' => $password,
                    ':address' => $address,
                    ':phone' => $phone,
                    ':role' => $role,
                    ':id' => $id
                )
            );

            if ($result) {
                echo "<script>alert('Successfully updated!');  window.location.href='user_list.php';</script>";
            }
        }
    }
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id =" . $_GET['id']);
$stmt->execute();
$result = $stmt->fetchAll();
?>

<?php include('header.php'); ?>

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post">
                            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                            <div class="form-group">
                                <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
                                <label for="">Name</label>
                                <p style="color: red"><?php echo empty($nameError) ? '' : '*' . $nameError ?></p>
                                <input type="text" name="name" class="form-control" value="<?php echo escape($result[0]['name']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <p style="color: red"><?php echo empty($emailError) ? '' : '*' . $emailError ?></p>
                                <input type="email" name="email" class="form-control" value="<?php echo escape($result[0]['email']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <p style="color: red"><?php echo empty($passwordError) ? '' : '*' . $passwordError ?></p>
                                <input type="password" name="password" class="form-control" value="<?php echo escape($result[0]['password']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Address</label>
                                <p style="color: red"><?php echo empty($addressError) ? '' : '*' . $addressError ?></p>
                                <input type="text" name="address" class="form-control" value="<?php echo escape($result[0]['address']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Phone number</label>
                                <p style="color: red"><?php echo empty($phoneError) ? '' : '*' . $phoneError ?></p>
                                <input type="tel" name="phone" class="form-control" value="<?php echo escape($result[0]['phone']); ?>">
                            </div>
                            <div class="input-group mb-3">
                                <input type="checkbox" id="isAdmin" name="isAdmin" value="1" style="margin-right: 5px;">
                                <label for="isAdmin" class="mb-0"> Create as Admin?</label>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Submit">
                                <a href="user_list.php" class="btn btn-warning">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<?php include('footer.php'); ?>