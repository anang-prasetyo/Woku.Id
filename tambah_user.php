<?php include 'header.php'; 
$koneksi = mysqli_connect('localhost','root','','projectweb');
?>

<div class="edit">
	<main>
	<section>
			<div class="text-center py-4">
				<nav class="d-flex justify-content-center" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
					<ol class="breadcrumb">
						<?php
						if(isset($_GET['cari'])){
							echo' 
							<li class="breadcrumb-item"><a href="tambah_user.php">Data Semua User</a></li>
							<li class="breadcrumb-item active" aria-current="page">Hasil Pencarian "'.$_GET["cari"].'"</li>
							';
						}else{
							echo' 
							<li class="breadcrumb-item active" aria-current="page">Data Semua User</li>
							';
						}
						?>
					</ol>
				</nav>
				<h3>Data User</h3>
				<div>Semua data user yang telah dimasukkan akan ditampilkan disini.</div>
			</div>
		</section>
		<hr>
		<section class="my-3">
			<div class="d-flex gap-2 gap-md-4 justify-content-center align-content-center">
				<button id="btnMobile" data-bs-toggle="modal" data-bs-target="#modalTambahUser" class="d-inline-flex d-md-none buttonku-1-primary"><i class="bi-plus"></i></button>
				<button id="btnDesktop" data-bs-toggle="modal" data-bs-target="#modalTambahUser" class="d-none d-md-inline-flex buttonku-1-primary gap-2"><i class="bi-plus"></i> Tambah User</button>
				<form action="" method="get" class="position-relative">
					<input type="text" class="form-control ps-5" placeholder="Cari user di sini .." autocomplete='off' aria-describedby="basic-addon1" name="cari">
					<i class="bi-search position-absolute top-50 translate-middle-y ms-3"></i>
				</form>
			</div>
		</section>
		<section>
			<div>
				<?php 
				$per_hal=20;
				$jumlah_record=mysqli_query($koneksi, "SELECT COUNT(*) from barang");
				$jum=mysqli_fetch_array($jumlah_record);
				$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
				$start = ($page - 1) * $per_hal;
				?>
				<table class="table border border-1">
					<tr style="background: var(--bs-table-hover-bg);">
						<th class="col-md-1">No</th>
						<th class="col-md-4">Nama User</th>
						<th class="col-md-3">Password User</th>
						<th class="col-md-1">Bagian</th>
						<th class="col-md-3 text-center">Opsi</th>
					</tr>
					<?php 
					if(isset($_GET['cari'])){
						$cari=mysqli_real_escape_string($koneksi, $_GET['cari']);
						$usr=mysqli_query($koneksi, "select * from admin where uname like '$cari%' or bagian like '$cari%' order by uname");
					}else{
						$usr=mysqli_query($koneksi, "select * from admin order by uname");
					}
					$no=1;
					while($u=mysqli_fetch_array($usr)){

						?>
						<tr>
							<td><?php echo $no++ ?></td>
							<td><?php echo $u['uname'] ?></td>
							<td><?php echo $u['pass'] ?></td>
							<td><?php echo $u['bagian'] ?></td>
							<td id="rowResponsive" class="text-center">
								<div class="d-flex justify-content-center align-items-center gap-1">
									<a id="btnDesktop" href="edit_user.php?id=<?php echo $u['id']; ?>" class="d-none d-lg-inline-flex buttonku-1">Edit</a>
									<a id="btnDesktop" onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='hapus_user.php?id=<?php echo $u['id']; ?>' }" class="d-none d-lg-inline-flex buttonku-1-danger">Hapus</a>
	
									<button id="btnMobile" class="d-inline-flex d-lg-none buttonku-1" onclick="window.location.href='edit_user.php?id=<?php echo $u['id']; ?>';"><i class="bi-pencil-square"></i></button>
									<button id="btnMobile" class="d-inline-flex d-lg-none buttonku-1-danger" onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='hapus_user.php?id=<?php echo $u['id']; ?>' }"><i class="bi-trash"></i></button>
								</div>
							</td>
						</tr>
						<?php 
					}
					?>
				</table>
			</div>
		</section>
	</main>
</div>

