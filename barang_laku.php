<?php 
include 'header.php';
$koneksi = mysqli_connect('localhost','root','','projectweb');
// hide error
error_reporting(0);
ini_set('display_errors', 0);
?>

<div class="data-barang">
	<main>
		<section>
			<div class="text-center py-4">
				<nav class="d-flex justify-content-center" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
					<ol class="breadcrumb">
						<!-- <li class="breadcrumb-item"><a href="#">Data Barang</a></li> -->
						<li class="breadcrumb-item active" aria-current="page">Entry Semua Penjualan</li>
					</ol>
				</nav>
				<h3>Transaksi Penjualan</h3>
				<div>Data penjualan barang yang telah dimasukkan pada setiap transaksi akan ditampilkan disini.</div>
			</div>
		</section>
		<hr>
		<section class="my-3">
			<div class="d-flex gap-2 gap-md-4 justify-content-center align-items-center">
				<div class="">
					<button id="btnMobile" data-bs-toggle="modal" data-bs-target="#myModal" class="d-inline-flex d-md-none buttonku-1-primary align-items-center"><i class="bi-plus"></i></button>
					<button id="btnDesktop" data-bs-toggle="modal" data-bs-target="#myModal" class="d-none d-md-inline-flex buttonku-1-primary align-items-center gap-2"><i class="bi-plus"></i> Tambah Transaksi Penjualan</button>
				</div>
				<div class="d-flex flex-column align-items-center justify-content-center gap-1 border border-1 p-2 rounded-1">
					<div>Cari Transaksi penjualan berdasarkan tanggal</div>
					<div class="d-flex align-items-center justify-content-center gap-1">
						<form action="" method="get">
							<input type="date" id="dateStart" name="dateStart" class="form-control" onchange="this.form.submit(), localStorage.setItem('dateStart', document.getElementById('dateStart').value)">
							<?php
							if (isset($_GET['dateStart'])){
								if($_SESSION['dateEnd']){
									$_SESSION['thisDate'] = $_GET['dateStart'].' - '.$_SESSION['dateEnd'];
								}
								else{
									$_SESSION['thisDate'] = $_GET['dateStart'];
								}
								$_SESSION['dateStart'] = $_GET['dateStart'];
							}
							?>
						</form>
						<i class="bi bi-dash-lg"></i>
						<form action="" method="get">
							<input type="date" id="dateEnd" name="dateEnd" class="form-control" onchange="this.form.submit(),localStorage.setItem('dateEnd', document.getElementById('dateEnd').value)">
							<?php
								if (isset($_GET['dateEnd'])){
									if($_SESSION['dateStart']){
										$_SESSION['thisDate'] = $_SESSION['dateStart'].' sampai '.$_GET['dateEnd'];
									}
									else{
										$_SESSION['thisDate'] = $_GET['dateEnd'];
									}
									$_SESSION["dateEnd"] = $_GET['dateEnd'];
								}
							?>
						</form>
					</div>
				</div>

				<div>
					<button id="btnMobile" class="d-inline-flex d-md-none buttonku-1 gap-2" onclick="window.open('cetak_barang_laku.php','_blank')"><i class="bi-printer"></i></button>
					<button id="btnDesktop" class="d-none d-md-inline-flex buttonku-1 gap-2" onclick="window.open('cetak_barang_laku.php','_blank')"><i class="bi-printer"></i> Cetak</button>
				</div>
			</div>
		</section>
		<?php
		if(isset($_POST['resetTanggal'])){
			$_SESSION['dateStart'] = null;
			$_SESSION['dateEnd'] = null;
			$_SESSION['thisDate'] = null;
			$dateStart = null;
			$dateEnd = null;
			$tg = null;
		}
		?>
		<section>
			<div class="s3" style="overflow: auto;">
				<?php
					if($_SESSION['dateStart'] || $_SESSION['dateEnd']){
						echo '
						<div class="alert alert-info d-flex align-items-center justify-content-center gap-3 p-2 mb-2">
							<div> Data Penjualan Tanggal  <a style="color:blue"> '. $_SESSION['thisDate'].'</a></div>
							<form action="" method="post">
								<button name="resetTanggal" type="submit" class="buttonku-1" onclick="resetCacheDate()">Reset Filter</button>
							</form>
						</div>
						';
					}
					$per_hal = 10;
					$jumlah_record = mysqli_query($koneksi, "SELECT COUNT(*) as jum from barang_laku");
					$jum = mysqli_fetch_assoc($jumlah_record);
					$_SESSION['jum'] = $jum['jum'];
					$halaman = ceil($jum['jum'] / $per_hal);
					$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
					$start = ($page - 1) * $per_hal;
					// echo ' per hal = '.$per_hal;
					// echo ' jumlah record = '.$jum['jum'];
					// echo ' halaman = '.$halaman;
					// echo ' page = '.$page;
					// echo ' start = '.$start;
				?>

				<table class="table border border-1">
					<tr style="background: var(--bs-table-hover-bg);">
						<th>No</th>
						<th>ID Transaksi</th>
						<th>Tanggal</th>
						<th>Nama Barang</th>
						<th class="text-end">Harga Jual</th>
						<th class="text-center">Terjual (pcs)</th>						
						<th class="text-end">Total Harga</th>
						<th class="text-center">Opsi</th>
					</tr>
					<?php 
					// echo $_SESSION["dateStart"].' | '.$_SESSION["dateEnd"];
					if($_SESSION["dateStart"] && $_SESSION["dateEnd"]){
						// echo 'pilih semua';
						$dateStart = $_SESSION["dateStart"];
						$dateEnd = $_SESSION["dateEnd"];
						// $tanggal=mysqli_real_escape_string($koneksi, $_SESSION['thisDate']);
						$brg=mysqli_query($koneksi, "SELECT * from barang_laku where tanggal between '$dateStart' and '$dateEnd' order by id desc limit $start, $per_hal");

						$jumlah_record = mysqli_query($koneksi, "SELECT COUNT(*) as jum from barang_laku where tanggal between '$dateStart' and '$dateEnd'");
						$jum = mysqli_fetch_assoc($jumlah_record);
						$_SESSION['jum'] = $jum['jum'];
						$halaman = ceil($jum['jum'] / $per_hal);
					} 
					else if($_SESSION["dateStart"] || $_SESSION["dateEnd"]){
						if($_SESSION["dateStart"]){
							// echo 'pilih start';
							$tanggal=mysqli_real_escape_string($koneksi, $_SESSION["dateStart"]);
						}
						else if($_SESSION["dateEnd"]){
							// echo 'pilih end';
							$tanggal=mysqli_real_escape_string($koneksi, $_SESSION["dateEnd"]);
						}
						else{
							$tanggal=mysqli_real_escape_string($koneksi, $_SESSION['thisDate']);
						}
						$brg=mysqli_query($koneksi, "SELECT * from barang_laku where tanggal like '$tanggal' order by id desc limit $start, $per_hal");
						
						$jumlah_record = mysqli_query($koneksi, "SELECT COUNT(*) as jum from barang_laku where tanggal like '$tanggal'");
						$jum = mysqli_fetch_assoc($jumlah_record);
						$_SESSION['jum'] = $jum['jum'];
						$halaman = ceil($jum['jum'] / $per_hal);
					}
					else{
						$brg=mysqli_query($koneksi, "select * from barang_laku order by id desc limit $start, $per_hal");
					}
					if ($page == 1) {
						$no = $page;
					}
					else{
						$no = $start + 1;
					}
					// $no=1;
					while($b=mysqli_fetch_array($brg)){

					?>
					<tr>
						<td><?php echo $no++ ?></td>
						<td><?php echo $b['id'] ?></td>
						<td><?php echo $b['tanggal'] ?></td>
						<td><?php echo $b['nama'] ?></td>
						<td class="text-end">Rp.<?php echo number_format($b['harga']) ?>,-</td>
						<td class="text-center"><?php echo $b['jumlah'] ?></td>						
						<td class="text-end">Rp.<?php echo number_format($b['total_harga']) ?>,-</td>
						<td id="rowResponsive">
							<div class="d-flex gap-1 justify-content-center align-items-center">
								<a id="btnDesktop" href="edit_laku.php?id=<?php echo $b['id']; ?>" class="d-none d-lg-inline-flex buttonku-1">Edit</a>
								<a id="btnDesktop" onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='hapus_laku.php?id=<?php echo $b['id']; ?>&jumlah=<?php echo $b['jumlah'] ?>&nama=<?php echo $b['nama']; ?>' }" class="d-none d-lg-inline-flex buttonku-1-danger">Hapus</a>
								
								<button id="btnMobile" class="d-inline-flex d-lg-none buttonku-1" onclick="window.location.href='edit_laku.php?id=<?php echo $b['id']; ?>';"><i class="bi-pencil-square"></i></button>
								<button id="btnMobile" class="d-inline-flex d-lg-none buttonku-1-danger" onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='hapus_laku.php?id=<?php echo $b['id']; ?>&jumlah=<?php echo $b['jumlah'] ?>&nama=<?php echo $b['nama']; ?>' }"><i class="bi-trash"></i></button>
							</div>
						</td>
					</tr>

					<?php 
					}
					?>
					<tr>
						<td colspan="5" class="text-center">Total Pemasukan Dari <?php echo $jum['jum']; ?> Transaksi</td>
							<?php
							if($_SESSION['dateStart'] && $_SESSION['dateEnd']){
								$tanggalStart = $_SESSION['dateStart'];
								$tanggalEnd = $_SESSION['dateEnd'];

								$x=mysqli_query($koneksi, "select sum(jumlah) as jmlhLaku from barang_laku where tanggal between '$tanggalStart' and '$tanggalEnd'");	
								$xx=mysqli_fetch_array($x);
								
								$y=mysqli_query($koneksi, "select sum(total_harga) as total from barang_laku where tanggal between '$tanggalStart' and '$tanggalEnd'");	
								$yy=mysqli_fetch_array($y);	
								echo "
								<td class='text-center'><b>". number_format($xx['jmlhLaku'])."</b></td>
								<td class='text-end'><b> Rp.". number_format($yy['total']).",-</b></td>
								";
							} 
							else if($_SESSION['dateStart'] || $_SESSION['dateEnd']){
								if($_SESSION['dateStart']){
									$tanggal = $_SESSION['dateStart'];
								}
								else if($_SESSION['dateEnd']){
									$tanggal = $_SESSION['dateEnd'];
								}
								$x=mysqli_query($koneksi, "select sum(jumlah) as jmlhLaku from barang_laku where tanggal='$tanggal'");	
								$xx=mysqli_fetch_array($x);
								
								$y=mysqli_query($koneksi, "select sum(total_harga) as total from barang_laku where tanggal='$tanggal'");	
								$yy=mysqli_fetch_array($y);	
								echo "
								<td class='text-center'><b>". number_format($xx['jmlhLaku'])."</b></td>
								<td class='text-end'><b> Rp.". number_format($yy['total']).",-</b></td>
								";
							}
							else{
								$x=mysqli_query($koneksi, "select sum(jumlah) as jmlhLaku from barang_laku");	
								$xx=mysqli_fetch_array($x);

								$y=mysqli_query($koneksi, "select sum(total_harga) as total from barang_laku");	
								$yy=mysqli_fetch_array($y);			
								echo "
								<td class='text-center'><b>". number_format($xx['jmlhLaku'])."</b></td>
								<td class='text-end'><b> Rp.". number_format($yy['total']).",-</b></td>
								";
							}
							?>
						<td></td>
					</tr>
				</table>
				<form action="" method="get" class="d-flex gap-2 justify-content-center pb-2">
					<span>Halaman</span>
					<?php
					foreach( range(1,$halaman) as $item){
						if ($item == $page){
							echo 
							'<div>
								<input onclick="this.form.submit()" type="radio" name="page" value="'.$item.'" checked>
								<label for="'.$item.'">'.$item.'</label>
							</div>
							';
						}
						else{
							echo 
							'<div>
								<input onclick="this.form.submit()" type="radio" name="page" value="'.$item.'">
								<label for="'.$item.'">'.$item.'</label>
							</div>
							';
						}
					}
					?>
				</form>
			</div>
		</section>
	</main>
