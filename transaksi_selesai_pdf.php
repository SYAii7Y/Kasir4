<?php
include 'config.php';
include "check.php";

$data = mysqli_query($koneksi,"SELECT * FROM transaksi WHERE id_transaksi='$id_trx'");
$trx = mysqli_fetch_assoc($data);

$detail = mysqli_query($koneksi,"SELECT transaksi_detail.*, barang.nama FROM `transaksi_detail` INNER JOIN barang ON transaksi_detail.id_barang=barang.id_barang WHERE transaksi_detail.id_transaksi='$id_trx'");

?>


<!DOCTYPE html>
<html>
<head>
	<title>Kasir Selesai</title>
	<style type="text/css">
		body{
			color: #a7a7a7;
			padding: 0px;
		}
	</style>
</head>
<body>
	<div align="center">
		<table width="100%" border="0" cellpadding="1" cellspacing="0">
			<tr align="center">
				<th>DEIVFOUR FOOTWEAR <br>
					Jl. Ambatunat 69 kec. Jawir Barat <br>
				</th>
			</tr>
			<tr align="center"><td><hr></td></tr>
			<tr align="center">
				<td>#<?=$trx['nomor']?> | <?=date('d-m-Y H:i:s',strtotime($trx['tanggal_waktu']))?> <?=$trx['nama']?></td>
			</tr>
			<tr><td><hr></td></tr>
		</table>
		<table width="100%" border="0" cellpadding="3" cellspacing="0">
			<?php while($row = mysqli_fetch_array($detail)){ ?>
			<tr>
				<td><?=$row['nama']?></td>
				<td><?=$row['qty']?></td>
				<td align="right"><?=number_format($row['harga'])?></td>
				<td align="right"><?=number_format($row['total'])?></td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="4"><hr></td>
			</tr>
			<tr>
				<td align="right" colspan="3">Total</td>
				<td align="right"><?=number_format($trx['total'])?></td>
			</tr>
			<tr>
				<td align="right" colspan="3">Bayar</td>
				<td align="right"><?=number_format($trx['bayar'])?></td>
			</tr>
			<tr>
				<td align="right" colspan="3">Kembali</td>
				<td align="right"><?=number_format($trx['kembali'])?></td>
			</tr>
		</table>
		<table width="100%" border="0" cellpadding="1" cellspacing="0">
			<tr><td><hr></td></tr>
			<tr align="center">
				<th>Terimkasih Telah memilih kami</th>
			</tr>
			<tr align="center">
				<th>===== Layanan Konsumen ====</th>
			</tr>
			<tr align="center">
				<th>WA 081395561931 </th>
			</tr>
		</table>
	</div>
</body>
</html>