<!-- modal input --> 
<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
				<?php
				if(isset($_POST['reqToUpdateUser'])){
					?>
					<h1 class="modal-title fs-5" id="modalLabelTambahBarang">Edit Data User</h1>
					<?php
				}else{
					?>
					<h1 class="modal-title fs-5" id="modalLabelTambahBarang">Tambah User Baru</h1>
					<?php
				}
				?>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
			<?php
			if(isset($_POST['uname'])){
				$uname = $_POST['uname'];
				$pass = $_POST['pass'];
				$koneksi = mysqli_connect('localhost','root','','projectweb');
				$query = mysqli_query($koneksi, "select * from admin where uname like '$uname%' and pass like '$pass%'");
				$cek2 = mysqli_num_rows($query);
				if($cek2 > 0){
					?>
					<div id="actionWhenDangerDataUser" class="p-3" style="display: none; background: rgba(255,0,0,.1)">
						<div class="text-danger">Nama user sudah terdaftar, tampilkan dan ubah data user?</div>
						<div class="d-flex gap-1 justify-content-center py-2">
							<form action="tambah_user.php" method="post" class="d-flex flex-column gap-2">
								<input class="btn btn-primary" type="submit" name="reqToUpdateUser" value="Ya">
							</form>
							<button class="buttonku-1" onclick="toggleDangerDataUser()">Tidak, saya ingin menambah data baru</button>
						</div>
					</div>
					<?php
				}
			}
			?>
      <div class="modal-body">
			<?php
				if(isset($_POST['reqToUpdateUser'])){
					?>
					<script>
					$(document).ready(function(){
						$("#modalTambahUser").modal("show");
					});
					</script>
					<?php
					$id = $_SESSION["idUser"];
					$det=mysqli_query($koneksi, "select * from admin where id='$id'")or die(mysql_error($koneksi));
					while($d=mysqli_fetch_array($det)){
					?>					
						<form action="update_user.php" method="post" class="d-flex flex-column gap-3">
							<div class="form-group">
								<label for="uname" class="form-label">Nama User</label>
								<input type="hidden" name="id" value="<?php echo $d['id'] ?>">
								<input name="uname" id="uname" type="text" class="form-control" placeholder="Nama User .." onkeyup="this.value = this.value.toUpperCase()" value="<?php echo $d['uname'] ?>" required>
							</div>
							<div class="form-group">
								<label for="pass" class="form-label">Password</label>
								<input name="pass" id="pass" type="password" class="form-control" placeholder="Password .." value="<?php echo $d['pass'] ?>" required>
								<input type="checkbox" onclick="togglePassword()"> Lihat Password
							</div>
							<div class="form-group">
								<label for="bagian" class="form-label">Bagian</label>
								<select class="form-control" name="bagian" id="bagian" required>
									<option value="<?php echo $d['bagian'] ?>"><?php echo $d['bagian'] ?></option>
									<option value="ADMIN">ADMIN</option>
									<option value="KARYAWAN">KARYAWAN</option>
								</select>
							</div>
							<div class="modal-footer">
								<button class="buttonku-1"><a href="tambah_user.php">Kosongkan Form</a></button>
								<input type="reset" class="buttonku-1" value="Reset">
								<input type="submit" class="btn btn-primary" value="Simpan Perubahan">
							</div>
						</form>
					<?php 
					}
				}
				else {
					?>
					<form name="formUser" action="tambah_user.php" method="post" class="d-flex flex-column gap-3 needs-validation" novalidate>
						<div class="form-group">
							<label for="uname" class="form-label">Nama User</label>
							<input name="uname" id="uname" type="text" class="form-control" placeholder="Nama User" onkeyup="this.value = this.value.toUpperCase()" required>
							<div class="invalid-feedback">Nama User belum diisi.</div>
						</div>
						<div class="form-group">
							<label for="pass" class="form-label">Password</label>
							<input name="pass" id="pass" type="password" class="form-control" placeholder="Password" required>
							<input type="checkbox" onclick="togglePassword()"> Lihat Password
							<div class="invalid-feedback">Password belum diisi.</div>
						</div>
						<div class="form-group">
							<label for="bagian" class="form-label">Bagian</label>
							<select class="form-control" name="bagian" id="bagian" required>
								<option value="">Pilih Bagian ..</option>
								<option value="ADMIN">ADMIN</option>
								<option value="KARYAWAN">KARYAWAN</option>
							</select>
							<div class="invalid-feedback">Bagian belum diisi.</div>
						</div>
						<div class="">
							<?php
							if(isset($_POST['uname'])){
								$_SESSION["namaUser"] = $_POST['uname'];
								$uname = $_POST['uname'];
								$pass = $_POST['pass'];
								$koneksi = mysqli_connect('localhost','root','','projectweb');
								
								$query = mysqli_query($koneksi, "select * from admin where uname like '$uname%' and pass like '$pass%'");
								
								$data=mysqli_fetch_array($query);
								$_SESSION["idUser"] = $data['id'];
								$cek2 = mysqli_num_rows($query);
								if($cek2 > 0){
									// sudah ada data yang sama
									?>
									<script>
									const isDangerDataUser = null
									$(document).ready(function(){
										$("#modalTambahUser").modal("show");
										retriveDataUser()
										toggleDangerDataUser()
									});
									function toggleDangerDataUser(){
										var x = document.getElementById("actionWhenDangerDataUser");
										let _namaUser = localStorage.getItem("uname")
										if (x.style.display === "none" && _namaUser.length !== 0) {
											x.style.display = "block";
										} else {
											x.style.display = "none";
										}
									}
									function getPreviousDataUser(){
										resetLocalStorageUser();
										resetCacheUser();
										localStorage.setItem("reqToUpdateUser", true);
										toggleDangerDataUser();
										location.reload();
									}
									</script>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
										<label class="form-check-label" for="invalidCheck">Nama user dan password adalah nama dan password baru, belum pernah terdaftar sebelumnya.</label>
										<div class="invalid-feedback">Kotak ini harus dicentang.</div>
									</div>
									</div>
									<div class="modal-footer">
										<input type="reset" class="buttonku-1" value="Reset" onclick="toggleDangerDataUser()">
										<input type="submit" value="Tambah User Baru" name="cek_data" class="btn btn-primary" onclick="cekDataUser()">
									</div>
									<?php
								}
								else{
									$pass = $_POST['pass'];
									$bagian=$_POST['bagian'];
									mysqli_query($koneksi, "insert into admin values('','$uname','$pass','$bagian')");
									?>
									<script>
										$("#modalTambahUser").modal("hide");
										window.open("tambah_user.php", "_self")
										localStorage.removeItem("uname");
										localStorage.removeItem("pass");
										localStorage.removeItem("bagian");
									</script>
									<?php
								}
							}
							else{
								?>
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
									<label class="form-check-label" for="invalidCheck">Nama user dan password adalah nama dan password baru, belum pernah terdaftar sebelumnya.</label>
									<div class="invalid-feedback">Kotak ini harus dicentang.</div>
								</div>
								<div class="modal-footer">
									<input type="reset" class="buttonku-1" value="Reset">
									<button class="btn btn-primary" onclick="cekDataUser()">Tambah User Baru</button>
								</div
								<?php
							}
							?>
						</div>
					</form>
					<?php
				}
				?>
    </div>
  </div>
