<?php
	session_start();
  $koneksi = mysqli_connect('localhost','root','','projectweb');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Woku.Id | Login</title>
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/login.css">
	<link rel="stylesheet" href="assets/font/bootstrap-icons.css">
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.js"></script>
</head>
<body>	
	<div class="container">
		<?php 
		if(isset($_GET['pesan'])){
			if($_GET['pesan'] == "gagal"){
				echo "<div style='margin-bottom:-55px' class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-warning-sign'></span>  Login Gagal !! Username dan Password Salah !!</div>";
			}
		}
		?>
		<div class="login">
			<main>
				<section>
					<div>
						<h1>Login</h1>
						<div class="desc">Silahkan lengkapi data berikut ini untuk login ke akun anda</div>
					</div>
				</section>
				<section>
					<form action="" method="post">
						<div class="input-group mb-3">
							<span class="input-group-text" id="basic-addon1">@</span>
							<input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="uname" id="" onkeyup="this.value = this.value.toUpperCase()" required>
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text" id="basic-addon1">
								<i class="bi bi-key"></i>
							</span>
							<!-- <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="uname" id="" onkeyup="this.value = this.value.toUpperCase()" required> -->
							<input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" name="pass" id="" required>
						</div>
						<!-- <div class="isian">
							<object type="image/svg+xml" data="assets/icons/key.svg"></object>
						</div> -->
						<div class="submit">
							<input type="submit" name="submit" value="Login">
						</div>
					</form>
          <?php 
          if(isset($_POST['submit'])){
            $uname = $_POST['uname'];
            $pass = $_POST['pass'];
            $query = mysqli_query($koneksi, "SELECT * from admin where uname='$uname' and pass='$pass'") or die(mysqli_error($koneksi));
            $cek = mysqli_num_rows($query);
  
            if($cek > 0){
              $data = mysqli_fetch_assoc($query);
              if($data['bagian'] == "ADMIN"){
                $_SESSION['uname'] = $uname;
                $_SESSION['bagian'] = "ADMIN";
              }
              else if($data['bagian'] == "KARYAWAN"){
                $_SESSION['uname'] = $uname;
                $_SESSION['bagian'] = "KARYAWAN";
              }
              header("location:dashboard.php");
            }
            else{
              header("location:index.php?pesan=gagal")or die(mysqli_error($koneksi));
            }
          }
          ?>

				</section>
			</main>
		</div>
	</div>
</body>
</html>