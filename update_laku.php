<?php 
$koneksi = mysqli_connect('localhost','root','','projectweb');
$id=$_POST['id'];
$tanggal=$_POST['tgl'];
$nama=$_POST['nama'];
$harga=$_POST['harga'];
$jumlahBaru=$_POST['jumlah'];
$total_harga= $harga * $jumlahBaru;

$dt=mysqli_query($koneksi, "select * from barang where nama='$nama'");
$data=mysqli_fetch_array($dt);
$jumlahStock=$data['sisa'];

$dtLaku=mysqli_query($koneksi, "select * from barang_laku where id='$id'");
$dataLaku=mysqli_fetch_array($dtLaku);
$jumlahLama=$dataLaku['jumlah'];

if($jumlahLama > $jumlahBaru){
  $jumlahUpdate = $jumlahLama - $jumlahBaru;
  // menambah stok barang
  $jumlahPenambahan = $jumlahStock + $jumlahUpdate;
  mysqli_query($koneksi, "update barang set sisa='$jumlahPenambahan' where nama='$nama'");

  // update barang_laku
  mysqli_query($koneksi, "update barang_laku set tanggal='$tanggal', nama='$nama', harga='$harga', jumlah='$jumlahBaru', total_harga='$total_harga' where id='$id'");
  header("location:barang_laku.php");
}
else{
  $jumlahUpdate = $jumlahBaru - $jumlahLama;
  if ($jumlahUpdate <= $jumlahStock){
    // mengurangi stok barang
    $jumlahPengurangan = $jumlahStock - $jumlahUpdate;
    mysqli_query($koneksi, "update barang set sisa='$jumlahPengurangan' where nama='$nama'");

    // update barang_laku
    mysqli_query($koneksi, "update barang_laku set tanggal='$tanggal', nama='$nama', harga='$harga', jumlah='$jumlahBaru', total_harga='$total_harga' where id='$id'");
    header("location:barang_laku.php");
  }
  else{
    echo '
    <script>
    let text = "Stock barang tidak cukup! Tinggal tersisa '. $jumlahStock .' barang, tetapi anda meminta untuk menambah ' . $jumlahUpdate .' barang. Mohon periksa kembali data anda.";
    alert(text)
    history.back();
    localStorage.setItem("tambahPenjualanErrorMsg", text)
    </script>
    ';
  }
}



?>