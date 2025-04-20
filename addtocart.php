<?php

session_start();

require 'config/config.php';
require 'config/common.php';

if ($_POST) {
    $id = $_POST['id'];
    $quantity = $_POST['qty'];

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id=$id");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($quantity > $result['quantity']) {
        echo "<script>alert('Not enough stock!'); window.location.href='product_detail.php?id=$id'</script>";
    } else {
        if (isset($_SESSION['cart']['id'.$id])) {
            $_SESSION['cart']['id'.$id] += $quantity;
        } else {
            $_SESSION['cart']['id'.$id] = $quantity;
        }
    
        header("Location: index.php");
    }
}

?>