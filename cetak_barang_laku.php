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
  <title>Cetak Transaksi Penjualan Barang</title>
  <link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/font/bootstrap-icons.css">
	<link rel="stylesheet" href="assets/base.css">
</head>
<body>
  <div class="container py-3">
    <div>Data Transaksi Penjualan Barang <?php
    if($_SESSION['thisDate']){
      echo 'Tanggal '.$_SESSION['thisDate']; 
    } 
    ?></div>
    <table class="table border border-1 mt-3" style="font-size: 12px;">
      <tr>
        <th class="">No</th>
        <th class="">ID Transaksi</th>
        <th class="">Tanggal </th>
        <th class="">Nama Barang</th>
        <th class="text-end">Harga Barang</th>
        <th class="text-center">Jumlah Barang</th>
        <th class="text-end">Total Harga</th>    
      </tr>
      <?php
			if ($_SESSION["dateStart"] && $_SESSION["dateEnd"]){
        $dateStart = $_SESSION["dateStart"];
        $dateEnd = $_SESSION["dateEnd"];
        $barang_laku = mysqli_query($koneksi, "SELECT * from barang_laku where tanggal between '$dateStart' and '$dateEnd' order by tanggal desc");
      }
			else if ($_SESSION["dateStart"] || $_SESSION["dateEnd"]){
				if($_SESSION["dateStart"]){
          $tanggal = mysqli_real_escape_string($koneksi, $_SESSION["dateStart"]);
        }
        else if($_SESSION["dateEnd"]){
          $tanggal = mysqli_real_escape_string($koneksi, $_SESSION["dateEnd"]);
        }
        else{
          $tanggal = mysqli_real_escape_string($koneksi, $_SESSION['thisDate']);
        }
        $barang_laku = mysqli_query($koneksi, "SELECT * from barang_laku where tanggal like '$tanggal' order by tanggal desc");
      }
      else {
        $barang_laku = mysqli_query($koneksi, "SELECT * FROM barang_laku");
      }
      $i = 1;
      foreach( $barang_laku as $row){
        ?>
        <tr>
          <td><?php echo $i++; ?></td>
          <td><?php echo $row["id"]; ?></td>
          <td><?php echo $row["tanggal"]; ?></td>
          <td><?php echo $row["nama"]; ?></td>
          <td class="text-end">Rp. <?php echo number_format($row["harga"]); ?>,-</td>
          <td class="text-center"><?php echo $row["jumlah"]; ?></td>
          <td class="text-end">Rp. <?php echo number_format($row["total_harga"]); ?>,-</td>
        </tr>
        <?php
        }
        ?>
        <tr>
          <td colspan="5" class="text-center">Total Pemasukan Dari <?php echo $_SESSION['jum']; ?> Transaksi</td>
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
  </div>
  <script>
    window.print()
    // $(document).ready(function(){
    // });
  </script>
</body>
</html>