<?php
include 'config.php';
session_start();

// print_r($_SESSION);

//fungsi dari membatasi hak akses

if (isset($_SESSION['userid'])) {
    if ($_SESSION['role_id'] == 2) {
        //redirect ke halaman kasir.php
        header('Location:kasir.php');
    }
} else {
    $_SESSION['error'] = 'Anda harus login dahulu';
    header('location:login.php');
}

 ?>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<style>
	.scroll{
		height: max-content;
		overflow-y:scroll;
		scrollbar-color: transparent transparent;
	}
	.scroll::-webkit-scrollbar{
		display: none;
	}
	.col-2{
		padding: 0;
		height: 700px;
	}
	navbar{
		position: fixed;
		ustify-content: space-evenly;
	}
	.nav{
		justify-content:center;
	}
  .bd-placeholder-img {
	font-size: 1.125rem;
	text-anchor: middle;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
  }

  @media (min-width: 768px) {
	.bd-placeholder-img-lg {
	  font-size: 3.5rem;
	}
  }
</style>

</head>
<body>
<nav class="navbar navbar-dark bg-dark flex-md-nowrap p-0">
<a class="navbar-brand col-md-3 col-lg-1 mr-0 px-3" href="index.php"><img src="img/name.png" width="400px"></a>
<li class="nav-item">
	<a class="nav-link btn-danger shadow rounded" href="logout.php" onclick="return confirm('Apakah Anda Yakin Logout?')">
		  LOGOUT
		</a>
	  </li>
</nav>
<button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="container-fluid p-0">
<nav id="sidebarMenu navbar" class="bg-dark sidebar">
  <div class="sidebar sticky-top flex-md-nowrap">
	<ul class="nav flex-row">
	  <li class="nav-item">
		  <a class="nav-link btn-dark shadow p-3" style="width:240px;font-size:20px ;" href="index.php"><center>Home</center></a>
	  </li>
	  <li class="nav-item">
		  <a class="nav-link btn-dark shadow p-3" style="width:240px;font-size:20px ;" href="index.php?page=barang"><center>Barang</center></a>
	  </li>
	  <li class="nav-item">
	  	<a class="nav-link btn-dark shadow p-3" style="width:240px;font-size:20px ;" href="index.php?page=user"><center>User</center></a>
	  </li>
	  <li class="nav-item">
	  	<a class="nav-link btn-dark shadow p-3" style="width:240px;font-size:20px ;" href="index.php?page=rwy"><center>Riwayat Transaksi</center></a>
	  </li>
	  
	</ul>
</div>

</nav>
<?php

      if (isset($_GET['page']) && $_GET['page'] != '') {
          include 'page/' . $_GET['page'] . '.php';
      } else {
          include 'page/home.php';
      }
    ?>
  </div>