</div>




<!-- modal input -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Penjualan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
				<form name="formBarangLaku" action="barang_laku_act.php" method="post" class="d-flex flex-column gap-3 needs-validation" novalidate>
					<div class="form-group">
						<label>Tanggal</label>
						<input name="tgl" type="date" class="form-control" id="tgl" autocomplete="off" required>
						<div class="invalid-feedback">Tanggal belum diisi.</div>
					</div>	
					<div class="form-group">
						<label>Nama Barang</label>								
						<select class="form-control" name="nama" required>
							<option value="">Pilih Nama Barang ..</option>
							<?php 
							$brg=mysqli_query($koneksi, "select * from barang order by nama");
							while($b=mysqli_fetch_array($brg)){
								?>	
								<option value="<?php echo $b['nama']; ?>" onchange="document.getElementById('showModalHarga').value = 1000"><?php echo $b['nama'].' - '.$b['sisa'].'* (Rp. '.$b['harga'].')' ?>
								</option>
								<?php 
							}
							?>
						</select>
						<div class="invalid-feedback">Nama Barang belum dipilih.</div>
					</div>
					<div class="form-group">
						<label>Jumlah Barang Terjual</label>
						<input name="jumlahLaku" type="number" min="0" class="form-control" placeholder="Jumlah Barang Terjual .." autocomplete="off" required>
						<div class="invalid-feedback">Jumlah belum diisi.</div>
					</div>																	
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
						<label class="form-check-label" for="invalidCheck">Pastikan jumlah sisa stock barang lebih banyak dari jumlah barang yang terjual.</label>
						<div class="invalid-feedback">Kotak ini harus dicentang.</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="reset" class="buttonku-1" value="Reset">												
					<!-- <input type="submit" class="buttonku-1-primary" value="Tambah Transaksi Penjualan"> -->
					<button class="buttonku-1-primary" onclick="cekDataBarangLaku()">Tambah Transaksi Penjualan</button>
				</div>
			</form>
    </div>
  </div>
