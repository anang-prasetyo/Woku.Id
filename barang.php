<?php include 'header.php'; 
$koneksi = mysqli_connect('localhost','root','','projectweb');
?>
<div class="data-barang">
	<main>
		<section>
			<div class="text-center py-4">
				<nav class="d-flex justify-content-center" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
					<ol class="breadcrumb">
						<?php
						if(isset($_GET['cari'])){
							echo' 
							<li class="breadcrumb-item"><a href="barang.php">Data Semua Barang</a></li>
							<li class="breadcrumb-item active" aria-current="page">Hasil Pencarian "'.$_GET["cari"].'"</li>
							';
						}else{
							echo' 
							<li class="breadcrumb-item active" aria-current="page">Data Semua Barang</li>
							';
						}
						?>
					</ol>
				</nav>
				<h3>Data Barang</h3>
				<div>Semua data barang yang telah dimasukkan akan ditampilkan disini.</div>
			</div>
		</section>
		<hr>
		<section class="my-3">
			<div class="d-flex gap-2 gap-md-4 justify-content-center align-content-center">
				<button id="btnMobile" data-bs-toggle="modal" data-bs-target="#modalTambahBarang" class="d-inline-flex d-md-none buttonku-1-primary"><i class="bi-plus"></i></button>
				<button id="btnDesktop" data-bs-toggle="modal" data-bs-target="#modalTambahBarang" class="d-none d-md-inline-flex buttonku-1-primary gap-2"><i class="bi-plus"></i> Tambah Barang</button>
				<form action="cari_act.php" method="get" class="position-relative">
					<input type="text" class="form-control ps-5" placeholder="Cari barang di sini .." autocomplete='off' aria-describedby="basic-addon1" name="cari">
					<i class="bi-search position-absolute top-50 translate-middle-y ms-3"></i>
				</form>
				<button id="btnMobile" class="d-inline-flex d-md-none buttonku-1" onclick="window.open('cetak_barang.php','_blank')"><i class="bi-printer"></i></button>
				<button id="btnDesktop" class="d-none d-md-inline-flex buttonku-1 gap-2" onclick="window.open('cetak_barang.php','_blank')"><i class="bi-printer"></i> Cetak</button>
			</div>
		</section>
		<section>
			<div class="s3" style="overflow: auto;">
				<?php 
				$periksa=mysqli_query($koneksi, "select * from barang where sisa <=3");
				while($q=mysqli_fetch_array($periksa)){	
					if($q['sisa']==0){
						?>	
						<script>
							$(document).ready(function(){
								$('#pesan_sedia').css("color","red");
								$('#pesan_sedia').append("<span class='glyphicon glyphicon-asterisk'></span>");
							});
						</script>
						<div class='alert alert-danger d-flex align-items-center justify-content-center gap-3 p-2 mb-2'>
							<div>Stok <a style='color:red'><?php echo $q['nama'] ?></a> telah HABIS. Silahkan pesan lagi !!</div>
							<a href="edit.php?id=<?php echo $q['id']; ?>" class="buttonku-1">Edit</a>
						</div>
						<?php
					}
					else if($q['sisa']<=3){	
						?>	
						<script>
							$(document).ready(function(){
								$('#pesan_sedia').css("color","red");
								$('#pesan_sedia').append("<span class='glyphicon glyphicon-asterisk'></span>");
							});
						</script>
						<div class='alert alert-warning d-flex align-items-center justify-content-center gap-3 p-2 mb-2'>
							<div>Stok  <a style='color:red'><?php echo $q['nama'] ?></a> yang tersisa tinggal <?php echo $q['sisa'] ?>. Segera lakukan pembelian produk ini lagi agar tidak kehabisan stock.</div>
							<a href="edit.php?id=<?php echo $q['id']; ?>" class="buttonku-1">Edit</a>
						</div>	
						<?php
					}
				}
				?>
				<!-- <button onclick="window.print()">print</button> -->
				<?php 
				$per_hal = 10;
				$jumlah_record = mysqli_query($koneksi, "SELECT COUNT(*) as jum from barang");
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
						<th class="col-md-1">No</th>
						<th class="col-md-3">Nama Barang</th>
						<th class="col-md-2">Jenis Barang</th>
						<th class="col-md-1 text-end">Harga Beli</th>
						<th class="col-md-1 text-center">Stock</th>
						<th class="col-md-1 text-center">Sisa</th>
						<th class="col-md-1 text-end">Harga Jual</th>
						<th class="col-md-3 text-center">Opsi</th>
					</tr>
					<?php 
					if(isset($_GET['cari'])){
						$cari=mysqli_real_escape_string($koneksi, $_GET['cari']);
						$brg=mysqli_query($koneksi, "SELECT * from barang where nama like '$cari%' or jenis like '$cari%' order by nama");
						$_SESSION['filterDataBarang'] = true;
						$_SESSION['kwCariDataBarang'] = $cari;

						$jumlah_record = mysqli_query($koneksi, "SELECT COUNT(*) as jum from barang where nama like '$cari%' or jenis like '$cari%' order by nama");
						$jum = mysqli_fetch_assoc($jumlah_record);
						$_SESSION['jum'] = $jum['jum'];
						$halaman = ceil($jum['jum'] / $per_hal);
					}else{
						$brg=mysqli_query($koneksi, "select * from barang order by nama limit $start, $per_hal");
						$_SESSION['filterDataBarang'] = false;
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
							<td><?php echo $b['nama'] ?></td>
							<td><?php echo $b['jenis'] ?></td>
							<td class="text-end">Rp.<?php echo number_format($b['modal']) ?>,-</td>
							<td class="text-center"><?php echo $b['jumlah'] ?></td>
							<td class="text-center"><?php echo $b['sisa'] ?></td>
							<td class="text-end">Rp.<?php echo number_format($b['harga']) ?>,-</td>
							<td id="rowResponsive" class="text-center">
								<div class="d-flex justify-content-center align-items-center gap-1">
									<a id="btnDesktop" href="det_barang.php?id=<?php echo $b['id']; ?>" class="d-none d-lg-inline-flex buttonku-1">Detail</a>
									<a id="btnDesktop" href="edit.php?id=<?php echo $b['id']; ?>" class="d-none d-lg-inline-flex buttonku-1">Edit</a>
									<a id="btnDesktop" onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='hapus.php?id=<?php echo $b['id']; ?>' }" class="d-none d-lg-inline-flex buttonku-1-danger">Hapus</a>
	
									<button id="btnMobile" class="d-inline-flex d-lg-none buttonku-1" onclick="window.location.href='det_barang.php?id=<?php echo $b['id']; ?>';"><i class="bi-three-dots"></i></button>
									<button id="btnMobile" class="d-inline-flex d-lg-none buttonku-1" onclick="window.location.href='edit.php?id=<?php echo $b['id']; ?>';"><i class="bi-pencil-square"></i></button>
									<button id="btnMobile" class="d-inline-flex d-lg-none buttonku-1-danger" onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='hapus.php?id=<?php echo $b['id']; ?>' }"><i class="bi-trash"></i></button>
								</div>
							</td>
						</tr>
						<?php
					}
					?>
					<tr>
						<td colspan="3" class="text-center">Sub Total <?php echo $jum['jum']; ?> items</td>
							<?php 
								if(isset($_GET['cari'])){
									$x=mysqli_query($koneksi, "SELECT sum(modal * jumlah) as totalKeluar from barang where nama like '$cari%' or jenis like '$cari%' order by nama");	
									$xx=mysqli_fetch_array($x);
	
									$y=mysqli_query($koneksi, "SELECT sum(jumlah) as jmlhBrg from barang where nama like '$cari%' or jenis like '$cari%' order by nama");	
									$yy=mysqli_fetch_array($y);

									$y2=mysqli_query($koneksi, "SELECT sum(sisa) as jmlhSisa from barang where nama like '$cari%' or jenis like '$cari%' order by nama");	
									$yy2=mysqli_fetch_array($y2);
	
									$z=mysqli_query($koneksi, "SELECT sum(harga * jumlah) as profit from barang where nama like '$cari%' or jenis like '$cari%' order by nama");	
									$zz=mysqli_fetch_array($z);
								}
								else{
									$x=mysqli_query($koneksi, "SELECT sum(modal * jumlah) as totalKeluar from barang");	
									$xx=mysqli_fetch_array($x);
	
									$y=mysqli_query($koneksi, "SELECT sum(jumlah) as jmlhBrg from barang");	
									$yy=mysqli_fetch_array($y);
	
									$y2=mysqli_query($koneksi, "SELECT sum(sisa) as jmlhSisa from barang");	
									$yy2=mysqli_fetch_array($y2);

									$z=mysqli_query($koneksi, "SELECT sum(harga * jumlah) as profit from barang");	
									$zz=mysqli_fetch_array($z);
								}
								echo "
								<td class='text-end'><b> Rp.". number_format($xx['totalKeluar']).",-</b></td>
								<td class='text-center'><b>". number_format($yy['jmlhBrg'])."</b></td>
								<td class='text-center'><b>". number_format($yy2['jmlhSisa'])."</b></td>
								<td class='text-end'><b> Rp.". number_format($zz['profit']).",-</b></td>
								";
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


