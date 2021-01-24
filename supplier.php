<?php
  //Koneksi Database
  $server = "localhost";
  $user = "root";
  $pass = "";
  $database = "uas-web";

  $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

  //jika tombol simpan diklik
  if(isset($_POST['bsimpan']))
  {
    //Pengujian Apakah data akan diedit atau disimpan baru
    if(@$_GET['hal'] == "edit")
    {
      //Data akan di edit
      $edit = mysqli_query($koneksi, "UPDATE supplier set
                        nama_supplier = '$_POST[tnama]',
                        no_telp = '$_POST[ttelp]',
                        alamat = '$_POST[talamat]'
                       WHERE id_supplier = '$_GET[id]'
                       ");
      if($edit) //jika edit sukses
      {
        echo "<script>
            alert('Edit data suksess!');
            document.location='supplier.php';
             </script>";
      }
      else
      {
        echo "<script>
            alert('Edit data GAGAL!!');
            document.location='supplier.php';
             </script>";
      }
    }
    else
    {
      //Data akan disimpan Baru
      $simpan = mysqli_query($koneksi, "INSERT INTO supplier (nama_supplier, no_telp, alamat)
                      VALUES ('$_POST[tnama]', 
                           '$_POST[ttelp]', 
                           '$_POST[talamat]')
                     ");
      if($simpan) //jika simpan sukses
      {
        echo "<script>
            alert('Simpan data suksess!');
            document.location='supplier.php';
             </script>";
      }
      else
      {
        echo "<script>
            alert('Simpan data GAGAL!!');
            document.location='supplier.php';
             </script>";
      }
    }


    
  }


  //Pengujian jika tombol Edit / Hapus di klik
  if(isset($_GET['hal']))
  {
    //Pengujian jika edit Data
    if(@$_GET['hal'] == "edit")
    {
      //Tampilkan Data yang akan diedit
      $tampil = mysqli_query($koneksi, "SELECT * FROM supplier WHERE id_supplier = '$_GET[id]' ");
      $data = mysqli_fetch_array($tampil);
      if($data)
      {
        //Jika data ditemukan, maka data ditampung ke dalam variabel
        $vnama = $data['nama_supplier'];
        $vtelp = $data['no_telp'];
        $valamat = $data['alamat'];
      }
    }
    else if (@$_GET['hal'] == "hapus")
    {
      //Persiapan hapus data
      $hapus = mysqli_query($koneksi, "DELETE FROM supplier WHERE id_supplier = '$_GET[id]' ");
      if($hapus){
        echo "<script>
            alert('Hapus Data Suksess!!');
            document.location='supplier.php';
             </script>";
      }
    }
  }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Supplier Toko</title>

  </head>
<body style="background: linear-gradient(to right, #0062E6, #33AEFF)">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainnav" style="background-color: #84817a">
      <div class="container">
        <a class="navbar-brand" href="#">TOKO PRAMANA ARYA</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="home.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="barang.php">Barang</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="supplier.php">Supplier</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="member.php">Member</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>


    
<br><br>

    <div class="container">

      <!-- Awal Card Form -->
      <div class="card mt-3">
        <div class="card-header bg-primary text-white">
          Form Input Data Supplier
        </div>
        <div class="card-body">
          <form method="post" action="">
            <div class="form-group">
              <label>Nama</label>
              <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama supplier disini!" required>
            </div>
            <div class="form-group">
              <label>Nomor Telephone</label>
              <input type="text" name="ttelp" value="<?=@$vtelp?>" class="form-control" placeholder="Input Nomor supplier disini!" required>
            </div>
            <div class="form-group">
              <label>Alamat</label>
              <input type="text" name="talamat" value="<?=@$valamat?>" class="form-control" placeholder="Input Alamat supplier disini!" required>
            </div> 

            <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
            <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

          </form>
        </div>
      </div>
      <!-- Akhir Card Form -->

      <!-- Awal Card Tabel -->
      <div class="card mt-3">
        <div class="card-header bg-success text-white">
          Daftar Supplier
        </div>
        <div class="card-body">
          
          <table class="table table-bordered table-striped">
            <tr>
              <th>No.</th>
              <th>Nama</th>
              <th>Nomor Telephone</th>
              <th>Alamat</th>
              <th>Aksi</th>
            </tr>
            <?php
              $no = 1;
              $tampil = mysqli_query($koneksi, "SELECT * from supplier order by id_supplier desc");
              while($data = mysqli_fetch_array($tampil)) :

            ?>
            <tr>
              <td><?=$no++;?></td>
              <td><?=$data['nama_supplier']?></td>
              <td><?=$data['no_telp']?></td>
              <td><?=$data['alamat']?></td>
              <td>
                <a href="supplier.php?hal=edit&id=<?=$data['id_supplier']?>" class="btn btn-warning"> Edit </a>
                <a href="supplier.php?hal=hapus&id=<?=$data['id_supplier']?>" 
                   onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>
              </td>
            </tr>
          <?php endwhile; //penutup perulangan while ?>
          </table>

        </div>
      </div>
      <!-- Akhir Card Tabel -->

</div>




    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  </body>
</html>
