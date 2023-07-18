<?php 
include 'header.php';
$koneksi = mysqli_connect('localhost','root','','projectweb');
?>

<main class="row" style="height: calc(100vh - 3rem - 1rem - 24px);">
	<section class="col-12 m-auto col-sm-11 col-md-10 col-lg-4 m-lg-0">
		<div class="py-4">
			<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="barang_laku.php">Transaksi Penjualan</a></li>
					<li class="breadcrumb-item active" aria-current="page">Edit Transaksi Penjualan</li>
				</ol>
			</nav>
			<h3>Edit Transaksi Penjualan</h3>
			<div>Lakukan edit transaksi penjualan barang jika ada data yang salah.</div>
			<hr>
			<div class="d-flex">
				<button class="buttonku-1" onclick="window.location.href='barang_laku.php';"><i class="bi-arrow-left me-2"></i> Kembali</button>
			</div>
		</div>
	</section>
	<section class="col-12 m-auto col-sm-11 col-md-10 col-lg m-lg-0">
		<div class="border border-1 rounded-1 my-3">
			<?php
			$id_brg=mysqli_real_escape_string($koneksi, $_GET['id']);

			$det=mysqli_query($koneksi, "select * from barang_laku where id='$id_brg'")or die(mysql_error($koneksi));
			while($d=mysqli_fetch_array($det)){
				?>					
				<form action="update_laku.php" method="post">
					<table class="table mb-0">
						<tr>
							<td style="display: none;"><input type="hidden" name="id" value="<?php echo $d['id'] ?>"></td>
							<td style="display: none;"><input type="hidden" name="harga" value="<?php echo $d['harga'] ?>"></td>
							<td>Tanggal Terjual</td>
							<td><input name="tgl" type="date" class="form-control" id="tgl" autocomplete="off" value="<?php echo $d['tanggal'] ?>"></td>
						</tr>
						<tr>
							<td>Nama Barang</td>
							<td>
								<select class="form-control" name="nama">
									<?php 
									$brg=mysqli_query($koneksi, "select * from barang");
									while($b=mysqli_fetch_array($brg)){
										?>	
										<option <?php if($d['nama']==$b['nama']){echo "selected"; } ?> value="<?php echo $b['nama']; ?>"><?php echo $b['nama'].' - '.$b['sisa'].'('.$b['harga'].')' ?></option>
										<?php 
									}
									?>
								</select>
							</td>
						</tr>		
						<tr>
							<td>Jumlah Terjual</td>
							<td><input type="number" min="0" class="form-control" name="jumlah" value="<?php echo $d['jumlah'] ?>"></td>
						</tr>
						<tr>
						<tr>
							<td></td>
							<td>
								<div style="display: flex; gap: 1rem;">
									<input type="reset" value="Reset" class="buttonku-1">
									<input type="submit" class="buttonku-1-primary" value="Simpan Perubahan">
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


<!-- <script type="text/javascript">
        $(document).ready(function(){

            $('#tgl').datepicker({dateFormat: 'yy/mm/dd'});

        });
    </script> -->
<?php 
include 'footer.php';

?>