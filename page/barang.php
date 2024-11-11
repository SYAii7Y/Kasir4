<?php
include 'config.php';
$view = $koneksi->query('SELECT * FROM barang');
if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
	}

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<div class="container p-0" style="margin:0px 50px 0px 100px;">

	<?php
	if ($_SESSION['role_id'] == 2){
		include '../config.php';
	?>
	 <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
<a class="navbar-brand col-md-3 col-lg-1 mr-0 px-3" href="#"><img src="../img/name.png" width="400px"></a>
<ul class="navbar-nav">
<li class="nav-item text-nowrap">
  <a class="nav-link text-light" href="../kasir.php">Kembali</a>
</li>
</ul>
</nav>
<h1>List Barang</h1>
<div style="padding: 0px 50px 0px 50px;">
	<table class="table table-bordered table-striped">
		<tr class="bg-secondary text-light ">
			<th>ID Barang</th>
			<th>Kode</th>
			<th>Gambar</th>
			<th>Nama</th>
			<th>Harga</th>
			<th>Jumlah Stok</th>
		</tr>
		<?php
		$batas=5;
		$halaman=isset($_GET['halaman'])?(int)$_GET['halaman'] :1;
		$halaman_awal=($halaman>1)?($halaman * $batas)-$batas:0;
		$prev=$halaman-1;
		$next=$halaman+1;
		$data=mysqli_query($koneksi,"SELECT * FROM barang");
		$jumlah_data=mysqli_num_rows($data);
		$total_halaman=ceil($jumlah_data/$batas);
		$data_barang=mysqli_query($koneksi,"SELECT * FROM barang limit $halaman_awal,$batas");
		$nomor=$halaman_awal+1;
        while ($row=mysqli_fetch_array($data_barang)) { ?>

		<tr>
			<td> <?= $row['id_barang'] ?> </td>
			<td> <?= $row['kode_barang'] ?> </td>
			<td><img src="../img/<?=$row['gambar']?>" width="100px"></td>
			<td><?= $row['nama'] ?></td>
			<td><?=$row['harga']?></td>
			<td><?=$row['jumlah']?></td>
		</tr>

		<?php }
        ?>

	</table>
</div>
	<?php
	}else{
	?>	
	
	<h1>List Barang</h1>
	<a href="index.php?page=barang_add" class="btn btn-primary">Tambah data</a>
	<hr>
	<table class="table table-bordered table-striped table-sm">
		<tr class="bg-secondary text-light">
			<th width="50px">NO</th>
			<th width="170px">Kode Barang</th>
			<th>Nama</th>
			<th>Harga</th>
			<th width="60px">Stok</th>
			<th width="170px">Aksi</th>
		</tr>
		<?php
		$batas=5;
		$halaman=isset($_GET['halaman'])?(int)$_GET['halaman'] :1;
		$halaman_awal=($halaman>1)?($halaman * $batas)-$batas:0;
		$prev=$halaman-1;
		$next=$halaman+1;
		$data=mysqli_query($koneksi,"SELECT * FROM barang");
		$jumlah_data=mysqli_num_rows($data);
		$total_halaman=ceil($jumlah_data/$batas);
		$data_barang=mysqli_query($koneksi,"SELECT * FROM barang limit $halaman_awal,$batas");
		$nomor=$halaman_awal+1;
		$no=1;
        while ($row =mysqli_fetch_array($data_barang)) { 


        ?>

		<tr>
			<td><?=$no++?></td>
			<td> <?= $row['kode_barang'] ?> </td>
			<td><?= $row['nama'] ?></td>
			<td>Rp.<?=number_format($row['harga'])?></td>
			<td align="center"><?=$row['jumlah']?></td>
			<td align="center">
				<a href="index.php?page=barang_edit&id=<?= $row['id_barang'] ?>"
					class="btn btn-primary">Edit</a>
				<a href="page/barang_hapus.php?id=<?= $row['id_barang'] ?>" onclick="return confirm('apakah anda yakin?')"
					class="btn btn-danger">Hapus</a>
			</td>
		</tr>

		<?php }}
		?>
	</table>
	<ul class="pagination justify-content-center">
			<li class="page-item">
				<a class="page-link" <?php if($halaman>1){ echo "href='?page=barang&halaman=$prev'";}?>>Previous</a>
			</li>
		<?php
		$x=1;
		for($x=1;$x<=$total_halaman;$x++){
			?>
			<li class="page-item">
				<a class="page-link" href="?page=barang&halaman=<?=$x?>"><?=$x ?></a></li>
			<?php
		}
?>
<li class="page-item">
	<a class="page-link" <?php if ($halaman<$total_halaman){ echo "href='?page=barang&halaman=$next'"; }?>>Next</a>
</li>
</ul>
</div>