<!-- Brand Logo -->
<a href="<?= site_url() ?>dashboard" class="brand-link">
  <img src="<?= site_url() ?>assets/adminlte/img/newlogo.jpeg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
  <span class="brand-text font-weight-light">BantuWarga</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="<?= site_url() ?>assets/adminlte/img/ava.png" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
      <a href="#" class="d-block"><?= $this->session->userdata('user_name') ?></a>
    </div>
  </div>

  <!-- SidebarSearch Form -->
  <div class="form-inline">
    <div class="input-group" data-widget="sidebar-search">
      <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
      <div class="input-group-append">
        <button class="btn btn-sidebar">
          <i class="fas fa-search fa-fw"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
      <?php if ((int)$this->session->userdata('usertype') === 1) { ?>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
              Master Data
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= site_url() ?>master_data/warga" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Warga</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url() ?>master_data/bantuan" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Bantuan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./index3.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Pengumuman</p>
              </a>
            </li>
          </ul>
        </li>
      <?php } ?>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-edit"></i>
          <p>
            Transaksi
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <?php if ((int)$this->session->userdata('usertype') === 1) { ?>
              <a href="<?= site_url() ?>transaksi/kegiatan" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Jadwal Bantuan</p>
              </a>
            <?php } ?>
          </li>
          <li class="nav-item">
            <a href="<?= site_url() ?>master_data/bantuan" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p> Pengajuan Warga</p>
            </a>
          </li>
        </ul>
      </li>
      <?php if ((int)$this->session->userdata('usertype') === 1) { ?>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-flag"></i>
            <p>
              Laporan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= site_url() ?>master_data/warga" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Bantuan</p>
              </a>
            </li>
          </ul>
        </li>
      <?php } ?>
      <li class="nav-item">
        <a href="<?= site_url('login/logout') ?>" class="nav-link">
          <i class="nav-icon fas fa-power-off"></i>
          <p>
            Keluar
          </p>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>