<?php
$koneksi = mysqli_connect('localhost','root','','projectweb');

$cartQty = $_GET['inputCartQty'];
$tgl=$_GET['tgl'];
date_default_timezone_set('Asia/Jakarta');
$idTransaksi = 'T'.date('mdY-His', time());
if ($cartQty == 1){
  $nama=$_GET['nama0'];
  $jumlah=$_GET['jumlahLaku0'];
  
  $dt=mysqli_query($koneksi, "select * from barang where nama='$nama'");
  $data=mysqli_fetch_array($dt);
  $jumlahStock=$data['sisa'];
  $sisa=$jumlahStock-$jumlah;
  // $sisa=$data['jumlah']-$jumlah;
  $harga=$data['harga'];
  
  if ($sisa > 0){
    mysqli_query($koneksi, "update barang set sisa='$sisa' where nama='$nama'");
    $modal=$data['modal'];
    $laba=$harga-$modal;
    $labaa=$laba*$jumlah;
    $total_harga=$harga*$jumlah;
    mysqli_query($koneksi, "insert into barang_laku values('$idTransaksi','$tgl','$nama','$jumlah','$harga','$total_harga','$labaa', '')")or die(mysql_error($koneksi));
    header("location:barang_laku.php");
  }
  else{
    if ($jumlahStock == 0){
      echo '
      <script>
      let text = "Stock ' . $nama . ' telah habis. Silahkan membeli lagi produk tersebut atau periksa kembali data anda.";
      alert(text)
      window.open("barang_laku.php", "_self")
      localStorage.setItem("tambahPenjualanErrorMsg", text)
      </script>
      ';
    }
    else {
      echo '
      <script>
      let text = "Stock tidak cukup! Tinggal tersisa ' . $jumlahStock . ' barang, sedangkan anda ingin menambahkan ' . $jumlah . ' barang. Silahkan periksa kembali data anda.";
      alert(text)
      window.open("barang_laku.php", "_self")
      localStorage.setItem("tambahPenjualanErrorMsg", text)
      </script>
      ';
    }
  }
}
else {
  for ($a = 0; $a < $cartQty; $a++){
    $nama[$a] = $_GET['nama'.$a];
    $jumlah[$a] = $_GET['jumlahLaku'.$a];
    $dt[$a] = mysqli_query($koneksi, "select * from barang where nama='$nama[$a]'");
    $data[$a] = mysqli_fetch_array($dt[$a]);
    $jumlahStock[$a] = $data[$a]['sisa'];
    $sisa[$a] = $jumlahStock[$a] - $jumlah[$a];
    $harga[$a] = $data[$a]['harga'];
    if ($sisa[$a] > 0){
      mysqli_query($koneksi, "update barang set sisa='$sisa[$a]' where nama='$nama[$a]'");
      $modal[$a] = $data[$a]['modal'];
      $laba[$a] = $harga[$a] - $modal[$a];
      $labaa[$a] = $laba[$a] * $jumlah[$a];
      $total_harga[$a] = $harga[$a] * $jumlah[$a];
      mysqli_query($koneksi, "insert into barang_laku values('$idTransaksi','$tgl','$nama[$a]','$jumlah[$a]','$harga[$a]','$total_harga[$a]','$labaa[$a]', '')")or die(mysql_error($koneksi));
      header("location:barang_laku.php");
    }
    else{
      if ($jumlahStock[$a] == 0){
        echo '
        <script>
        let text = "Stock ' . $nama[$a] . ' telah habis. Silahkan membeli lagi produk tersebut atau periksa kembali data anda.";
        alert(text)
        window.open("barang_laku.php", "_self")
        localStorage.setItem("tambahPenjualanErrorMsg", text)
        </script>
        ';
      }
      else {
        echo '
        <script>
        let text = "Stock tidak cukup! Tinggal tersisa ' . $jumlahStock[$a] . ' barang, sedangkan anda ingin menambahkan ' . $jumlah[$a] . ' barang. Silahkan periksa kembali data anda.";
        alert(text)
        window.open("barang_laku.php", "_self")
        localStorage.setItem("tambahPenjualanErrorMsg", text)
        </script>
        ';
      }
    }
  }
}


?>