<!-- modal -->
<div class="modal fade" id="modalTambahBarang" tabindex="-1" aria-labelledby="modalLabelTambahBarang" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
				<?php
				if(isset($_POST['reqToUpdate'])){
					?>
					<h1 class="modal-title fs-5" id="modalLabelTambahBarang">Edit Data Barang</h1>
					<?php
				}else{
					?>
					<h1 class="modal-title fs-5" id="modalLabelTambahBarang">Tambah Barang Baru</h1>
					<?php
				}
				?>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
			<?php
			if(isset($_POST['namaBarang'])){
				mysqli_connect('localhost','root','','projectweb');
				$namaBarang = $_POST['namaBarang'];
				$koneksi = mysqli_connect('localhost','root','','projectweb');
				$query = mysqli_query($koneksi, "select * from barang where nama like '$namaBarang%' or jenis like '$namaBarang%' order by nama");
				$cek2 = mysqli_num_rows($query);
				if($cek2 > 0){
					?>
					<div id="actionWhenDangerDataBarang" class="p-3" style="display: none; background: rgba(255,0,0,.1)">
						<div class="text-danger">Nama barang sudah terdaftar, tampilkan dan ubah data barang?</div>
						<div class="d-flex gap-1 justify-content-center py-2">
							<form action="barang.php" method="post" class="d-flex flex-column gap-2">
								<input class="btn btn-primary" type="submit" name="reqToUpdate" value="Ya">
							</form>
							<button class="buttonku-1" onclick="toggleDangerDataBarang()">Tidak, saya ingin menambah data baru</button>
						</div>
					</div>
					<?php
				}
			}
			?>
      <div class="modal-body">
				<?php
				if(isset($_POST['reqToUpdate'])){
					?>
					<script>
					$(document).ready(function(){
						$("#modalTambahBarang").modal("show");
					});
					</script>
					<?php
					$namaBarang = $_SESSION["namaBarang"];
					$det=mysqli_query($koneksi, "select * from barang where nama='$namaBarang'")or die(mysql_error($koneksi));
					while($d=mysqli_fetch_array($det)){
					?>					
						<form action="update.php" method="post" class="d-flex flex-column gap-3">
							<div class="form-group">
								<label for="namaBarang" class="form-label">Nama Barang</label>
								<input type="hidden" name="id" value="<?php echo $d['id'] ?>">
								<input name="namaBarang" id="namaBarang" type="text" class="form-control" placeholder="Nama Barang .." onkeyup="this.value = this.value.toUpperCase()" value="<?php echo $d['nama'] ?>" required>
							</div>
							<div class="form-group">
								<label for="jenisBarang" class="form-label">Jenis Barang</label>
								<input name="jenisBarang" id="jenisBarang" type="text" class="form-control" placeholder="Jenis Barang .." onkeyup="this.value = this.value.toUpperCase()" value="<?php echo $d['jenis'] ?>" required>
							</div>
							<div class="form-group">
								<label for="suplier" class="form-label">Suplier</label>
								<input name="suplier" id="suplier" type="text" class="form-control" placeholder="Suplier .." onkeyup="this.value = this.value.toUpperCase()" value="<?php echo $d['suplier'] ?>" required>
							</div>
							<div class="form-group">
								<label for="hargaModal" class="form-label">Harga Modal</label>
								<input name="hargaModal" id="hargaModal" type="number" min="0" class="form-control" placeholder="Harga Modal .." value="<?php echo $d['modal'] ?>" required>
							</div>
							<div class="form-group">
								<label for="hargaJual" class="form-label">Harga Jual</label>
								<input name="hargaJual" id="hargaJual" type="number" min="0" class="form-control" placeholder="Harga Jual .." value="<?php echo $d['harga'] ?>" required>
							</div>
							<div class="form-group">
								<label for="jumlah" class="form-label">Jumlah</label>
								<input name="jumlah" id="jumlah" type="number" min="0" class="form-control" placeholder="Harga Modal .." value="<?php echo $d['jumlah'] ?>" required>
							</div>
							<div class="modal-footer">
								<button class="buttonku-1"><a href="barang.php">Kosongkan Form</a></button>
								<input type="reset" class="buttonku-1" value="Reset">
								<input type="submit" class="btn btn-primary" value="Simpan Perubahan">
							</div>
						</form>
					<?php 
					}
				}
				else{
					?>
					<form name="formBarang" action="barang.php" method="post" class="d-flex flex-column gap-3 needs-validation" novalidate>
						<div class="form-group">
							<label for="namaBarang" class="form-label">Nama Barang</label>
							<input name="namaBarang" id="namaBarang" type="text" class="form-control" placeholder="Nama Barang .." onkeyup="this.value = this.value.toUpperCase()" required>
							<div class="invalid-feedback">Nama Barang belum diisi.</div>
						</div>
						<div class="form-group">
							<label for="jenisBarang" class="form-label">Jenis</label>
							<input name="jenisBarang" id="jenisBarang" type="text" class="form-control" placeholder="Jenis Barang .." onkeyup="this.value = this.value.toUpperCase()" required>
							<div class="invalid-feedback">Jenis Barang belum diisi.</div>
						</div>
						<div class="form-group">
							<label for="suplier" class="form-label">Suplier</label>
							<input name="suplier" id="suplier" type="text" class="form-control" placeholder="Suplier .." onkeyup="this.value = this.value.toUpperCase()" required>
							<div class="invalid-feedback">Suplier belum diisi.</div>
						</div>
						<div class="form-group">
							<label for="hargaModal" class="form-label">Harga Modal</label>
							<input name="hargaModal" id="hargaModal" type="number" min="0" class="form-control" placeholder="Modal per unit" required>
							<div class="invalid-feedback">Harga Modal belum diisi.</div>
						</div>
						<div class="form-group">
							<label for="hargaJual" class="form-label">Harga Jual</label>
							<input name="hargaJual" id="hargaJual" type="number" min="0" class="form-control" placeholder="Harga Jual per unit" required>
							<div class="invalid-feedback">Harga Jual belum diisi.</div>
						</div>
						<div class="form-group">
							<label for="jumlah" class="form-label">Jumlah</label>
							<input name="jumlah" id="jumlah" type="number" min="0" class="form-control" placeholder="Jumlah" required>
							<div class="invalid-feedback">Jumlah belum diisi.</div>
						</div>
						<!-- </div> -->
						<div class="">
							<?php
							if(isset($_POST['namaBarang'])){
								$_SESSION["namaBarang"] = $_POST['namaBarang'];
								
								mysqli_connect('localhost','root','','projectweb');
								$namaBarang = $_POST['namaBarang'];
								$koneksi = mysqli_connect('localhost','root','','projectweb');

								$query = mysqli_query($koneksi, "select * from barang where nama like '$namaBarang%' or jenis like '$namaBarang%' order by nama");
								$cek2 = mysqli_num_rows($query);
								if($cek2 > 0){
									// sudah ada data yang sama
									?>
									<script>
									const isDangerDataBarang = null
									$(document).ready(function(){
										$("#modalTambahBarang").modal("show");
										retriveData()
										toggleDangerDataBarang()
									});
									function toggleDangerDataBarang(){
										var x = document.getElementById("actionWhenDangerDataBarang");
										let _namaBrg = localStorage.getItem("namaBarang")
										if (x.style.display === "none" && _namaBrg.length !== 0) {
											x.style.display = "block";
										} else {
											x.style.display = "none";
										}
									}
									function getPreviousData(){
										resetLocalStorage();
										resetCacheBarang();
										localStorage.setItem("reqToUpdate", true);
										toggleDangerDataBarang();
										location.reload();
									}
									</script>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
										<label class="form-check-label" for="invalidCheck">Nama barang adalah nama baru dan belum pernah dikirim sebelumnya.</label>
										<div class="invalid-feedback">Kotak ini harus dicentang.</div>
									</div>
									</div>
									<div class="modal-footer">
										<input type="reset" class="buttonku-1" value="Reset" onclick="toggleDangerDataBarang()">
										<input type="submit" value="Kirim" name="cek_data" class="btn btn-primary" onclick="cekData()">
									</div>
									<?php
								}else{
									$jenisBarang = $_POST['jenisBarang'];
									$suplier=$_POST['suplier'];
									$hargaModal=$_POST['hargaModal'];
									$hargaJual=$_POST['hargaJual'];
									$jumlah=$_POST['jumlah'];
									$sisa=$_POST['jumlah'];
									mysqli_query($koneksi, "insert into barang values('','$namaBarang','$jenisBarang','$suplier','$hargaModal','$hargaJual','$jumlah','$sisa')");
									global $namaBarang;
									unset($namaBarang);
									$namaBarang = null;
									?>
									<script>
										localStorage.removeItem("namaBarang");
										localStorage.removeItem("jenisBarang");
										localStorage.removeItem("suplier");
										localStorage.removeItem("hargaModal");
										localStorage.removeItem("hargaJual");
										localStorage.removeItem("jumlah");
										console.log('resetLocalStorage');
										window.open("barang.php", "_self")
										console.log('open window');
										$("#modalTambahBarang").modal("hide");
										console.log('hide modal');
									</script>
									<?php
								}
							}
							else{
								?>
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
									<label class="form-check-label" for="invalidCheck">Nama barang adalah nama baru dan belum pernah dikirim sebelumnya.</label>
									<div class="invalid-feedback">Kotak ini harus dicentang.</div>
								</div>
								</div>
								<div class="modal-footer">
									<input type="reset" class="buttonku-1" value="Reset">
									<button class="btn btn-primary" onclick="cekData()">Kirim</button>
								</div>
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
	let cacheBarang = {
		namaBarang: '',
		jenisBarang: '',
		suplier: '',
		hargaModal: 0,
		hargaJual: 0,
		jumlah: 0
	};
	function cekData() {
		let getInputBarang = {
			namaBarang: document.getElementById("namaBarang").value,
			jenisBarang: document.getElementById("jenisBarang").value,
			suplier: document.getElementById("suplier").value,
			hargaModal: document.getElementById("hargaModal").value,
			hargaJual: document.getElementById("hargaJual").value,
			jumlah: document.getElementById("jumlah").value
		}
		function addToLocalStorage(){
			localStorage.setItem("namaBarang", getInputBarang.namaBarang);
			localStorage.setItem("jenisBarang", getInputBarang.jenisBarang);
			localStorage.setItem("suplier", getInputBarang.suplier);
			localStorage.setItem("hargaModal", getInputBarang.hargaModal);
			localStorage.setItem("hargaJual", getInputBarang.hargaJual);
			localStorage.setItem("jumlah", getInputBarang.jumlah);
			localStorage.setItem("dangerDataBarang", false);
			return true;
		}
		
		function getFromLocalStorage(){
			cacheBarang.namaBarang = localStorage.getItem("namaBarang");
			cacheBarang.jenisBarang = localStorage.getItem("jenisBarang");
			cacheBarang.suplier = localStorage.getItem("suplier");
			cacheBarang.hargaModal = localStorage.getItem("hargaModal");
			cacheBarang.hargaJual = localStorage.getItem("hargaJual");
			cacheBarang.jumlah = localStorage.getItem("jumlah");
			return true;
		}
		
		function retriveToElement(){
			document.getElementById("namaBarang").value = cacheBarang.namaBarang;
			document.getElementById("jenisBarang").value = cacheBarang.jenisBarang;
			document.getElementById("suplier").value = cacheBarang.suplier;
			document.getElementById("hargaModal").value = cacheBarang.hargaModal;
			document.getElementById("hargaJual").value = cacheBarang.hargaJual;
			document.getElementById("jumlah").value = cacheBarang.jumlah;
			return true;
		}

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
		addToLocalStorage()
		getFromLocalStorage()
		retriveToElement()


		return true;
	}
	function retriveData(){
		// document.formBarang.namaBarang.value = cacheBarang.namaBarang;
		document.getElementById("namaBarang").value = localStorage.getItem("namaBarang");
		document.getElementById("jenisBarang").value = localStorage.getItem("jenisBarang");
		document.getElementById("suplier").value = localStorage.getItem("suplier");
		document.getElementById("hargaModal").value = localStorage.getItem("hargaModal");
		document.getElementById("hargaJual").value = localStorage.getItem("hargaJual");
		document.getElementById("jumlah").value = localStorage.getItem("jumlah");
		return true;
	}
	function resetLocalStorage(){
		localStorage.removeItem("namaBarang");
		localStorage.removeItem("jenisBarang");
		localStorage.removeItem("suplier");
		localStorage.removeItem("hargaModal");
		localStorage.removeItem("hargaJual");
		localStorage.removeItem("jumlah");
	}
	function resetCacheBarang(){
		cacheBarang.namaBarang = '';
		cacheBarang.jenisBarang = '';
		cacheBarang.suplier = '';
		cacheBarang.hargaModal = 0;
		cacheBarang.hargaJual = 0;
		cacheBarang.jumlah = 0;
		console.log('cacheBarang.namaBarang = ', cacheBarang.namaBarang);
		console.log('cacheBarang.jenisBarang = ', cacheBarang.jenisBarang);
		console.log('cacheBarang.suplier = ', cacheBarang.suplier);
		console.log('cacheBarang.hargaModal = ', cacheBarang.hargaModal);
		console.log('cacheBarang.hargaJual = ', cacheBarang.hargaJual);
		console.log('cacheBarang.jumlah = ', cacheBarang.jumlah);
	}
	if (cacheBarang.namaBarang.length !== 0 && cacheBarang.jenisBarang.length !== 0 && cacheBarang.suplier.length !== 0 && cacheBarang.hargaModal !== 0 && cacheBarang.hargaJual !== 0 && cacheBarang.jumlah !== 0){
		document.getElementById("namaBarang").value = cacheBarang.namaBarang;
		document.getElementById("jenisBarang").value = cacheBarang.jenisBarang;
		document.getElementById("suplier").value = cacheBarang.suplier;
		document.getElementById("hargaModal").value = cacheBarang.hargaModal;
		document.getElementById("hargaJual").value = cacheBarang.hargaJual;
		document.getElementById("jumlah").value = cacheBarang.jumlah;
	}
	// $(document).ready(function(){
	// 	$("#modalTambahBarang").modal("show");
	// });
</script>


<?php 
include 'footer.php';

?>