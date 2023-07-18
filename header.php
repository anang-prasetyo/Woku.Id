<!DOCTYPE html>
<html>
<head>
	<?php 
	session_start();
	$koneksi = mysqli_connect('localhost','root','','projectweb');
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
  if ($_SESSION['bagian'] === "ADMIN"){
    ?>
    <title>Woku.Id - Admin</title>
    <?php
  }
  else {
    ?>
    <title>Woku.Id - Karyawan</title>
    <?php
  }
  ?>
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/font/bootstrap-icons.css">
	<link rel="stylesheet" href="assets/base.css">
	<link rel="stylesheet" href="assets/style.css">
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
<?php
  if ($_SESSION['bagian'] === "ADMIN"){
    ?>
    <div class="container-fluid bg-white px-3 shadow-1 sticky-top m-0">
      <main class="row d-flex justify-content-between align-items-center flex-row-reverse flex-sm-row" style="height: 3rem;">
        <section id="menuIconNav" class="d-flex justify-content-center justify-content-md-start gap-3 col-1 col-md-2 ps-md-3 align-items-center">
          <i class="bi-list btn btn-light d-inline-flex d-sm-none" onclick="myFunction()" style="cursor: pointer;"></i>
          <i class="bi-list d-none d-sm-inline-flex"></i>
          <div class="d-none d-md-inline-flex">Menu</div>
        </section>
        <section class="col ps-3">
          <div>Woku.Id <span class="badge bg-secondary">Admin</span></div>
        </section>
        <section class="col-auto pe-sm-5 d-none d-sm-inline-flex">
          <div class="nav-user">Selamat Datang, <?php echo $_SESSION['uname']  ?></div>
          <button class="btn btn-light d-none"><i class="bi-list"></i></button>
        </section>
      </main>
    </div>
  
    <script>
      function myFunction() {
        const scrollY = document.documentElement.style.getPropertyValue('--scroll-y');
        const body = document.body;
        body.style.top = `-${scrollY}`;
        body.style.position = 'fixed';
        body.style.left = '0';
        body.style.right = '0';
        var x = document.getElementById("sideMenuAdmin");
        var y = document.getElementById("menuIconNav");
        x.style.position = 'fixed';
        // y.style.margin-inline-end = '1rem';
  
        if (x.style.display === "flex") {
          x.style.display = "none";
          const body = document.body;
          const scrollY = body.style.top;
          x.style.position = '';
          y.style.marginRight = '';
          body.style.position = '';
          body.style.top = '';
          body.style.left = '';
          body.style.right = '';
          window.scrollTo(0, parseInt(scrollY || '0') * -1);
        } else {
          x.style.display = "flex";
          y.style.marginRight = '14.5px';
        }
      }
    </script>
  
    <!-- modal input -->
    <div id="modalpesanAdmin" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Pesan Notification</h4>
          </div>
          <div class="modal-body">
            <?php 
            $periksa=mysqli_query($koneksi, "select * from barang where jumlah <=3");
            while($q=mysqli_fetch_array($periksa)){	
              if($q['jumlah']<=3){			
                echo "<div style='padding:5px' class='alert alert-warning'><span class='glyphicon glyphicon-info-sign'></span> Stok  <a style='color:red'>". $q['nama']."</a> yang tersisa sudah kurang dari 3 . silahkan pesan lagi !!</div>";	
              }
            }
            ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>						
          </div>
          
        </div>
      </div>
    </div>
  
    <div class="container-fluid">
      <div class="row">
        <div class="d-none d-sm-flex col-1 col-md-2 p-0 position-fixed">
          <div class="pt-3 w-100">
            <ul class="list-unstyled">
              <li class="" onclick="localStorage.setItem('menuTab', 'Dashboard')">
                <a id="menuTab1" href="dashboard.php" class="d-flex justify-content-center justify-content-md-start gap-3 py-2 px-md-3 w-100 text-decoration-none align-items-center btn btn-light rounded-start-0">
                  <i class="bi bi-grid"></i>
                  <div class="d-none d-md-inline-flex">Dashboard</div>
                </a>
              </li>
              <li class="" onclick="localStorage.setItem('menuTab', 'Data Barang')">
                <a id="menuTab2" href="barang.php" class="d-flex justify-content-center justify-content-md-start gap-3 py-2 px-md-3 w-100 text-decoration-none align-items-center btn btn-light rounded-start-0">
                  <i class="bi bi-archive"></i>
                  <div class="d-none d-md-inline-flex">Data Barang</div>
                </a>
              </li>
              <li class="" onclick="localStorage.setItem('menuTab', 'Entry Penjualan')">
                <a id="menuTab3" href="barang_laku.php" class="d-flex justify-content-center justify-content-md-start gap-3 py-2 px-md-3 w-100 text-decoration-none align-items-center btn btn-light rounded-start-0">
                  <i class="bi bi-clipboard2-data"></i>
                  <div class="d-none d-md-inline-flex">Entry Penjualan</div>
                </a>
              </li>
              <li class="" onclick="localStorage.setItem('menuTab', 'Tambah User')">
                <a id="menuTab4" href="tambah_user.php" class="d-flex justify-content-center justify-content-md-start gap-3 py-2 px-md-3 w-100 text-decoration-none align-items-center btn btn-light rounded-start-0">
                  <i class="bi bi-person-add position-relative">
                    <span class="position-absolute top-0 end-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                      <span class="visually-hidden">New alerts</span>
                    </span>
                  </i>
                  <div class="d-none d-md-inline-flex">Tambah User</div>
                </a>
              </li>
              <li class="" onclick="if(localStorage.removeItem('menuTab'), confirm('Apakah anda yakin ingin logout ??')){ location.href='logout.php' }">
                <a id="menuTab5" class="d-flex justify-content-center justify-content-md-start gap-3 py-2 px-md-3 w-100 text-decoration-none align-items-center btn btn-light rounded-start-0">
                  <i class="bi bi-box-arrow-right"></i>
                  <div class="d-none d-md-inline-flex">Logout</div>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="d-none d-sm-flex col-1 col-md-2 p-0">
        </div>
    
      <!-- <div class="new-nav">
      </div> -->
      <div id="sideMenuAdmin" class="bg-white" style="display: none; z-index: 9;">
        <ul class="list-unstyled w-100 h-100 d-flex flex-column justify-content-center align-items-center m-0">
          <li class="d-flex py-3 gap-3 w-100 d-flex justify-content-center" style="cursor: pointer;" onclick="window.location.href='dashboard.php';">
            <i class="bi bi-grid"></i>
            <div class="">Dashboard</div>
          </li>
          <li class="d-flex py-3 gap-3 w-100 d-flex justify-content-center" style="cursor: pointer;" onclick="window.location.href='barang.php';">
            <i class="bi bi-archive"></i>
            <div class="">Data Barang</div>
          </li>
          <li class="d-flex py-3 gap-3 w-100 d-flex justify-content-center" style="cursor: pointer;" onclick="window.location.href='barang_laku.php';">
            <i class="bi bi-clipboard2-data"></i>
            <div class="">Entry Penjualan</div>
          </li>
          <li class="d-flex py-3 gap-3 w-100 d-flex justify-content-center" style="cursor: pointer;" onclick="window.location.href='tambah_user.php';">
            <i class="bi bi-person-add position-relative">
              <span class="position-absolute top-0 end-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                <span class="visually-hidden">New alerts</span>
              </span>
            </i>
            <div class="">Tambah User</div>
          </li>
          <li class="d-flex py-3 gap-3 w-100 d-flex justify-content-center" style="cursor: pointer;" onclick="if(confirm('Apakah anda yakin ingin logout ??')){ location.href='logout.php' }">
            <i class="bi bi-box-arrow-right"></i>
            <div class="">Logout</div>
          </li>
        </ul>
      </div>
      <script>
        $(document).ready(function(){
          let awalTab = localStorage.getItem('menuTab')
          if (!awalTab){
            localStorage.setItem('menuTab', 'Dashboard')
          }
          let thisMenuTab = localStorage.getItem('menuTab')
          function changeActiveTab(elMenuTab) {
            elMenuTab.classList.remove('btn-light');
            elMenuTab.classList.add('btn-dark');
            // elMenuTab.classList.toggle('btn-dark');
          }
          if (thisMenuTab === 'Dashboard'){
            let elMenuTab = document.getElementById('menuTab1')
            changeActiveTab(elMenuTab)
          }
          else if (thisMenuTab === 'Data Barang'){
            let elMenuTab = document.getElementById('menuTab2')
            changeActiveTab(elMenuTab)
          }
          else if (thisMenuTab === 'Entry Penjualan'){
            let elMenuTab = document.getElementById('menuTab3')
            changeActiveTab(elMenuTab)
          }
          else if (thisMenuTab === 'Tambah User'){
            let elMenuTab = document.getElementById('menuTab4')
            changeActiveTab(elMenuTab)
          }
          else if (thisMenuTab === 'Logout'){
            localStorage.removeItem('menuTab')
          }
        });
      </script>
    
        <div id="mainContent" class="col col-sm-11 col-md-10 ">
    <?php
  }
  else {
    ?>
    <div class="container-fluid bg-white px-3 shadow-1 sticky-top m-0">
      <main class="row d-flex justify-content-between align-items-center gap-1" style="height: 3rem;">
        <section class="col-auto ps-sm-3 pe-md-5">
          <div>Woku.Id</div>
        </section>
        <section class="col-auto">
          <ul class="d-flex align-items-center justify-content-center m-auto p-0">
            <li id="navKaryawanMenu" class="d-none d-sm-flex gap-1 align-items-center py-2 px-4" onclick="window.location.href='dashboard.php'">
              <i class="bi bi-house"></i>
              <div class="d-none d-lg-inline-flex">Welcome</div>
            </li>
            <li id="navKaryawanMenu" class="d-none d-sm-flex gap-1 align-items-center py-2 px-4" onclick="window.location.href='barang.php'">
              <i class="bi bi-archive"></i>
              <div class="d-none d-lg-inline-flex">Data Barang</div>
            </li>
            <li id="navKaryawanMenu" class="d-none d-sm-flex gap-1 align-items-center py-2 px-4" onclick="window.location.href='barang_laku.php';">
              <i class="bi bi-clipboard2-data"></i>
              <div class="d-none d-lg-inline-flex">Entry Penjualan</div>
            </li>
            <li id="navKaryawanMenu" class="d-flex d-sm-none gap-1 align-items-center p-2" onclick="myFunction()">
              <i class="bi bi-list"></i>
            </li>
          </ul>
        </section>
        <section id="menuIconNav" class="col-auto pe-sm-3 pe-md-5">
          <ul class="nav d-flex gap-1 align-items-center justify-content-center">
            <li class="nav-item d-none d-md-inline-flex">
              <a class="nav-link text-black-50"><?php echo $_SESSION['uname']  ?></a>
            </li>
            <li class="nav-item d-inline-flex d-md-none">
              <i class="bi-person"></i>
            </li>
            <li class="text-black-50">|</li>
            <li class="nav-item" style="cursor: pointer;" onclick="if(confirm('Apakah anda yakin ingin logout ??')){ location.href='logout.php' }">
              <a class="nav-link text-danger">Logout</a>
            </li>
          </ul>
        </section>
      </main>
    </div>

    <script>
      function myFunction() {
        const scrollY = document.documentElement.style.getPropertyValue('--scroll-y');
        const body = document.body;
        body.style.top = `-${scrollY}`;
        body.style.position = 'fixed';
        body.style.left = '0';
        body.style.right = '0';
        var x = document.getElementById("myDIVKaryawan");
        // var y = document.getElementById("menuIconNav");
        x.style.position = 'fixed';

        if (x.style.display === "flex") {
          x.style.display = "none";
          const body = document.body;
          const scrollY = body.style.top;
          x.style.position = '';
          // y.style.marginRight = '';
          body.style.position = '';
          body.style.top = '';
          body.style.left = '';
          body.style.right = '';
          window.scrollTo(0, parseInt(scrollY || '0') * -1);
        } else {
          x.style.display = "flex";
          // y.style.marginRight = '14.5px';
        }
      }
    </script>

    <!-- modal input -->
    <div id="modalpesanKaryawan" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Pesan Notification</h4>
          </div>
          <div class="modal-body">
            <?php 
            $periksa=mysqli_query($koneksi, "select * from barang where jumlah <=3");
            while($q=mysqli_fetch_array($periksa)){	
              if($q['jumlah']<=3){			
                echo "<div style='padding:5px' class='alert alert-warning'><span class='glyphicon glyphicon-info-sign'></span> Stok  <a style='color:red'>". $q['nama']."</a> yang tersisa sudah kurang dari 3 . silahkan pesan lagi !!</div>";	
              }
            }
            ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>						
          </div>
          
        </div>
      </div>
    </div>

    <div id="myDIVKaryawan" class="bg-white" style="display: none; z-index: 9;">
      <ul class="list-unstyled w-100 h-100 d-flex flex-column justify-content-center align-items-center m-0">
        <li class="d-flex py-3 gap-3 w-100 d-flex justify-content-center" style="cursor: pointer;" onclick="window.location.href='dashboard.php';">
          <i class="bi bi-house"></i>
          <div class="">Welcome</div>
        </li>
        <li class="d-flex py-3 gap-3 w-100 d-flex justify-content-center" style="cursor: pointer;" onclick="window.location.href='barang.php';">
          <i class="bi bi-archive"></i>
          <div class="">Data Barang</div>
        </li>
        <li class="d-flex py-3 gap-3 w-100 d-flex justify-content-center" style="cursor: pointer;" onclick="window.location.href='barang_laku.php';">
          <i class="bi bi-clipboard2-data"></i>
          <div class="">Entry Penjualan</div>
        </li>
      </ul>
    </div>
    <div class="container-lg px-5">
    <?php
  }
  ?>
