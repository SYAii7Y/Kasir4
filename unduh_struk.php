<?php
include 'config.php';
$id_trx=$_GET['idtrx'];
$data = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_transaksi='$id_trx'");
$trx = mysqli_fetch_assoc($data);

$detail = mysqli_query($koneksi, "SELECT transaksi_detail.*, barang.nama FROM `transaksi_detail` INNER JOIN barang ON transaksi_detail.id_barang=barang.id_barang WHERE transaksi_detail.id_transaksi='$id_trx'");

?>
<html>
<center>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<div align="center">
		<table width="500" border="0" cellpadding="1" cellspacing="0" >
			<tr align="center">
				<th>DEIVFOUR FOOTWARE<br>
					Jl. Ambatunat 69 kec. Jawir Barat <br>
				</th>
			</tr>
			<tr align="center"><td><hr></td></tr>
			<tr>
				<td>#<?=$trx['nomor']?> | <?=date('d-m-Y H:i:s', strtotime($trx['tanggal_waktu']))?> <?=$trx['nama']?></td>
			</tr>
			<tr><td><hr></td></tr>
		</table>
		<table width="500" border="0">
			<tr>
				<td>Nama Barang</td>
				<td>Harga/Pcs</td>
				<td>Jumlah</td>
				<td align="right">Sub Total</td>
			</tr>
			<?php
			$view=$koneksi->query("SELECT * from transaksi_detail WHERE id_transaksi='$id_trx'");
        while ($row = $view->fetch_array()) { ?>
			<tr>
				<td><?=$row['nama_barang'] ?></td>
				<td><?=$row['harga'] ?></td>
				<td><?=$row['qty'] ?></td>
				<td align="right"><?=$row['total'] ?></td>
			</tr>
		<?php }?>
		</table>
		<table width="500" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td colspan="4"><hr></td>
			</tr>
			<tr>
				<td align="right" colspan="3">Total :</td>
				<td align="right"><?=number_format($trx['total'])?></td>
			</tr>
			<tr>
				<td align="right" colspan="3">Bayar :</td>
				<td align="right"><?=number_format($trx['bayar'])?></td>
			</tr>
			<tr>
				<td align="right" colspan="3">Kembalian :</td>
				<td align="right"><?=number_format($trx['kembali'])?></td>
			</tr>
		</table>
		<table width="500" border="0" cellpadding="1" cellspacing="0">
			<tr><td><hr></td></tr>
			<tr align="center">
				<th>Terimkasih Telah Memilih Kami</th>
			</tr>
			<tr align="center">
				<th>===== Layanan Konsumen ====</th>
			</tr>
			<tr align="center">
				<th>WA 081395561931</th>
			</tr>
		</table>
	</div>
	<meta http-equiv="refresh" content="10;kasir.php">
</html>