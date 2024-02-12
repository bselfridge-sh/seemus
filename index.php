<?php
include "include/top.inc.php";

include "class/Utils.class.php";

// Utils::prettyPrint("SELECT * FROM Seemus.tbTable;");

$activity = formRequest("activity");

?>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <a href="index.php?activity=USER">LOGON</a>
        
        <?php
        switch($activity) {
            case "USER":
                echo "issett: ".isset($_REQUEST["username"]) . "<BR>";
                echo "formreq: ".formRequest("username") . "<BR>";

                // User Logon
                if(!isset($_REQUEST["username"])) {
                    ?>
                    <form action="index.php" method=post >
                        <input type="hidden" name="activity" value="USER" />
                        <input type="text" name="email" placeholder="Username / Email" />
                        <input type="text" name="password" placeholder="Password" />
                        <input type="submit" value="Logon" />
                    </form>
                    <?php
                } else {
                    echo $_REQUEST["email"] . ": " . password_hash($_REQUEST["password"],NULL) . " is logged on";
                }
            break;

            case "LOGOUT":
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
    </body>
</html>
<?php
include "include/bottom.inc.php";
?>
