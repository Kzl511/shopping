<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Shopping</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js" charset="utf-8"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js" charset="utf-8"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <?php
      $link = $_SERVER['PHP_SELF'];
      $link_array = explode('/', $link);
      $page = end($link_array);
      ?>
      <?php
      if ($page == 'index.php' || $page == 'category.php' || $page == 'user_list.php') { ?>
        <?php if ($page != 'order_list.php' && $page != 'order_detail.php') { ?>
          <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
              <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
              </a>
              <div class="navbar-search-block">
                <form class="form-inline" method="post"
                  <?php if ($page == 'index.php') : ?>
                  action="index.php"
                  <?php elseif ($page == 'category.php') : ?>
                  action="category.php"
                  <?php elseif ($page == 'user_list.php') : ?>
                  action="user_list.php"
                  <?php endif; ?>>
                  <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                  <div class="input-group input-group-sm">
                    <input name="search" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                      <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                      </button>
                      <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
              </a>
            </li>
          </ul>
        <?php } ?>
      <?php } ?>
      <!-- Right navbar links -->
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Shopping Panel</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo $_SESSION['username'] ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="index.php" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                      Product
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="category.php" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Category
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="user_list.php" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                      User
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="order_list.php" class="nav-link">
                    <i class="nav-icon fas fa-table"></i>
                    <p>
                      Orders
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                      Reports
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="weekly_report.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Weekly Reports</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="monthly_report.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Monthly Reports</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="royal_cus.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Royal Customers</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="best_selling.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Best Selling Items</p>
                      </a>
                    </li>
                  </ul>
                </li> 
              </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
      </div>
      <!-- /.content-header -->