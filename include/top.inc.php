<?php
session_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


// Utils::prettyPrint("SELECT * FROM Seemus.tbTable;");


function redirectJS($newActivity,$redirReason,$otherParams="") {
  echo("<script>window.location='index.php?activity=".$newActivity."&reason=".$redirReason."&".$otherParams."';</script>");
  return true;
}

function formRequest($formName) {
  if(isset($_REQUEST[$formName])) {
    return $_REQUEST[$formName];
  } else {
    return "";
  }
}

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
