<?php 
$koneksi = mysqli_connect('localhost','root','','projectweb');
$id=$_GET['id'];
mysqli_query($koneksi, "delete from admin where id='$id'");
header("location:tambah_user.php");
?>