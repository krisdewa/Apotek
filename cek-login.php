<?php 
// mengaktifkan session pada php
session_start();

// menghubungkan php dengan koneksi database
include 'connectdb.php';

// menangkap data yang dikirim dari form login
$email = $_POST['email'];
$password = $_POST['password'];


// menyeleksi data user dengan username dan password yang sesuai
$login = mysqli_query($koneksi,"select * from user where email='$email' and password='$password'");
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);

// cek apakah username dan password di temukan pada database
if($cek > 0){

	$data = mysqli_fetch_assoc($login);

	// cek jika user login sebagai admin
	if($data['level']=="kepala"){

		// buat session login dan username
		$_SESSION['email'] = $email;
		$_SESSION['level'] = "kepala";
		// alihkan ke halaman dashboard admin
		header("location:halaman-kepala.php");

	// cek jika user login sebagai pegawai
	}else if($data['level']=="staff"){
		// buat session login dan username
		$_SESSION['email'] = $email;
		$_SESSION['level'] = "staff";
		// alihkan ke halaman dashboard pegawai
		header("location:halaman-staff.php");

	}else{
		// alihkan ke halaman login kembali
		// echo("")
		header("location:login.php?pesan=gagal");
	}

	
}else{
	header("location:index.php?pesan=gagal");
}



?>