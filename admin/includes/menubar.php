<!-- เช็คแล้ว  -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <!-- ถ้ารูปไม่มีให้ใช้รูปจาก../images/profile.jpg  -->
        <img src="<?php echo (!empty($admin['photo'])) ? '../images/'.$admin['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $admin['firstname'].' '.$admin['lastname']; ?></p>
        <a><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">REPORTS</li>
      <li><a href="home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      <li><a href="sales.php"><i class="fa fa-money"></i> <span>Sales</span></a></li>
      <li class="header">MANAGE</li>
      <li><a href="users.php"><i class="fa fa-users"></i> <span>Users</span></a></li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-barcode"></i>
          <span>Products</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="products.php"><i class="fa fa-circle-o"></i> Product List</a></li>
          <li><a href="chapter.php"><i class="fa fa-circle-o"></i> Chapter</a></li>
          <li><a href="category.php"><i class="fa fa-circle-o"></i> Category</a></li>
          <li><a href="tag.php"><i class="fa fa-circle-o"></i> Tag</a></li>
        </ul>
      </li>
      <li class="header">MANAGE PAGE</li>
      <li class="treeview">
      <a href="#">
          <i class="fa fa-barcode"></i>
          <span>PAGE</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="#"><i class="fa fa-circle-o"></i> TOP5 HOME</a></li>
          <li><a href="#"><i class="fa fa-circle-o"></i> Slidebar home</a></li>
          <li><a href="#"><i class="fa fa-circle-o"></i> Promotion show</a></li>
        </ul>



      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>