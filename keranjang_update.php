<?php
include 'config.php';
session_start();
include 'check.php';

$qty = $_POST['qty'];
$cart = $_SESSION['cart'];

// print_r($qty);

foreach ($cart as $key => $value) {
    $_SESSION['cart'][$key]['qty'] = $qty[$key];

    $idbarang = $_SESSION['cart'][$key]['id'];
    //cek diskon barang
    

    //cek jika di keranjang sudah ada barang yang masuk
    $key = array_search($idbarang, array_column($_SESSION['cart'], 'id'));
    // return var_dump($key);
    if ($key !== false) {
        // return var_dump($_SESSION['cart']);

        //cek jika ada potongan dan cek jumlah barang lebih besar sama dengan minimum order potongan
        if ($disb['qty'] && $_SESSION['cart'][$key]['qty'] >= $disb['qty']) {
                $d = $_SESSION['cart'][$key]['qty'];
    }
}
}
header('location:kasir.php');