</div>

<script>
	let cacheUser = {
		uname: '',
		pass: '',
		bagian: '',
	};
	function cekDataUser() {
		let getInputUser = {
			uname: document.getElementById("uname").value,
			pass: document.getElementById("pass").value,
			bagian: document.getElementById("bagian").value
		}
		function addToLocalStorageUser(){
			localStorage.setItem("uname", getInputUser.uname);
			localStorage.setItem("pass", getInputUser.pass);
			localStorage.setItem("bagian", getInputUser.bagian);
			localStorage.setItem("dangerDataUser", false);
			return true;
		}
		function getFromLocalStorageUser(){
			cacheUser.uname = localStorage.getItem("uname");
			cacheUser.pass = localStorage.getItem("pass");
			cacheUser.bagian = localStorage.getItem("bagian");
			return true;
		}
		function retriveToElementUser(){
			document.getElementById("uname").value = cacheUser.uname;
			document.getElementById("pass").value = cacheUser.pass;
			document.getElementById("bagian").value = cacheUser.bagian;
			return true;
		}

		'use strict'
		// Fetch all the forms we want to apply custom Bootstrap validation styles to
		const formsUser = document.querySelectorAll('.needs-validation')
		// Loop over them and prevent submission
		Array.from(formsUser).forEach(form => {
			form.addEventListener('submit', event => {
				if (!form.checkValidity()) {
					event.preventDefault()
					event.stopPropagation()
				}
				form.classList.add('was-validated')
			}, false)
		})
		addToLocalStorageUser()
		getFromLocalStorageUser()
		retriveToElementUser()
		return true;
	}
	function retriveDataUser(){
		// document.formBarang.namaBarang.value = cacheBarang.namaBarang;
		document.getElementById("uname").value = localStorage.getItem("uname");
		document.getElementById("pass").value = localStorage.getItem("pass");
		document.getElementById("bagian").value = localStorage.getItem("bagian");
		return true;
	}
	function resetLocalStorageUser(){
		localStorage.removeItem("uname");
		localStorage.removeItem("pass");
		localStorage.removeItem("bagian");
		return true;
	}
	function resetCacheUser(){
		cacheUser.uname = '';
		cacheUser.pass = '';
		cacheUser.bagian = '';	
		return true;
	}
	if (cacheUser.uname.length !== 0 && cacheUser.pass.length !== 0 && cacheUser.bagian.length !== 0){
		document.getElementById("uname").value = cacheUser.uname;
		document.getElementById("pass").value = cacheUser.pass;
		document.getElementById("bagian").value = cacheUser.bagian;
	}
	function togglePassword() {
		var x = document.getElementById("pass");
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}
	}
</script>



<?php 
include 'footer.php';

?>