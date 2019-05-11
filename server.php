<?php 
    session_start();
    require_once 'connection.php';
    //$link = mysqli_connect('localhost', 'root', '', 'crud');
    $link = mysqli_connect($host, $user, $password, $database) 
        or die("Ошибка " . mysqli_error($link)); 

	// initialize variables
	$name = "";
	$company = "";
	$id = 0;
	$update = false;

	if (isset($_POST['save'])) {
		$name = $_POST['name'];
		$company = $_POST['company'];

		mysqli_query($link, "INSERT INTO tovars (name, company) VALUES ('$name', '$company')"); 
		$_SESSION['message'] = "Address saved"; 
		header('location: index1.php');
	}


	if (isset($_POST['update'])) {
		$id = $_POST['id'];
		$name = $_POST['name'];
		$company = $_POST['company'];

		mysqli_query($link, "UPDATE tovars SET name='$name', company='$company' WHERE id=$id");
		$_SESSION['message'] = "Address updated!"; 
		header('location: index1.php');
	}

if (isset($_GET['del'])) {
	$id = $_GET['del'];
	mysqli_query($link, "DELETE FROM tovars WHERE id=$id");
	$_SESSION['message'] = "Address deleted!"; 
	header('location: index1.php');
}


	$results = mysqli_query($link, "SELECT * FROM tovars");


?>
