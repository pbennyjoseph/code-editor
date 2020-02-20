<?php
    session_start();
    require_once('./shrd/config.php');
    if(!isset($_SESSION['message'])) die("403 Forbidden.");
    if(isset($_POST['src'])){
        $connection = new mysqli(DB_HOST,DB_USER,DB_PASSWD,DB_DATABASE);
        $jsslug = $_POST['slug'];
        $jskey = $_POST['key'];
        $src = $_POST['src'];
        $params = $_POST['params'];
        // Check connection
        if ($connection -> connect_errno) {
            echo "Failed to connect to MySQL: " . $connection -> connect_error;
            exit();
        }
        $check = "SELECT * FROM mapping WHERE slug='$jsslug' and editkey='$jskey'";
        $result = $connection->query($check);
		// echo $result->num_rows;
		if($result->num_rows == 0) die("Incorrect Key");
        
        $sql = "UPDATE mapping SET src='$src',params='$params' WHERE slug='$jsslug'";
        if ($connection->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $connection->error;
        }
        $connection->close();
    }
    // exit();
?>