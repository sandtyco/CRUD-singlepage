<!DOCTYPE html>
<html>
<head>
	<title>Passman</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
            integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>

<?php

// --- koneksi ke database
$koneksi = mysqli_connect("localhost","root","","ecdb") or die(mysqli_error());

// --- Fungsi tambah data (Create)
function tambah($koneksi){
	
	if (isset($_POST['btn_simpan'])){
		$id = time();
		$title = $_POST['title'];
		$url = $_POST['url'];
		$username = $_POST['username'];
		$type = $_POST['type'];
		$password = $_POST['password'];
		
		if(!empty($title) && !empty($url) && !empty($username) && !empty($type) && !empty($password)){
			$sql = "INSERT INTO pasman (id, title, url, username, type, password) VALUES (".$id.",'".$title."','".$url."','".$username."','".$type."','".$password."')";
			$simpan = mysqli_query($koneksi, $sql);
			if($simpan && isset($_GET['aksi'])){
				if($_GET['aksi'] == 'create'){
					header('location: index.php');
				}
			}
		} else {
			$pesan = "Tidak dapat menyimpan, data belum lengkap!";
		}
	}

	?> 
		<form action="" method="POST">
			<div class="container">
				<h2>Tambah data</h2>
				<div class="form-group"><label>Title</label><input class="form-control" type="text" name="title" /></div>
				<div class="form-group"><label>URL</label><input class="form-control" type="text" name="url" /></div>
				<div class="form-group"><label>Username</label><input class="form-control" type="text" name="username" /></div>
				<div class="form-group"><label>Type</label><select class="form-control" type="text" name="type" />
					<option value="Name of User">Name of User</option>
					<option value="Email Address">Email Address</option>
					<option value="ID Number">ID Number</option>
				</select></div>
				<div class="form-group"><label>Password</label><input class="form-control" type="password" name="password" /></div>
				<br>
				<div class="form-group"><label>
					<input class="btn btn-primary" type="submit" name="btn_simpan" value="Save"/>
					<input class="btn btn-primary" type="reset" name="reset" value="Reset"/>
				</label></div>
				<br>
				<p><?php echo isset($pesan) ? $pesan : "" ?></p>
			</div>
		</form>
	<?php

}
// --- Tutup Fngsi tambah data


// --- Fungsi Baca Data (Read)
function tampil_data($koneksi){
	$sql = "SELECT * FROM pasman";
	$query = mysqli_query($koneksi, $sql);
	
	echo "<div class='table-responsive container'>";
	echo "<h2>Password Management Official</h2>";
	
	echo "<table class='table table-hover'>";
	echo "<tr>
			<th>#</th>
			<th>Title</th>
			<th>URL</th>
			<th>Username</th>
			<th>Type</th>
			<th>Password</th>
			<th>Action</th>
		  </tr>";
	
	while($data = mysqli_fetch_array($query)){
		?>
			<tr>
				<td><?php echo $data['id']; ?></td>
				<td><?php echo $data['title']; ?></td>
				<td><a href="<?php echo $data['url']; ?>"><?php echo $data['url']; ?></a></td>
				<td class="table-primary"><?php echo $data['username']; ?></td>
				<td><?php echo $data['type']; ?></td>
				<td class="table-primary"><?php echo $data['password']; ?></td>
				<td>
					<a href="index.php?aksi=update&id=<?php echo $data['id']; ?>&title=<?php echo $data['title']; ?>&url=<?php echo $data['url']; ?>&username=<?php echo $data['username']; ?>&type=<?php echo $data['type']; ?>&password=<?php echo $data['password']; ?>">Ubah</a> |
					<a href="index.php?aksi=delete&id=<?php echo $data['id']; ?>">Hapus</a>
				</td>
			</tr>
		<?php
	}
	echo "</table>";
	echo "</div>";
}
// --- Tutup Fungsi Baca Data (Read)


// --- Fungsi Ubah Data (Update)
function ubah($koneksi){

	// ubah data
	if(isset($_POST['btn_ubah'])){
		$id = $_POST['id'];
		$title = $_POST['title'];
		$url = $_POST['url'];
		$username = $_POST['username'];
		$type = $_POST['type'];
		$password = $_POST['password'];
		
		if(!empty($title) && !empty($url) && !empty($username) && !empty($type) && !empty($password)){
			$perubahan = "title='".$title."',url='".$url."',username='".$username."',type='".$type."',password='".$password."'";
			$sql_update = "UPDATE pasman SET ".$perubahan." WHERE id=$id";
			$update = mysqli_query($koneksi, $sql_update);
			if($update && isset($_GET['aksi'])){
				if($_GET['aksi'] == 'update'){
					header('location: index.php');
				}
			}
		} else {
			$pesan = "Data tidak lengkap!";
		}
	}
	
	// tampilkan form ubah
	if(isset($_GET['id'])){
		?>
			<a class="btn btn-info" href="index.php"> &laquo; Dashboard</a> | 
			<a class="btn btn-info" href="index.php?aksi=create">Add Data Access</a>
			<hr>
			
			<form action="" method="POST">
			<div class="container">
				<h2>Update Information Access</h2>
				<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/>
				<div class="form-group"><label>Title</label><input class="form-control" type="text" name="title" value="<?php echo $_GET['title'] ?>"/></div>
				<div class="form-group"><label>URL</label><input class="form-control" type="text" name="url" value="<?php echo $_GET['url'] ?>"/></div>
				<div class="form-group"><label>Username</label><input class="form-control" type="text" name="username" value="<?php echo $_GET['username'] ?>"/></div>
				<div class="form-group"><label>Type</label><select class="form-control" type="text" name="type" value="<?php echo $_GET['type'] ?>"/>
					<option value="Name of User">Name of User</option>
					<option value="Email Address">Email Address</option>
					<option value="ID Number">ID Number</option>
				</select></div>
				<div class="form-group"><label>Password</label><input class="form-control" type="password" name="password" value="<?php echo $_GET['password'] ?>"/></div>
				<br>
				<label>
					<input class="btn btn-primary" type="submit" name="btn_ubah" value="Simpan Perubahan"/> or <a href="index.php?aksi=delete&id=<?php echo $_GET['id'] ?>" class="btn btn-primary" value="Delete">Deleted</a>
				</label>
				<br>
				<p><?php echo isset($pesan) ? $pesan : "" ?></p>
				
			</div>
			</form>
		<?php
	}
	
}
// --- Tutup Fungsi Update

// --- Fungsi Delete
function hapus($koneksi){

	if(isset($_GET['id']) && isset($_GET['aksi'])){
		$id = $_GET['id'];
		$sql_hapus = "DELETE FROM pasman WHERE id=" . $id;
		$hapus = mysqli_query($koneksi, $sql_hapus);
		
		if($hapus){
			if($_GET['aksi'] == 'delete'){
				header('location: index.php');
			}
		}
	}
	
}
// --- Tutup Fungsi Hapus
// ===================================================================
// --- Program Utama
if (isset($_GET['aksi'])){
	switch($_GET['aksi']){
		case "create":
			echo '<a href="index.php"> &laquo; Home</a>';
			tambah($koneksi);
			break;
		case "read":
			tampil_data($koneksi);
			break;
		case "update":
			ubah($koneksi);
			tampil_data($koneksi);
			break;
		case "delete":
			hapus($koneksi);
			break;
		default:
			echo "<h3>Aksi <i>".$_GET['aksi']."</i> tidaka ada!</h3>";
			tambah($koneksi);
			tampil_data($koneksi);
	}
} else {
	tambah($koneksi);
	tampil_data($koneksi);
}

?>
</body>
</html>
