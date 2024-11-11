
<?php

include 'config.php';
session_start();
$u=$_SESSION['nama'];
include 'check.php';

$view = $koneksi->query("SELECT * FROM transaksi where nama='$u' order by tanggal desc");
// return var_dump($view);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Riwayat Transaksi</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid p-0">

	<?php if (isset($_SESSION['success']) && $_SESSION['success'] != '') {?>

		<div class="alert alert-success" role="alert">
			<?=$_SESSION['success']?>
		</div>

	<?php
        }
        $_SESSION['success'] = '';
    ?>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
<a class="navbar-brand col-md-3 col-lg-1 mr-0 px-3" href="#"><img src="img/name.png" width="400px"></a>
<ul class="navbar-nav">
<li class="nav-item text-nowrap">
  <a class="nav-link text-light" href="kasir.php">Kembali</a>
</li>
</ul>
</nav>
    
  <div style="padding:0px 50px 0px 50px"><h1>Riwayat Transaksi</h1>
	<table class="table table-bordered table-striped">
		<tr class="bg-secondary text-light">
			<th>#Nomor</th>
			<th>Tanggal</th>
			<th>Total</th>
			<th>Kasir</th>
			<th>Bayar</th>
			<th>Kembali</th>
			<th>Detail</th>
		</tr>
		<?php
 	$batas=10;
		$halaman=isset($_GET['halaman'])?(int)$_GET['halaman'] :1;
		$halaman_awal=($halaman>1)?($halaman * $batas)-$batas:0;
		$prev=$halaman-1;
		$next=$halaman+1;
		$data=mysqli_query($koneksi,"SELECT * FROM transaksi where nama='$u'");
		$jumlah_data=mysqli_num_rows($data);
		$total_halaman=ceil($jumlah_data/$batas);
		$data_barang=mysqli_query($koneksi,"SELECT * FROM transaksi where nama='$u' limit $halaman_awal,$batas");
		$nomor=$halaman_awal+1;
        while ($row =mysqli_fetch_array($data_barang)) { 
		?>
 	<tr>
 		<td><?= $row['nomor'] ?></td>
 		<td><?= $row['tanggal_waktu'] ?></td>
 		<td><?= number_format($row['total']) ?></td>
 		<td><?= $row['nama'] ?></td>
 		<td><?= number_format($row['bayar']) ?></td>
 		<td><?= number_format($row['kembali']) ?></td>
 		<td><a href="detail.php?idtra=<?=$row['id_transaksi'] ?>" class="btn btn-sm btn-primary">Lihat</a></td>
 	</tr>
 <?php } ?>
	</table>
	<ul class="pagination justify-content-center">
			<li class="page-item">
				<a class="page-link" <?php if($halaman>1){ echo "href='?page=rwy&halaman=$prev'";}?>>Previous</a>
			</li>
		<?php
		$x=1;
		for($x=1;$x<=$total_halaman;$x++){
			?>
			<li class="page-item">
				<a class="page-link" href="?page=rwy&halaman=<?=$x?>"><?=$x ?></a></li>
			<?php
		}
?>
<li class="page-item">
	<a class="page-link" <?php if ($halaman<$total_halaman){ echo "href='?page=rwy&halaman=$next'"; }?>>Next</a>
</li>
</ul>
</div>
</div>
</body>
</html>