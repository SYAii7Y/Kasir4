<?php
include 'config.php';
$id_trx=$_GET['idtra'];
$data = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_transaksi='$id_trx'");
$trx = mysqli_fetch_assoc($data);

$detail = mysqli_query($koneksi, "SELECT transaksi_detail.*, barang.nama FROM `transaksi_detail` INNER JOIN barang ON transaksi_detail.id_barang=barang.id_barang WHERE transaksi_detail.id_transaksi='$id_trx'");

?>
<body>
	<div class="row">
	<div class="col-8">
	<h1>Detail Transaksi</h1>
	<hr>
	<table class="table table-bordered table-striped table-sm">
		<tr class="bg-secondary text-light">
			<th width="150px">ID Transaksi</th>
			<th>ID Detail Transaksi</th>
			<th>ID Barang</th>
			<th>Nama Barang</th>
			<th>Harga</th>
			<th>QTY</th>
			<th>Total</th>
			<th></th>
		</tr>
		<?php
		while($row=$detail->fetch_array()){
		?>
		<tr>
			<td><?=$row['id_transaksi']?></td>
			<td><?=$row['id_transaksi_detail']?></td>
			<td><?=$row['id_barang']?></td>
			<td><?=$row['nama_barang']?></td>
			<td><?=$row['harga']?></td>
			<td><?=$row['qty']?></td>
			<td><?=$row['total']?></td>
			<td><a href="print.php?idtrx=<?=$row['id_transaksi']?>" class="btn btn-dark">Print</a></td>
		</tr>
		<?php } ?>
	</table>

</div>
<div class="col-4">
	<div align="center">
		<table border="0" cellpadding="1" cellspacing="0" >
			<tr align="center">
				<th>DEIVFOUR FOOTWARE<br>
					Jl. Ambatunat 69 kec. Jawir Barat <br>
				</th>
			</tr>
			<tr align="center"><td><hr></td></tr>
			<tr>
				<td>#<?=$trx['nomor']?> | <?=date('d-M-Y H:i:s', strtotime($trx['tanggal_waktu']))?> <?=$trx['nama']?></td>
			</tr>
			<tr><td><hr></td></tr>
		</table>
		<table border="0">
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
		<table border="0" cellpadding="3" cellspacing="0">
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
		<table border="0" cellpadding="1" cellspacing="0">
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
</div>
</div>
</body>