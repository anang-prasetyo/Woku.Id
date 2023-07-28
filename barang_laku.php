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
		<!-- <button class="btn btn-info"><a href="coba.html">coba</a></button> -->
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
						<td><?php echo $b['id_transaksi'] ?></td>
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
				<div class="modal-title fs-5 d-flex gap-2">
					<div class="" id="exampleModalLabel">Tambah Penjualan</div>
					<button class="btn btn-light position-relative">
						<i class="bi bi-cart"></i>
						<span id="cartQty" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"></span>
				</button>
				</div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
			<!-- <form name="formBarangLaku" action="barang_laku_act.php" method="post" class="d-flex flex-column gap-3 needs-validation" novalidate>
				<div class="modal-body">
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
					<button class="buttonku-1-primary" onclick="cekDataBarangLaku()">Tambah Transaksi Penjualan</button>
				</div>
			</form> -->
			<form name="formBarangLaku" action="barang_laku_act.php" method="get" class="needs-validation" novalidate>
				<div id="inputCartName" class="d-flex flex-column gap-3 modal-body">
					<div class="form-group">
						<label>Tanggal</label>
						<input name="inputCartQty" type="number" id="inputCartQty" hidden>
						<input name="tgl" type="date" class="form-control" id="tgl" autocomplete="off" required>
						<div class="invalid-feedback">Tanggal belum diisi.</div>
					</div>	
					<div class="form-group">
						<label>Silahkan Pilih Barang</label>
						<div class="d-flex gap-1 flex-wrap">
							<?php
							// $_SESSION["cartQty"] = 0;
							$brg=mysqli_query($koneksi, "select * from barang order by nama");
							while($b=mysqli_fetch_array($brg)){
								echo '
								<div class="badge text-bg-secondary" style="cursor: pointer;" onclick="actionCartQty(\'+\', \''. $b["nama"] .'\'), addNewElement(\''. $b["nama"] .'\', \''. $b["sisa"] .'\')">'. $b["nama"] .'</div>
								';
							}
							?>
						</div>
						<div class="invalid-feedback">Nama Barang belum dipilih.</div>
					</div>
					<!-- <div>
						<div>cartQty : <?php echo $_SESSION["cartQty"] ?></div>
					</div> -->
					<!-- <div>
						<div id="cartName"></div>
						<div class="btn btn-light" onclick="actionCartQty('+'), addNewElement()">add cartName</div>
						<div class="btn btn-light" onclick="actionCartQty('+'), actionCartName('+')">add cartName</div>
						<div class="btn btn-light" onclick="actionCartQty('-'), delEl(0)">del cartName</div>
						<div class="btn btn-light" onclick="actionCartQty('-'), actionCartName('-')">del cartName</div>
					</div> -->
					<!-- <div class="form-group"></div> -->
					<div id="tempatTampil"></div>
					<!-- <div>
						<div class="btn btn-info" onclick="actionCartQty('+')">add cartQty</div>
						<div class="btn btn-warning" onclick="actionCartQty('-')">del cartQty</div>
					</div> -->
					<!-- <div class="form-group">
						<label>Jumlah Barang Terjual</label>
						<input name="jumlahLaku" type="number" min="0" class="form-control" placeholder="Jumlah Barang Terjual .." autocomplete="off" required>
						<div class="invalid-feedback">Jumlah belum diisi.</div>
					</div>																	 -->
					<!-- <div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
						<label class="form-check-label" for="invalidCheck">Pastikan jumlah sisa stock barang lebih banyak dari jumlah barang yang terjual.</label>
						<div class="invalid-feedback">Kotak ini harus dicentang.</div>
					</div> -->
				</div>
				<div class="modal-footer">
					<input type="reset" class="buttonku-1" value="Reset" onclick="delElAll()">
					<button class="buttonku-1-primary" onclick="cekDataBarangLaku()">Tambah Transaksi Penjualan</button>
				</div>
			</form>
    </div>
  </div>
