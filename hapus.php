<?php 
$koneksi = mysqli_connect('localhost','root','','projectweb');
$id=$_GET['id'];
mysqli_query($koneksi, "delete from barang where id='$id'");
header("location:barang.php");
?>