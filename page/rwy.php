<?php 
include "config.php";
$view=$koneksi->query("SELECT * from transaksi order by tanggal desc");
$veiw=$koneksi->query("SELECT DISTINCT tanggal from transaksi order by tanggal desc");
$ptgs=mysqli_query($koneksi,"SELECT DISTINCT nama FROM transaksi");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

<div class="container" style="padding: 0px 0px 0px 0px;">
	<h1>Laporan Penjualan</h1>
		<form action="" method="POST" id="myForm">
			<div class="flex-row form-group">
		<select name="id" style="width:auto;" class="form" onchange="submitform()">
			<?php
			while($row=$veiw->fetch_array()){
			?>
			<option><?=$row['tanggal']?></option>
			<?php
			}
			?>
		</select>
		<script>
			function submitform(){
				document.getElementById('myForm').submit();
			}
		</script>
		<select name="ptg" style="width:auto;" required class="">
			<?php
			while($row=$ptgs->fetch_array()){
			?>
			<option><?=$row['nama']?></option>
			<?php
			}
			?>
		</select>
		<input type="submit" name="submit" class="btn btn-primary btn-sm">
	</div>
	</form>
	<?php
	if (isset($_POST['submit'])) {
		$tg=$_POST['id'];
		$pg=$_POST['ptg'];
	?>
	<a href="index.php?page=rwy" class="btn btn-primary">Tampilkan Semua Data</a>
	<table class="table table-bordered table-striped">
		<tr class="bg-secondary text-light ">
			<th>NO</th>
			<th>#Kode</th>
			<th>Tanggal/Waktu</th>
			<th>Total Pembelian</th>
			<th>Nama kasir</th>
			<th>Bayar</th>
			<th>Kembalian</th>
			<th>Detail</th>
		</tr>
	<?php
	$no=1;
	$view = $koneksi->query("SELECT * FROM transaksi WHERE tanggal='$tg' and nama='$pg'");
        while ($row = $view->fetch_array()) { 


        ?>

		<tr>
			<td><?=$no++?></td>
			<td> <?= $row['nomor'] ?> </td>
			<td> <?= $row['tanggal_waktu'] ?> </td>
			<td><?= $row['total'] ?></td>
			<td><?=$row['nama']?></td>
			<td><?=$row['bayar']?></td>
			<td><?=$row['kembali']?></td>
			<td><a href="print.php?idtrx=<?=$row['id_transaksi']?>" class="btn btn-sm btn-dark">Print</a>
				<a href="index.php?page=detra&idtra=<?=$row['id_transaksi'] ?>" class="btn btn-sm btn-primary">Lihat</a></td>
		</tr>

		<?php }}else{ ?>
			 <table class="table table-bordered table-striped table-sm">
 	<tr class="bg-secondary text-light">
 		<th>#Nomor</th>
 		<th>Tanggal</th>
 		<th>Total Harga</th>
 		<th>Nama Petugas</th>
 		<th>Bayar</th>
 		<th>Kembalian</th>
 		<th width="60px">Detail</th>
 	</tr>
 	<?php
 	$batas=8;
		$halaman=isset($_GET['halaman'])?(int)$_GET['halaman'] :1;
		$halaman_awal=($halaman>1)?($halaman * $batas)-$batas:0;
		$prev=$halaman-1;
		$next=$halaman+1;
		$data=mysqli_query($koneksi,"SELECT * FROM transaksi");
		$jumlah_data=mysqli_num_rows($data);
		$total_halaman=ceil($jumlah_data/$batas);
		$data_barang=mysqli_query($koneksi,"SELECT * FROM transaksi limit $halaman_awal,$batas");
		$nomor=$halaman_awal+1;
        while ($row =mysqli_fetch_array($data_barang)) { 
		?>
 	<tr>
 		<td><?= $row['nomor'] ?></td>
 		<td><?= $row['tanggal_waktu'] ?></td>
 		<td>Rp.<?= number_format($row['total']) ?></td>
 		<td><?= $row['nama'] ?></td>
 		<td>Rp.<?= number_format($row['bayar']) ?></td>
 		<td>Rp.<?= number_format($row['kembali']) ?></td>
 		<td><a href="index.php?page=detra&idtra=<?=$row['id_transaksi'] ?>" class="btn btn-sm btn-primary">Lihat</a></td>
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
		<?php
		}
        ?>

</table>
</div>
</table>
</div>
</body>
</html>