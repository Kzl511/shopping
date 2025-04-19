<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<?php
include 'header.php';
?>

<!--================Single Product Area =================-->
<div class="product_image_area">
    <div class="container">
        <?php
            $id = $_GET['id'];

            $stmt = $pdo->prepare("SELECT * FROM products WHERE id=$id");
            $stmt->execute();
            $result = $stmt->fetch(PDO:: FETCH_ASSOC);

            $cat_id = $result['category_id'];

            $catStmt = $pdo->prepare("SELECT * FROM categories WHERE id=$cat_id");
            $catStmt->execute();
            $catResult = $catStmt->fetch(PDO:: FETCH_ASSOC);
        ?>
        <div class="row s_product_inner">
            <div class="col-lg-6">
                <img class="img-fluid" src="admin/images/<?php echo $result['image']; ?>" alt="">
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div class="s_product_text">
                    <h3><?php echo $result['name']; ?></h3>
                    <h2>$<?php echo $result['price']; ?></h2>
                    <ul class="list">
                        <li><a class="active" href="#"><span>Category</span> : <?php echo $catResult['name']; ?></a></li>
                        <li><a href="#"><span>Availibility</span><?php if ($result['quantity'] > 0) { ?>
                            : In Stock</a></li>
                        <?php } else { ?>
                            : Out of Stock</a></li>
                        <?php } ?> 
                    </ul>
                    <p><?php echo $result['description']; ?></p>
                    <div class="product_count">
                        <label for="qty">Quantity:</label>
                        <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                            class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                            class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                    </div>
                    <div class="card_area d-flex align-items-center">
                        <a class="primary-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<?php
include 'footer.php';
?>