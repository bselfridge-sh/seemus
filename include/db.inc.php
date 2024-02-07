<?php

  $servername = "twyxt.io";
  $username = "seemus";
  $password = "shRocks!";
  $dbname = "seemus_bob";
  
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Successful connection";
} catch(PDOException $e) {
    echo $e->getMessage();
}

?>
