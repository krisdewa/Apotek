<?php
    include_once("../connectdb.php");
    include_once("navbar.php");
    include_once("../function/function.php");
    error_reporting(0);

    // PAGINATION TABLE 
    $batas = 4;
    $halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
    $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;	

    $sebelumnya = $halaman - 1;
    $selanjutnya = $halaman + 1;
    
    $data = mysqli_query($koneksi, "SELECT * FROM barang");
    $jumlah_data = mysqli_num_rows($data);
    $total_halaman = ceil($jumlah_data / $batas);

    $data = mysqli_query($koneksi, "SELECT * FROM barang LIMIT $halaman_awal, $batas");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Service</title> 
    <link rel="stylesheet" href="../css/style_tab.css" />
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@300&display=swap" rel="stylesheet">
</head>
<body>
    <div class="wrap-tab">
        <div class="tab">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        
                        <!-- FORM SEARCHING -->
                        <form action="" method="get">
                            <div class="input-group">
                                <!-- Buat sebuah textbox dengan name cari -->
                                <input type="text" class="form-control" placeholder="Pencarian..." id="keyword" name="cari" autofocus autocomplete="off"> &nbsp;
                                <span class="input-group-btn">
                                    <!-- Buat sebuah tombol search dengan type submit -->
                                    <button class="btn btn-primary" type="submit" id="btn-search" name="">SEARCH</button>
                                    <a href="jajal2.php" class="btn btn-warning">RESET</a>
                                </span>
                            </div>
                        </form>

                        <!-- PENCARIAN BARANG -->
                        <?php 
                        if(isset($_GET['cari'])){
                            $cari = $_GET['cari'];
                            $data = mysqli_query($koneksi, "SELECT * FROM barang WHERE nama_barang like '%".$cari."%'");					
                        }else{
                            $data = mysqli_query($koneksi, "SELECT * FROM barang LIMIT $halaman_awal, $batas");		
                        }

                        while($produk = mysqli_fetch_array($data)) { 
                        ?>
                        <div class="col-sm-6"> <br>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $produk['nama_barang'] ?></h5>
                                    <p class="card-text">Harga : RP.  <?= number_format($produk['harga_jual']) ?></p>
                                    <p class="card-text">Stock : <?= $produk['stok'] ?></p>
                                    <a href="beli.php?id=<?php echo $produk["ID_Barang"]; ?>" class="btn btn-primary">Beli</a>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        
                        <!-- PAGINATION TABLE -->
                        <nav>
                            <br>
                            <ul class="pagination justify-content-center">
                                <!-- Tombol Sebelumnya -->
                                <?php if($halaman <= 1) {?>
                                    <li class="page-item invisible">
                                        <a class="page-link" <?php echo "href='?halaman=$sebelumnya'"; ?>><</a>
                                    </li>
                                <?php } else { ?>
                                    <li class="page-item">
                                        <a class="page-link" <?php echo "href='?halaman=$sebelumnya'"; ?>><</a>
                                    </li>
                                <?php } ?>
                                
                                <!--  -->
                                <?php for($x=1;$x<=$total_halaman;$x++){ ?> 
                                    <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                                <?php } ?>	
                                <!--  -->

                                <!-- Tombol Selanjutnya -->
                                <?php if($halaman >= $total_halaman) {?>
                                    <li class="page-item invisible">
                                        <a  class="page-link" <?php echo "href='?halaman=$selanjutnya'"; ?>>></a>
                                    </li>
                                <?php } else { ?>
                                    <li class="page-item">
                                        <a  class="page-link" <?php echo "href='?halaman=$selanjutnya'"; ?>>></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </nav>
                    <div class="footer">
                        <a href="keranjang.php" class="btn btn-success float-xl-left">Keranjang &raquo;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>