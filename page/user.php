
<?php



$view = $koneksi->query("SELECT u.*,r.nama as nama_role FROM user as u INNER JOIN role as r ON u.role_id=r.id_role");

?>

<div class="container">

	<?php if(isset($_SESSION['success']) && $_SESSION['success'] != '') {?>

		<div class="alert alert-success" role="alert">
			<?=$_SESSION['success']?>
		</div>

	<?php
		}
		$_SESSION['success'] = '';
	$no=1;
	?>

	<h1>List User</h1>

	
	<a href="index.php?page=user_add" class="btn btn-primary">Tambah User</a><hr>
	<table class="table table-bordered table-striped table-sm">
		<tr class="bg-secondary text-light">
			<th>NO</th>
			<th>Nama</th>
			<th>Username</th>
			<th>Password</th>
			<th>Role Akses</th>
			<th width="160px">Aksi</th>
		</tr>
		<?php
		$batas=5;
		$halaman=isset($_GET['halaman'])?(int)$_GET['halaman'] :1;
		$halaman_awal=($halaman>1)?($halaman * $batas)-$batas:0;
		$prev=$halaman-1;
		$next=$halaman+1;
		$data=mysqli_query($koneksi,"SELECT * FROM user");
		$jumlah_data=mysqli_num_rows($data);
		$total_halaman=ceil($jumlah_data/$batas);
		$data_barang=mysqli_query($koneksi,"SELECT u.*,r.nama as nama_role FROM user as u INNER JOIN role as r ON u.role_id=r.id_role limit $halaman_awal,$batas");
		$nomor=$halaman_awal+1;
        while ($row =mysqli_fetch_array($data_barang)) { 
		?>
		<tr>
			<td> <?=$no++ ?> </td>
			<td><?= $row['nama'] ?></td>
			<td><?=$row['username']?></td>
			<td>*******</td>
			<td><?=$row['nama_role']?></td>
			<td>
				<a href="index.php?page=user_edit&id=<?= $row['id_user'] ?>" class="btn btn-primary">Edit</a>
				<a href="page/user_hapus.php?id=<?= $row['id_user'] ?>" onclick="return confirm('apakah anda yakin?')"
					class="btn btn-danger">Hapus</a>
			</td>
		</tr>

		<?php }
		?>

	</table>
		<ul class="pagination justify-content-center">
			<li class="page-item">
				<a class="page-link" <?php if($halaman>1){ echo "href='?page=user&halaman=$prev'";}?>>Previous</a>
			</li>
		<?php
		$x=1;
		for($x=1;$x<=$total_halaman;$x++){
			?>
			<li class="page-item">
				<a class="page-link" href="?page=user&halaman=<?=$x?>"><?=$x ?></a></li>
			<?php
		}
?>
<li class="page-item">
	<a class="page-link" <?php if ($halaman<$total_halaman){ echo "href='?page=user&halaman=$next'"; }?>>Next</a>
</li>
</ul>
</div>