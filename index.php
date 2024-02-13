<?php
include "include/top.inc.php";
include "class/Utils.class.php";

$activity = formRequest("activity");

?>
<html>
    <head><title>Seemus</title></head>
    <body>
        <div class="navigation"><a href="index.php?activity=USER">LOGON</a> | 
        <a href="index.php?activity=USER-LOGOFF">LOGOFF</a> | 
        </div>
        
        <?php
            if(!formRequest("reason")=="") {
                echo "<div class=\"reason\">" . formRequest("reason") . "</div>";
            }
        ?>
        <br>
        <?php
        switch($activity) {
            case "USER": // User Logon
                if(formRequest("email") == "") {
                    ?>
                    <form action="index.php" method=post >
                        <input type="hidden" name="activity" value="USER" />
                        <input type="text" name="email" placeholder="Email" value="<?php echo formRequest("email_last"); ?>" />
                        <input type="text" name="password" placeholder="Password" />
                        <input type="submit" value="Logon" />
                    </form>
                    <?php

                } else {
                    $stmt = $conn->prepare("SELECT * FROM tbUsers WHERE fdEmail='".formRequest("email")."'");
                    $stmt->execute();
                    $result = $stmt->fetchAll(); // Returns true/false if records exist

                    if($result) {
                        foreach($result as $row) {
                            $dbPassword     = $row["fdPassword"];
                            $formPassword = formRequest("password");

                            if( password_verify($formPassword,$dbPassword) ) {
                                $_SESSION["FullName"]   = $row["fdFullName"];
                                $_SESSION["Email"]      = $row["fdEmail"];
                                $_SESSION["Admin"]      = $row["fdAdmin"];
                            } else {
                                echo('<script>window.location=\'index.php?activity=USER&email_last='.formRequest("email").'&reason=Bad+Email+or+Bad+Password\';</script>');
                            }
                        }
                    } else {
                        echo('<script>window.location=\'index.php?activity=USER&email_last='.formRequest("email").'&reason=Wrong+Email+or+Bad+Password\';</script>');
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
