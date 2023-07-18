<?php 
$koneksi = mysqli_connect('localhost','root','','projectweb');
$id=$_POST['id'];
$uname=$_POST['uname'];
$pass=$_POST['pass'];
$bagian=$_POST['bagian'];

mysqli_query($koneksi, "update admin set uname='$uname', pass='$pass', bagian='$bagian' where id='$id'");
header("location:tambah_user.php");

?>