</div>
<script>
	let modalHarga = null

	if(typeof window.history.pushState == 'function') {
		window.history.pushState({}, "Hide", "http://localhost/Woku.Id/barang_laku.php");
	}

	function cekDataBarangLaku(){
		'use strict'
		// Fetch all the forms we want to apply custom Bootstrap validation styles to
		const forms = document.querySelectorAll('.needs-validation')
		// Loop over them and prevent submission
		Array.from(forms).forEach(form => {
			form.addEventListener('submit', event => {
				if (!form.checkValidity()) {
					event.preventDefault()
					event.stopPropagation()
				}
				form.classList.add('was-validated')
			}, false)
		})
	}
	$(document).ready(function(){
		let dateStart = localStorage.getItem('dateStart')
		let dateEnd = localStorage.getItem('dateEnd')
		if (dateStart && dateEnd){
			document.getElementById('dateStart').value = dateStart
			document.getElementById('dateEnd').value = dateEnd
		}
		else if(dateStart || dateEnd){
			if(dateStart){
				console.log('dateStart ->',dateStart);
				document.getElementById('dateStart').value = dateStart
			}
			else if(dateEnd){
				console.log('dateEnd ->',dateEnd);
				document.getElementById('dateEnd').value = dateEnd
			}
		}
	});
	function resetCacheDate() {
		localStorage.removeItem('dateStart')
		localStorage.removeItem('dateEnd')
		document.getElementById('dateStart').value = null
		document.getElementById('dateEnd').value = null
	}
</script>

	<?php include 'footer.php'; ?>