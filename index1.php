<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>



<?php
require_once 'connection.php'; // подключаем скрипт
// подключаемся к серверу
$link = mysqli_connect($host, $user, $password, $database) 
        or die("Ошибка " . mysqli_error($link)); 



//include('server.php');
	if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$update = true;
		$record = mysqli_query($link, "SELECT * FROM tovars WHERE id=$id");

		if (count($record) == 1 ) {
			$n = mysqli_fetch_array($record);
			$name = $n['name'];
			$company = $n['company'];
		}

	}







     
// если запрос POST 
if(isset($_POST['name']) && isset($_POST['company']) && isset($_POST['id'])){
 
    $id = htmlentities(mysqli_real_escape_string($link, $_POST['id']));
    $name = htmlentities(mysqli_real_escape_string($link, $_POST['name']));
    $company = htmlentities(mysqli_real_escape_string($link, $_POST['company']));
     
    $query ="UPDATE tovars SET name='$name', company='$company' WHERE id='$id'";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
 
    if($result)
        echo "<span style='color:blue;'>Данные обновлены</span>";
}


$query2 ="SELECT * FROM tovars";
 
$result2 = mysqli_query($link, $query2) or die("Ошибка " . mysqli_error($link)); 
if($result2)
{
    $rows2 = mysqli_num_rows($result2); // количество полученных строк
     

    echo "<table><thead><tr><th>Id</th><th>Model</th><th>Producer</th><th colspan='2'>Action</th> </tr></thead>";
//echo "<table><tr><th>Id</th><th>Модель</th><th>Company</th><th colspan='2'>Action</th> </tr>";   
 for ($i = 0 ; $i < $rows2 ; ++$i)
    {
        $row2 = mysqli_fetch_row($result2);
        $myid = $row2[0];
        $number = count($row2); 
        echo "<tr>";
  for ($j = 0 ; $j < $number ; ++$j)
{
 echo "<td>$row2[$j]</td>";
}
echo "<td><a href='index1.php?id=$myid;' class='edit_btn' >Edit</a></td>";
echo "<td><a href='server.php?del=$myid;' class='del_btn' >Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
     
    // очищаем результат
mysqli_free_result($result2);
}
 
 
?>


<?php
// если запрос GET
if(isset($_GET['id']))
{   
    $id = htmlentities(mysqli_real_escape_string($link, $_GET['id']));
     
    // создание строки запроса
    $query ="SELECT * FROM tovars WHERE id = '$id'";
 $query2 ="SELECT * FROM tovars";
$results = mysqli_query($link, $query2) or die("Ошибка " . mysqli_error($link)); 
// выполняем запрос
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
    //если в запросе более нуля строк
    if($result && mysqli_num_rows($result)>0) 
    {
        $row = mysqli_fetch_row($result); // получаем первую строку
        $name = $row[1];
        $company = $row[2];


echo "
            <form method='POST'>
            <input type='hidden' name='id' value='$id' class='input-group' />
            <div class='input-group'>
			<label>Name</label>
            <input type='text' name='name' value='$name' /></p>
		</div>
		<div class='input-group'>
                        <label>Company</label>
			<input type='text' name='company' value='$company' /></p>
		</div>
             <div class='input-group'>
			<button class='btn' type='submit' name='save' >Save</button>
		</div>
          </form>";
        mysqli_free_result($result);
    }
}








// закрываем подключение
mysqli_close($link);
?>
</body>
</html>
