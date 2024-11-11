<?php

include '../config.php';
session_start();


if (isset($_GET['id'])) {

	$id = $_GET['id'];

	mysqli_query($koneksi, "DELETE FROM user WHERE id_user='$id' ");

	$_SESSION['success'] = 'Berhasil menghapus data';

	header('location: ../index.php?page=user');
}
?>