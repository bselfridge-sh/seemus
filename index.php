<?php
include "include/top.inc.php";
include "class/Utils.class.php";

$activity = formRequest("activity");

?>
<html>
    <head><title>Seemus</title></head>
    <body>
        <a href="index.php?activity=USER">LOGON</a> | 
        <a href="index.php?activity=USER-LOGOFF">LOGOFF</a> | 
        <br><br>
        <?php
            if(formRequest("reason")=="") {
                echo "<br>";
            } else {
                echo "<em>" . formRequest("reason") . "</em><br>";
            }
        ?>
        <br>
        <?php
        switch($activity) {
            case "USER": // User Logon
                if(formRequest("email") == "") {
                    if(formRequest("reason")!="") {
                        
                    }
                    ?>
                    <form action="index.php" method=post >
                        <input type="hidden" name="activity" value="USER" />
                        <input type="text" name="email" placeholder="Email" />
                        <input type="text" name="password" placeholder="Password" />
                        <input type="submit" value="Logon" />
                    </form>
                    <?php

                } else {
                    $stmt = $conn->prepare("SELECT * FROM tbUsers WHERE fdEmail='".formRequest("email")."'");
                    $stmt->execute();
                    $result = $stmt->fetchAll();

                    if($result) {
                        foreach($result as $row) {
                            $dbPassword     = $row["fdPassword"];
                            $formPassword = formRequest("password");

                            if( password_verify($formPassword,$dbPassword) ) {
                                $_SESSION["FullName"]   = $row["fdFullName"];
                                $_SESSION["Email"]      = $row["fdEmail"];
                                $_SESSION["Admin"]      = $row["fdAdmin"];
                            } else {
                                echo('<script>window.location=\'index.php?activity=USER&reason=Bad+Username+or+Password\';</script>');
                            }
                        }
                    } else {
                        echo('<script>window.location=\'index.php?activity=USER&reason=Bad+Username+or+Password\';</script>');
                    }
                }
            break;

            case "USER-LOGOFF":
                // User Logout
                
            break;

            case "VIEW":
                // View List of Content
                
            break;

            case "EDIT":
                // User Edit
                
            break;

            case "DELETE":
                // User Delete
                
            break;

            case "CREATE":
                // Create Content
                
            break;

            default:
                //default viewing of content
            break;
        }
        ?>
<?php
include "include/bottom.inc.php";
?>
