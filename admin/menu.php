 <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a class="brand-link text-center">
      <span class="brand-text font-weight-bold"><?php echo $_SESSION['comnam']; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
           <?php if(($_SESSION['CATGRY']=="3") || ($_SESSION['CATGRY']=="1") || ($_SESSION['CATGRY']=="0")) { ?>
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php if($page=="Dashboard") echo "active"; ?>">
              <i class="nav-icon fa fa-shopping-cart"></i>
              <p>
                Orders
              </p>
            </a>

          </li>
            <?php } ?>

          <?php if(($_SESSION['CATGRY']=="0") || ($_SESSION['CATGRY']=="1")) { ?>
          <li class="nav-item">
            <a href="link_steward.php" class="nav-link <?php if($page=="link steward") echo "active"; ?>">
              <i class="nav-icon fa fa-table"></i>
              <p>
                Link Steward
              </p>
            </a>
          </li>
          <?php } ?>

          <?php if(($_SESSION['CATGRY']=="0") || ($_SESSION['CATGRY']=="1")) { ?>
          <li class="nav-item ">
            <a href="settings.php" class="nav-link <?php if($page=="settings") echo "active"; ?>">
              <i class="nav-icon fa fa-cog"></i>
              <p>
                Settings
              </p>
            </a>
          </li>
          <?php } ?>  

         <?php if(($_SESSION['CATGRY']=="3") || ($_SESSION['CATGRY']=="1") || ($_SESSION['CATGRY']=="0")) { ?>
          <li class="nav-item">
            <a href="change_password.php" class="nav-link <?php if($page=="Password") echo "active"; ?>">
              <i class="nav-icon fas fa-key"></i>
              <p>
                Change Password
              </p>
            </a>

          </li>
            <?php } ?>

         <?php if(($_SESSION['CATGRY']=="3") || ($_SESSION['CATGRY']=="1") || ($_SESSION['CATGRY']=="0")) { ?>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>

          </li>
            <?php } ?>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>