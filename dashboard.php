<?php 
include 'header.php';
$koneksi = mysqli_connect('localhost','root','','projectweb');

if ($_SESSION['bagian'] === "ADMIN"){
	?>
	<!-- user admin -->
	<div class="container-fluid pt-3" style="height: calc(100vh - 3rem - 1rem - 24px);">
		<div class="row gap-2 justify-content-center">
			<div class="row gap-2">
				<div id="dashboardMenu" class="col-sm bg-white rounded-3 p-4 shadow-1" onclick="window.location.href='barang.php';">
					<div class="row d-flex justify-content-between gap-2 align-items-center">
						<div class="col text-center text-sm-start">
							<div class="s1-infograph-title">Total</div>
							<?php 
								$y=mysqli_query($koneksi, "select sum(jumlah) as jmlhBrg from barang");	
								$yy=mysqli_fetch_array($y);
								echo "
								<div class='fs-3 fw-bold'>". number_format($yy['jmlhBrg'])."</div>
								";
							?>
							<div class="text-black-50">Barang</div>
						</div>
						<div class="col d-flex justify-content-center justify-content-sm-end">
							<i class="bi-shop-window fs-1"></i>
						</div>
					</div>
				</div>
				<div id="dashboardMenu" class="col-sm bg-white rounded-3 p-4 shadow-1" onclick="window.location.href='barang_laku.php';">
					<div class="row d-flex flex-row-reverse flex-sm-row justify-content-between gap-2 align-items-center">
						<div class="col d-flex flex-column text-center text-sm-start">
							<div class="s1-infograph-title">Terjual</div>
							<?php 
								$x=mysqli_query($koneksi, "select sum(jumlah) as jmlhLaku from barang_laku");	
								$xx=mysqli_fetch_array($x);
								echo "
								<div class='fs-3 fw-bold'>". number_format($xx['jmlhLaku'])."</div>
								";
							?>
							<div class="text-black-50">Barang</div>
						</div>
						<div class="col d-flex justify-content-center justify-content-sm-end">
							<i class="bi-bag-check fs-1"></i>
						</div>
					</div>
				</div>
			</div>
			<div class="row gap-2">
				<div class="col-12 col-sm col-lg bg-warning-subtle rounded-3 p-4 shadow-1-warning text-center text-sm-start">
					<div class="s1-infograph-title text-warning">Pemasukan</div>
					<?php 
						$x=mysqli_query($koneksi, "select sum(total_harga) as total from barang_laku");	
						$xx=mysqli_fetch_array($x);			
						echo '
						<div class="fs-3 fw-bold text-warning">Rp. '. number_format($xx["total"]).'</div>
						';
					?>
				</div>
				<div class="col-12 col-sm col-lg bg-danger-subtle rounded-3 p-4 shadow-1-danger text-center text-sm-start">
					<div class="s1-infograph-title text-danger">Pengeluaran</div>
					<?php 
						$x=mysqli_query($koneksi, "select sum(modal * jumlah) as totalKeluar from barang");	
						$xx=mysqli_fetch_array($x);
						echo "
						<div class='fs-3 fw-bold text-danger'>Rp. ". number_format($xx['totalKeluar'])."</div>
						";
					?>
				</div>
				<div class="col-12 col-sm-12 col-lg bg-success-subtle rounded-3 p-4 shadow-1-success text-center text-lg-start">
					<div class="s1-infograph-title text-success">Keuntungan</div>
					<?php 
						$x=mysqli_query($koneksi, "select sum(total_harga) as totalMasuk from barang_laku");	
						$xx=mysqli_fetch_array($x);

						$y=mysqli_query($koneksi, "select sum(modal * jumlah) as totalKeluar from barang");	
						$yy=mysqli_fetch_array($y);
						echo "
						<div class='fs-3 fw-bold text-success'>Rp. ". number_format(($xx['totalMasuk'])-($yy['totalKeluar']))."</div>
						";
					?>
				</div>
			</div>
			<div class="row gap-2">
				<div id="dashboardMenu" class="col bg-white rounded-3 p-4 shadow-1" onclick="window.location.href='tambah_user.php';">
					<div class="row d-flex justify-content-center gap-2 align-items-center">
						<div class="col d-flex flex-column align-items-center">
							<div class="s1-infograph-title">Karyawan</div>
							<?php 
								$x=mysqli_query($koneksi, "select count(bagian) as jmlKaryawan from admin where bagian = 'karyawan'");	
								$xx=mysqli_fetch_array($x);
								echo "
								<div class='fs-3 fw-bold'>". number_format($xx['jmlKaryawan'])."</div>
								";
							?>
							<div class="text-black-50">Orang</div>
						</div>
						<div class="col d-flex justify-content-center">
							<i class="bi-people fs-1"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
else {
	?>
	<!-- user karyawan -->
	<main class="" style="height: calc(100vh - 3rem - 1rem - 24px);">
		<div class="container d-flex flex-column gap-2 align-items-center justify-content-center text-center h-100">
			<div class="fs-2">Sambutan</div>
			<div class="display-2">Halo, selamat datang <br> di Woku.Id!</div>
			<div class="">Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe aut odio omnis, reiciendis dignissimos distinctio repudiandae numquam vero ullam maxime animi. Deleniti eaque eveniet sapiente illum laborum atque eum doloribus.</div>
		</div>
	</main>
	<?php
}
?>

<?php 
include 'footer.php';

?>