</div>
<script>
  let countNewEl = 0
	let newEl = 0
	let isNewEl = false
	
	function addNewElement(n, m) {
		let cekInput = document.getElementById(n)
		if (cekInput){
			console.log('sudah ada');
			document.getElementById(n).value ++
		}
		else {
			console.log('belum ada');
			console.log('countNewEl -> ',countNewEl);
			if (countNewEl == 0){
				addEl1(0)
				addEl(0)
				addClass(0, n, m)
				countNewEl = countNewEl + 1
				console.log('kosong');
			}
			else {
				addEl1(countNewEl)
				addEl(countNewEl)
				addClass(countNewEl, n, m)
				countNewEl = countNewEl + 1
				console.log('isi');
			}
			console.log('countNewEl -> ',countNewEl);
		}
	}
	function addEl1(n){
		const element = document.getElementById("tempatTampil");
		const divParent = document.createElement("div");
		element.appendChild(divParent);
		let elDivLength = Number(element.getElementsByTagName('div').length - 1)
		element.getElementsByTagName('div')[elDivLength].id = 'div'+n
		const elementParent = document.getElementById('div'+n);
		elementParent.classList.add('d-flex')
		elementParent.classList.add('flex-column')
		elementParent.classList.add("mb-3")
		elementParent.classList.add("border")
		elementParent.classList.add("p-2")
	}
	function addEl(n){
		const paraTitle = document.createElement("span");
		const paraTitleLeft = document.createElement("span");
		const nodeTitleLeft = document.createTextNode("Barang Laku");
		// const nodeTitleLeft = document.createTextNode("Barang "+Number(n+1));
		const paraTitleRight = document.createElement("button");
		const nodeTitleRight = document.createTextNode("Hapus");
		const para = document.createElement("label");
		const node = document.createTextNode("Nama");
		const para2 = document.createElement("input");
		
		const para_ = document.createElement("label");
		const node_ = document.createTextNode("Terjual");
		const para2_ = document.createElement("input");
		const elementParent = document.getElementById('div'+n);
		
		const para__ = document.createElement("label");
		const node__ = document.createTextNode("Stok");
		const para2__ = document.createElement("input");

		elementParent.appendChild(paraTitle);
		paraTitleLeft.appendChild(nodeTitleLeft);
		elementParent.getElementsByTagName('span')[0].appendChild(paraTitleLeft);
		paraTitleRight.appendChild(nodeTitleRight);
		elementParent.getElementsByTagName('span')[0].appendChild(paraTitleRight);

		para.appendChild(node);
		elementParent.appendChild(para);
		elementParent.appendChild(para2);
		
		para__.appendChild(node__);
		elementParent.appendChild(para__);
		elementParent.appendChild(para2__);
		
		para_.appendChild(node_);
		elementParent.appendChild(para_);
		elementParent.appendChild(para2_);
	}
	function addClass(n, m, l) {
		const elementParent = document.getElementById('div'+n)
		// const inputEl = elementParent.getElementsByTagName('input')
		elementParent.getElementsByTagName('input')[0].classList.add("form-control");
		elementParent.getElementsByTagName('input')[1].classList.add("form-control");
		elementParent.getElementsByTagName('input')[2].classList.add("form-control");
		elementParent.getElementsByTagName('input')[0].readOnly = true
		elementParent.getElementsByTagName('input')[0].name = 'nama'+n
		elementParent.getElementsByTagName('input')[1].value = l
		elementParent.getElementsByTagName('input')[1].readOnly = true
		elementParent.getElementsByTagName('input')[2].type = 'number'
		elementParent.getElementsByTagName('input')[2].min = '1'
		elementParent.getElementsByTagName('input')[2].value = '1'
		elementParent.getElementsByTagName('input')[2].id = m
		elementParent.getElementsByTagName('input')[2].name = 'jumlahLaku'+n
		
		const spanEl = elementParent.getElementsByTagName('span')[0]
		spanEl.classList.add("d-flex");
		spanEl.classList.add("justify-content-between");
		
		const spanElButton = spanEl.getElementsByTagName('button')
		spanElButton[0].classList.add("btn");
		spanElButton[0].classList.add("btn-danger");
		spanElButton[0].onclick = function(){
			document.getElementById('div'+n).remove();
			console.log('countNewEl = ', countNewEl);
			actionCartQty('-', m)
		};
		
		cart.name.push(m)
		elementParent.getElementsByTagName('input')[0].value = m
	}
	function delElAll(){
		if (countNewEl > 0){
			for (let a = 0; a < countNewEl; a++){
				document.getElementById('div'+a).remove();
			}
		}
	}
	function delEl(n){
		if (countNewEl > 0){
			document.getElementById('div'+n).remove();
			// document.getElementById('div'+(countNewEl-1)).remove();
			countNewEl = countNewEl - 1
		}
	}

	let barang = [{
		id: null,
		nama: null,
		jumlah: null,
		harga: null,
		sisa: null,
		jenis: null,
		supplier: null,
		modal: null,
	}]
	let cart = {
		name: [],
		qty: 0
	}
	localStorage.setItem('cartQty', cart.qty)
	let cartQty = localStorage.getItem('cartQty')
	if(cartQty > 0){
		document.getElementById('cartQty').innerText = cartQty;
	}
	function setGetCartQty(){
		localStorage.setItem('cartQty', cart.qty)
		let cartQty = localStorage.getItem('cartQty')
		document.getElementById('cartQty').innerText = cartQty;
	}
	function actionCartQty(s, t){
		if (s === '+'){
			let cekInput = document.getElementById(t)
			if (cekInput){
				console.log('barang sudah ada : ', t);
			}
			else {
				cart.qty++;
				setGetCartQty()
				document.getElementById('inputCartQty').value = cart.qty
			}
		}
		else if (s === '-'){
			if(cart.qty > 0){
				cart.qty--;
				setGetCartQty()
				if(cart.qty === 0){
					document.getElementById('cartQty').innerText = ''
				}
				document.getElementById('inputCartQty').value = cart.qty
			}
		}
	}
	function actionCartName(s, n){
		if (s === '+'){
			cart.name.push(n)
			document.getElementById('cartName').innerText = cart.namespace

			const divNama = document.createElement("div");
			const labelNama = document.createElement("label");
			const labelNama2 = document.createElement("label");
			const inputNama = document.createElement("input");
			const inputNama2 = document.createElement("input");
			// Create a class attribute:
			const attClass = document.createAttribute("class");

			// Set the value of the class attribute:
			attClass.value = "form-control";

			labelNama.innerHTML = "Nama Barang";
			const inputCartName = document.getElementById("inputCartName")
			inputCartName.appendChild(divNama);
			inputCartName.appendChild(labelNama);
			inputCartName.appendChild(inputNama);
			labelNama2.innerHTML = "Jumlah";
			inputCartName.appendChild(labelNama2);
			inputCartName.appendChild(inputNama2);
			if (!isNewEl){
				const h1 = inputCartName.getElementsByTagName("input")[newEl];
				h1.setAttributeNode(attClass);
				h1.value = n
				isNewEl = true
				newEl = newEl + 1
				// console.log('masih 0 ', newEl);
			}
			else {
				const h1 = document.getElementById("inputCartName").getElementsByTagName("input")[newEl++];
				h1.setAttributeNode(attClass);
				h1.value = n
				// console.log('0 -> ', newEl);
			}

		}
		else if (s === '-'){
			cart.name.splice(-1,1)
			document.getElementById('cartName').innerText = cart.name
		}
	}

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