<?php 
include 'header.php';
$koneksi = mysqli_connect('localhost','root','','projectweb');
?>

<main class="row" style="height: calc(100vh - 3rem - 1rem - 24px);">
	<section class="col-12 m-auto col-sm-11 col-md-10 col-lg-4 m-lg-0">
		<div class="py-4">
			<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="tambah_user.php">Data User</a></li>
					<li class="breadcrumb-item active" aria-current="page">Edit User</li>
				</ol>
			</nav>
			<h3>Edit User</h3>
			<div>Lakukan edit data user jika ada data yang salah.</div>
			<hr>
			<div class="d-flex">
				<button class="buttonku-1" onclick="window.location.href='tambah_user.php';"><i class="bi-arrow-left me-2"></i> Kembali</button>
			</div>
		</div>
	</section>
	<section class="col-12 m-auto col-sm-11 col-md-10 col-lg m-lg-0">
		<div class="border border-1 rounded-1 my-3">
		<?php
		$id=mysqli_real_escape_string($koneksi, $_GET['id']);
		$det=mysqli_query($koneksi, "select * from admin where id='$id'")or die(mysql_error($koneksi));
		while($d=mysqli_fetch_array($det)){
		?>					
			<form action="update_user.php" method="post">
				<table class="table mb-0">
					<tr>
						<td class="text-black-50">Nama User</td>
						<td style="display: none;"><input type="hidden" name="id" value="<?php echo $d['id'] ?>"></td>
						<td><input type="text" class="form-control" name="uname" onkeyup="this.value = this.value.toUpperCase()" required value="<?php echo $d['uname'] ?>"></td>
					</tr>
					<tr>
						<td class="text-black-50">Password</td>
						<td><input type="text" class="form-control" name="pass" onkeyup="this.value = this.value.toUpperCase()" required value="<?php echo $d['pass'] ?>"></td>
					</tr>
					<tr>
						<td class="text-black-50">Bagian</td>
						<td>
							<select class="form-control" name="bagian" required>
								<option value="<?php echo $d['bagian'] ?>"><?php echo $d['bagian'] ?></option>
								<option value="ADMIN">ADMIN</option>
								<option value="KARYAWAN">KARYAWAN</option>
							</select>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<div style="display: flex; gap: 1rem;">
								<input type="reset" value="Batal" class="buttonku-1">
								<input type="submit" class="btn btn-primary" value="Simpan Perubahan">
							</div>
						</td>
					</tr>
				</table>
			</form>
			<?php 
		}
		?>
		</div>
	</section>
</main>
<?php include 'footer.php'; ?>