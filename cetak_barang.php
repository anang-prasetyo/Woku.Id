<?php
  session_start();
	$koneksi = mysqli_connect('localhost','root','','projectweb');
	mysqli_connect('localhost','root','','projectweb');
  // hide error
  error_reporting(0);
  ini_set('display_errors', 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak Data Barang</title>
  <link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/font/bootstrap-icons.css">
	<link rel="stylesheet" href="assets/base.css">
</head>
<body>
  <div class="container py-3">
    <div>Data Barang</div>
    <table class="table border border-1 mt-3" style="font-size: 12px;">
      <tr>
        <th class="">No</th>
        <th class="">Nama Barang</th>
        <th class="">Jenis Barang</th>
        <th class="">Suplier</th>
        <th class="col-md-1 text-end">Harga Beli</th>
        <th class="col-md-1 text-center">Stock</th>
        <th class="col-md-1 text-center">Sisa</th>
        <th class="col-md-1 text-end">Harga Jual</th>
      </tr>
      <?php
      if ($_SESSION['filterDataBarang'] === true){
        $cari = $_SESSION['kwCariDataBarang'];
        $barang = mysqli_query($koneksi, "SELECT * from barang where nama like '$cari%' or jenis like '$cari%' order by nama");
      }
      else {
        $barang = mysqli_query($koneksi, "SELECT * FROM barang");
      }
      $i = 1;
      foreach( $barang as $row){
        ?>
        <tr>
          <td><?php echo $i++; ?></td>
          <td><?php echo $row["nama"]; ?></td>
          <td><?php echo $row["jenis"]; ?></td>
          <td><?php echo $row["suplier"]; ?></td>
          <td class="text-end">Rp. <?php echo number_format($row["modal"]); ?>,-</td>
          <td class="text-center"><?php echo $row["jumlah"]; ?></td>
          <td class="text-center"><?php echo $row["sisa"]; ?></td>
          <td class="text-end">Rp. <?php echo number_format($row["harga"]); ?>,-</td>
        </tr>
      <?php
        }
      ?>
      <tr>
        <td colspan="4" class="text-center">Sub Total <?php echo $_SESSION['jum']; ?> items</td>
          <?php 
            if($_SESSION['filterDataBarang']){
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
  </div>
  <script>
    window.print()
    // $(document).ready(function(){
    // });
  </script>
</body>
</html>