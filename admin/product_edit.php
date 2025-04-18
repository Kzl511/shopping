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
    if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['category']) || empty($_POST['quantity']) || empty($_POST['price']) || empty($_FILES['image'])) {
        if (empty($_POST['name'])) {
            $nameError = 'Product name is required.';
        }
        if (empty($_POST['description'])) {
            $descError = 'Product description is required.';
        }
        if (empty($_POST['category'])) {
            $catError = 'Product category is required.';
        }
        if (empty($_POST['quantity'])) {
            $qtyError = 'Product quantity is required.';
        } else if (is_numeric($_POST['quantity']) != 1) {
            $qtyError = 'Quantity should be numeric.';
        }
        if (empty($_POST['price'])) {
            $priceError = 'Product price is required.';
        } else if (is_numeric($_POST['price']) != 1) {
            $priceError = 'Price should be numeric.';
        }
        if (empty($_FILES['image'])) {
            $imgError = 'Product image is required.';
        }
    } else {
        if ($_FILES['image']['name'] != null) {
            $file = 'images/'.($_FILES['image']['name']);
            $imageType = pathinfo($file, PATHINFO_EXTENSION);
    
            if ($imageType != 'jpeg' && $imageType != 'jpg' && $imageType != 'png') {
                echo "<script>alert('Image should be in JPEG or JPG or PNG.');</script>";
            } else {
                $name = $_POST['name'];
                $description = $_POST['description'];
                $category = $_POST['category'];
                $quantity = $_POST['quantity'];
                $price = $_POST['price'];
                $image = $_FILES['image']['name'];
    
                move_uploaded_file($_FILES['image']['tmp_name'], $file);
                
                $stmt = $pdo->prepare("UPDATE products SET name=:name, description=:description, category_id=:category, quantity=:quantity, price=:price, image=:image WHERE id=".$_GET['id']);
                $result = $stmt->execute(
                    array(
                        ':name' => $name,
                        ':description' => $description,
                        ':category' => $category,
                        ':quantity' => $quantity,
                        ':price' => $price,
                        ':image' => $image
                    )
                );
    
                if ($result) {
                    echo "<script>alert('Product updated successfully.'); window.location.href='index.php';</script>";
                }
            }           
        } else {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $category = $_POST['category'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            
            $stmt = $pdo->prepare("UPDATE products SET name=:name, description=:description, category_id=:category, quantity=:quantity, price=:price WHERE id=".$_GET['id']);
            $result = $stmt->execute(
                array(
                    ':name' => $name,
                    ':description' => $description,
                    ':category' => $category,
                    ':quantity' => $quantity,
                    ':price' => $price
                )
            );

            if ($result) {
                echo "<script>alert('Product updated successfully.'); window.location.href='index.php';</script>";
            }
        }
    }
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id =" . $_GET['id']);
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
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>"> 
                            <input type="hidden" name="id" value="<?php echo $value[0]['id']; ?>"> 
                            <div class="form-group">
                                <label for="">Name</label><p style="color: red"><?php echo empty($nameError) ? '' : '*' . $nameError ?></p>
                                <input type="text" name="name" class="form-control" value="<?php echo escape($result[0]['name']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Description</label><p style="color: red"><?php echo empty($descError) ? '' : '*' . $descError ?></p>
                                <textarea class="form-control" name="description" id="" rows="8" cols="30"><?php echo escape($result[0]['description']) ?></textarea>
                            </div> 
                            <div class="form-group">
                                <?php 
                                    $catStmt = $pdo->prepare("SELECT * FROM categories");
                                    $catStmt->execute();
                                    $catResult = $catStmt->fetchAll(); 
                                ?>
                                <label for="">Category</label><p style="color: red"><?php echo empty($catError) ? '' : '*' . $catError ?></p>
                                <select name="category" id="" class="form-control">
                                    <option value="">Select Category</option>
                                    <?php 
                                        foreach ($catResult as $value) {
                                    ?>
                                    <?php if ($value['id'] === $result[0]['category_id']) : ?>
                                        <option value="<?php echo $value['id']; ?>" selected ><?php echo $value['name']; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                    <?php endif ?>
                                    <?php
                                        } 
                                    ?>
                                </select>
                            </div> 
                            <div class="form-group">
                                <label for="">Quantity</label><p style="color: red"><?php echo empty($qtyError) ? '' : '*' . $qtyError ?></p>
                                <input type="number" name="quantity" class="form-control" value="<?php echo escape($result[0]['quantity']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Price</label><p style="color: red"><?php echo empty($priceError) ? '' : '*' . $priceError ?></p>
                                <input type="number" name="price" class="form-control" value="<?php echo escape($result[0]['price']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Image</label><p style="color: red"><?php echo empty($imgError) ? '' : '*' . $imgError ?></p>
                                <img src="images/<?php echo escape($result[0]['image']) ?>" alt="" width="150" height="150"><br><br>
                                <input type="file" name="image" value="<?php echo escape($result[0]['image']) ?>">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Submit">
                                <a href="index.php" class="btn btn-warning">Back</a>
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