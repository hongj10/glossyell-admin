<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #445574;">
    <!-- Brand Logo -->
    <a href="/" class="brand-link" style="background-color: #445574;">
        <span class="brand-text font-weight-light">(주) 글로시엘 어드민</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="background-color: aliceblue;">
        <!-- Sidebar user panel (optional) -->
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
<?php
foreach ($snb as $k => $v) {
    if ($_SERVER['SCRIPT_NAME'] == $v['1']) {
        $active = ' active';
    } else {
        $active = '';
    }
?>
    <li class="nav-item">
        <a href="<?php echo $v['1']?>" class="nav-link<?php echo $active?>">
            <i style="color: #2a3939b0;" class="nav-icon fas <?php echo $v['2']?>"></i>
            <p style="color: #2a3939b0;"><?php echo $v['0']?></p>
        </a>
    </li>
<?php
}
?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>