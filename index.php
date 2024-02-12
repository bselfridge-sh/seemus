<?php
include "include/top.php";
include "class/Utils.class.php";
// Utils::prettyPrint("SELECT * FROM Seemus.tbTable;");

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if(isset($_REQUEST["activity"])) {
    $activity = $_REQUEST["activity"];
}

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
                // User Logon
                if(!isset($_REQUEST["username"])) {
                    ?>
                    <form action="index.php?activity=USER" method=get>
                        <input type="text" name="user name" placeholder="Username / Email" />
                        <input type="submit" value="Logon" />
                    </form>
                    <?php
                } else {
                    echo $_REQUEST["username"] . " is logged on";
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
