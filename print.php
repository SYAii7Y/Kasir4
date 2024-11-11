<?php
include 'config.php';
$id_trx=$_GET['idtrx'];
$data = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_transaksi='$id_trx'");
$trx = mysqli_fetch_assoc($data);

$detail = mysqli_query($koneksi, "SELECT transaksi_detail.*, barang.nama FROM `transaksi_detail` INNER JOIN barang ON transaksi_detail.id_barang=barang.id_barang WHERE transaksi_detail.id_transaksi='$id_trx'");

?>
<html>
<head>
	<title>Kasir Selesai</title>
	<style type="text/css">
		@page{margin:0;}
		body{ margin:0; font-size:10px; font-family: monospace;}
		td{ font-size:10px }
		.sheet{
			margin:0;
			overflow: hidden;
			position: relative;
			box-sizing: border-box;
			page-break-after: always;
		}
		body{
			font-weight:bold;
		}
		body.struk .sheet{ width:58mm; }
		body.struk .sheet{ padding:2mm; }
		.text-left {text-align: left;}
		.text-center {text-align: center;}
		.text-right {text-align:right;}
		@media screen{
			body{background: #e0e0e0;font-family: monospace;}
			.sheet{
				background: wgite;
				box-shadow: 0 .5mm 2mm rgba(0,0,0,.3);
				margin: 5mm;
			}
		}
		@media print{
			body{font-family: monospace;}
			body.struk{width: 58mm; text-align:left; }
			body.struk .sheet{padding: 2mm;}
			.text-left {text-align: left;}
		.text-center {text-align: center;}
		.text-right {text-align:right;}
		}
	</style>
</head>
<script>window.print()</script>
<body>
	<div style="width:70mm" align="center">
		<table width="100%" border="0" cellpadding="1" cellspacing="0">
			<tr>
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
		<table width="100%" class="" border="0">
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
		<table width="100%" border="0" cellpadding="3" cellspacing="0">
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
		<table border="0" cellpadding="1" cellspacing="0">
			<tr><td><hr></td></tr>
			<tr>
				<th>Terimkasih Telah Memilih Kami</th>
			</tr>
			<tr>
				<th>===== Layanan Konsumen ====</th>
			</tr>
			<tr>
				<th>WA 081395561931</th>
			</tr>
		</table>
	</div>
</body>
<meta http-equiv="refresh" content="0;url=kasir.php">
</html>