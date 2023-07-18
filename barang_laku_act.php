<?php 
$koneksi = mysqli_connect('localhost','root','','projectweb');
$tgl=$_POST['tgl'];
$nama=$_POST['nama'];
$jumlah=$_POST['jumlahLaku'];
date_default_timezone_set('Asia/Jakarta');
$idTransaksi = 'T'.date('mdY-His', time());

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
  mysqli_query($koneksi, "insert into barang_laku values('$idTransaksi','$tgl','$nama','$jumlah','$harga','$total_harga','$labaa')")or die(mysql_error($koneksi));
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


?>