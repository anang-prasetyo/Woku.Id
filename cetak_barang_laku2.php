<?php 
$koneksi = mysqli_connect('localhost','root','','projectweb');
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
    <div>Data Transaksi Penjualan Barang 
    <?php
    $id_transaksi = mysqli_real_escape_string($koneksi, $_GET['id_transaksi']);
    echo $id_transaksi; 
    ?>
    </div>
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
      $barang_laku = mysqli_query($koneksi, "SELECT * FROM barang_laku where id_transaksi='$id_transaksi'");
      $i = 1;
      foreach( $barang_laku as $row){
        ?>
        <tr>
          <td><?php echo $i++; ?></td>
          <td><?php echo $row["id_transaksi"]; ?></td>
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
          <td colspan="5" class="text-center">Total Pemasukan Dari 
            <?php
            $jumlah_items = mysqli_query($koneksi, "SELECT COUNT(*) as jum from barang_laku where id_transaksi='$id_transaksi'");
            // $jumlah_items = mysqli_query($koneksi, "SELECT COUNT(*) as jum from barang_laku where tanggal like '$tanggal'");
            $jum = mysqli_fetch_assoc($jumlah_items); 
            echo $jum['jum']; 
            ?> Items</td>
            <?php
              $x=mysqli_query($koneksi, "SELECT sum(jumlah) as jmlhLaku from barang_laku where id_transaksi='$id_transaksi'");	
              $xx=mysqli_fetch_array($x);

              $y=mysqli_query($koneksi, "SELECT sum(total_harga) as total from barang_laku where id_transaksi='$id_transaksi'");	
              $yy=mysqli_fetch_array($y);			
              echo "
              <td class='text-center'><b>". number_format($xx['jmlhLaku'])."</b></td>
              <td class='text-end'><b> Rp.". number_format($yy['total']).",-</b></td>
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