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

if (!empty($_POST['search'])) {
  setcookie('search', $_POST['search'], time() + (86400 * 30), "/");
} else {
  if (empty($_GET['pageno'])) {
    unset($_COOKIE['search']);
    setcookie('search', '', -1, '/');
  }
} 
?>

<?php include('header.php'); ?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Best Selling Items</h3>
              </div>
              <?php
                $stmt = $pdo->prepare("SELECT product_id, SUM(quantity) AS total_sold FROM sale_order_detail GROUP BY product_id HAVING total_sold > 2;");
                $stmt->execute();
                $result = $stmt->fetchAll();
              ?>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered" id="d-table">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>User </th>
                      <th>Total Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                        $i = 1;
                        if ($result) {
                            foreach($result as $value) {
                        ?>
                        <?php
                        $prodStmt = $pdo->prepare("SELECT * FROM products WHERE id=".$value['product_id']);
                        $prodStmt->execute();
                        $prodResult = $prodStmt->fetchAll();
                        ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo escape($prodResult[0]['name']) ?></td>
                            <td><?php echo escape($value['total_sold']) ?></td>
                        </tr>
                        <?php
                        $i++;
                            }
                        }
                        ?>
                  </tbody>
                </table><br> 
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    
<?php include('footer.php'); ?>

<script>
     new DataTable('#d-table');
</script>