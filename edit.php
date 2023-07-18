<?php 
include 'header.php';
$koneksi = mysqli_connect('localhost','root','','projectweb');
?>

<main class="row" style="height: calc(100vh - 3rem - 1rem - 24px);">
	<section class="col-12 m-auto col-sm-11 col-md-10 col-lg-4 m-lg-0">
		<div class="py-4">
			<nav class="d-flex" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="barang.php">Data Barang</a></li>
					<li class="breadcrumb-item active" aria-current="page">Edit Barang</li>
				</ol>
			</nav>
			<h3>Edit Barang</h3>
			<div>Lakukan edit data barang jika ada data yang salah.</div>
			<hr>
			<div class="d-flex">
				<button class="buttonku-1" onclick="window.location.href='barang.php';"><i class="bi-arrow-left me-2"></i> Kembali</button>
			</div>
		</div>
	</section>
	<section class="col-12 m-auto col-sm-11 col-md-10 col-lg m-lg-0">
		<div class="border border-1 rounded-1 my-3">
		<?php
		$id_brg=mysqli_real_escape_string($koneksi, $_GET['id']);
		$det=mysqli_query($koneksi, "select * from barang where id='$id_brg'")or die(mysql_error($koneksi));
		while($d=mysqli_fetch_array($det)){
		?>					
			<form action="update.php" method="post">
				<table class="table mb-0">
					<tr>
						<td class="text-black-50">Nama</td>
						<td style="display: none;"><input type="hidden" name="id" value="<?php echo $d['id'] ?>"></td>
						<td><input type="text" class="form-control" name="nama" onkeyup="this.value = this.value.toUpperCase()" required value="<?php echo $d['nama'] ?>"></td>
					</tr>
					<tr>
						<td class="text-black-50">Jenis</td>
						<td><input type="text" class="form-control" name="jenis" onkeyup="this.value = this.value.toUpperCase()" required value="<?php echo $d['jenis'] ?>"></td>
					</tr>
					<tr>
						<td class="text-black-50">Suplier</td>
						<td><input type="text" class="form-control" name="suplier" onkeyup="this.value = this.value.toUpperCase()" required value="<?php echo $d['suplier'] ?>"></td>
					</tr>
					<tr>
						<td class="text-black-50">Modal</td>
						<td><input type="number" min="1" class="form-control" name="modal" value="<?php echo $d['modal'] ?>"></td>
					</tr>
					<tr>
						<td class="text-black-50">Harga</td>
						<td><input type="number" min="1" class="form-control" name="harga" value="<?php echo $d['harga'] ?>"></td>
					</tr>
					<tr>
						<td class="text-black-50">Jumlah</td>
						<td><input type="number" min="1" class="form-control" name="jumlah" value="<?php echo $d['jumlah'] ?>"></td>
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