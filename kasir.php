<?php
include 'config.php';
session_start();
$barang = mysqli_query($koneksi, 'SELECT * FROM barang');
$sum = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        $sum += ($value['harga'] * $value['qty']) - $value['diskon'];
    }
}
?>
<?php
include 'config.php';
include 'check.php';
if (isset($_POST['kode_barang'])) {
    $kode_barang = $_POST['kode_barang'];
    $qty = 1;

    //menampilkan data barang
    $data = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang='$kode_barang'");
    $b = mysqli_fetch_assoc($data);

    //cek jika di keranjang sudah ada barang yang masuk
    $key = array_search($b['id_barang'], array_column($_SESSION['cart'], 'id'));

     if ($key !== false) {
        // return var_dump($_SESSION['cart']);

        //jika ada data yang sesuai di keranjang akan ditambahkan jumlah nya
        $c_qty = $_SESSION['cart'][$key]['qty'];
        $_SESSION['cart'][$key]['qty'] = $c_qty + 1;

        //cek jika ada potongan dan cek jumlah barang lebih besar sama dengan minimum order potongan
        if ($disb['qty'] && $_SESSION['cart'][$key]['qty'] >= $disb['qty']) {

            //cek kelipatan jumlah barang dengan batas minimum order
            $mod = $_SESSION['cart'][$key]['qty'] % $disb['qty'];

            if ($mod == 0) {

                //Jika benar jumlah barang kelipatan batas minimum order
                $d = $_SESSION['cart'][$key]['qty'] / $disb['qty'];
            } else {

                //Simpan jumlah potongan yang didapat
                $d = ($_SESSION['cart'][$key]['qty'] - $mod) / $disb['qty'];
            }

            //Simpan diskon dengan jumlah kelipatan dikali potongan barang
            $_SESSION['cart'][$key]['diskon'] = $d * $disb['potongan'];
        }
    } else {
        // return var_dump($b);
        //Jika tidak ada yang sesuai akan menjadi barang baru dikeranjang
        $barang = [
            'id' => $b['id_barang'],
            'gambar' => $b['gambar'],
            'nama' => $b['nama'],
            'harga' => $b['harga'],
            'qty' => $qty,
            'jumlah' => $b['jumlah'],
            'diskon' => 0,
        ];
        $_SESSION['cart'][] = $barang;

        }

    header('location:kasir.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<style>
.gam_img:hover{
    transform: scale(1.1); // 300% zoom hover, sesuaikan dgn kebutuhan...
}
</style>
</head>
<body>
	<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
		<a class="navbar-brand col-md-3 col-lg-1 mr-0 px-3" href="kasir.php"><img src="img/name.png" width="400px"></a>
	<li class="nav-item p-1">
	<a class="nav-link btn-danger shadow rounded" href="logout.php" onclick="return confirm('Apakah Anda Yakin Logout?')">
		  LOGOUT
		</a>
	  </li>
	</nav>
<div class="container-fluid m-0" style="padding:10px 50px 0 50px">
	<div class="row">
		<div class="col-md-12">
			<h2>Hai <?=$_SESSION['nama']?></h2>
			<a href="keranjang_reset.php" class="btn btn-dark">Reset Keranjang</a>
			<a href="riwayat.php" class="btn btn-dark">Riwayat Transaksi</a>
			<!--<a href="page/barang.php" class="btn btn-dark">Data Barang</a>-->
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-9">
			<form method="post" action="">
				<div class="form-group">
					<th><select name="kode_barang" class="form-control">
						<?php
					$barang = mysqli_query($koneksi, 'SELECT * FROM barang');
			while($row=$barang->fetch_array()){
			?>
			<option value="<?=$row['kode_barang']?>"><?=$row['nama']?> | Rp.<?=number_format($row['harga'])?></option>
			<?php
			}
			?>
					</select></th>
					<th><input type="submit" name="submit" class="btn btn-primary"></th>
				</div>
			</form>
			<br>
			<form method="post" action="keranjang_update.php">
			<table class="table table-bordered table-striped">
				<tr class="bg-dark text-light">
					<th width="250"><h5>Nama</h4></th>
					<th width="160"><h5>Harga</th>
					<th width="100"><h5>Qty</th>
					<th width="180"><h5>Sub Total</th>
					<th width="90"><h5>Action</th>
				</tr>
				<?php if (isset($_SESSION['cart'])): ?>
				<?php foreach ($_SESSION['cart'] as $key => $value) {
					$d_barang=$value['id'];
					$data = mysqli_query($koneksi, "SELECT * FROM barang where id_barang='$d_barang'");
    $dat = mysqli_fetch_assoc($data);
    $d=$dat['jumlah'];
				 ?>
					<tr>
						<td>
							<h4><?=$value['nama']?></h4>
							<?php if ($value['diskon'] > 0): ?>
								<br><small class="label label-danger">Diskon <?=number_format($value['diskon'])?></small>
							<?php endif;?>
						</td>
						<td align="right"><h4><?=number_format($value['harga'])?></td>
						<td class="col-md-2">
							<input type="number" name="qty[<?=$key?>]" value="<?=$value['qty']?>" min="1" max="<?=$d?>" class="form-control">
						</td>
						<td align="right"><h4><?=number_format(($value['qty'] * $value['harga'])-$value['diskon'])?></td>
						<td align="center"><a href="keranjang_hapus.php?id=<?=$value['id']?>" class="btn btn-danger btn-lg">X</a></td>
					</tr>
				<?php } ?>
				<?php endif; ?>
			</table>
			<button type="submit" name="perbarui" class="btn btn-success">Perbarui</button>

			</form>
		</div>
		<div class="col-md-3">
			<h3>Total Rp. <?=number_format($sum)?></h3>
			<form action="" method="POST">
				<input type="hidden" name="total" value="<?=$sum?>">
			<div class="form-group">
				<label>Bayar</label>
				<input type="text" id="bayar" name="bayar" class="form-control">
			</div>
			<button type="submit" name="save" class="btn btn-primary">Selesai</button>
			<?php
			if(isset($_POST['save'])){
				$byr=preg_replace('/\D/', '', $_POST['bayar']);
				if($sum>$byr){
					echo "<script> alert('Jumlah Uang Kurang dari Rp.".number_format($sum)." !')</script>";
				}else{
					$bayar = preg_replace('/\D/', '', $_POST['bayar']);
//print_r(preg_replace('/\D/', '', $_POST['total']));

// print_r($_SESSION['cart']) ;

$tanggal_waktu = date('Y-m-d H:i:s');
$nomor = rand(111111,999999);
$total = $_POST['total'];
$nama = $_SESSION['nama'];
$kembali = $bayar - $total;
$tanggal = date('Y-m-d');


//insert ke tabel transaksi
mysqli_query($koneksi, "INSERT INTO transaksi (id_transaksi,tanggal_waktu,nomor,total,nama,bayar,kembali,tanggal) VALUES (NULL,'$tanggal_waktu','$nomor','$total','$nama','$bayar','$kembali','$tanggal')");
//mendapatkan id transaksi baru
$id_transaksi = mysqli_insert_id($koneksi);

//insert ke detail transaksi
foreach ($_SESSION['cart'] as $key => $value) {
	$id_barang = $value['id'];
	$nama_barang = $value['nama'];
	$harga = $value['harga'];
	$qty = $value['qty'];
	$tot = $harga*$qty;
	
	
	mysqli_query($koneksi,"INSERT INTO transaksi_detail (id_transaksi_detail,id_transaksi,id_barang,nama_barang,harga,qty,total) VALUES (NULL,'$id_transaksi',$id_barang,'$nama_barang','$harga','$qty','$tot')");

	$data = mysqli_query($koneksi, "SELECT * FROM barang where id_barang='$id_barang'");
    $data = mysqli_fetch_assoc($data);
    $stok=$data['jumlah'];
    $stokbaru=$stok-$qty;
	mysqli_query($koneksi,"UPDATE barang set jumlah='$stokbaru' where id_barang='$id_barang'");
	// $sum += $value['harga']*$value['qty'];
}

$_SESSION['cart'] = [];

//redirect ke halaman transaksi selesai
header("location:transaksi_selesai.php?idtrx=".$id_transaksi);

				}
			}
			?>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">

	//inisialisasi inputan
	var bayar = document.getElementById('bayar');

	bayar.addEventListener('keyup', function (e) {
        bayar.value = formatRupiah(this.value, 'Rp. ');
        // harga = cleanRupiah(dengan_rupiah.value);
        // calculate(harga,service.value);
    });

    //generate dari inputan angka menjadi format rupiah

	function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    //generate dari inputan rupiah menjadi angka

    function cleanRupiah(rupiah) {
        var clean = rupiah.replace(/\D/g, '');
        return clean;
        // console.log(clean);
    }
</script>
</body>
</html>