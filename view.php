<?php
include "include/top.inc.php";
include "class/Utils.class.php";

$activity = formRequest("activity");

if($activity=="FILE") {
    $sql = "SELECT id,fdFile, fdFilename,fdFileType,fdFileSize,fdDateTime,fdArchive FROM `tbFiles` WHERE id = " . formRequest("id");

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    // Check if $result has anything in it or not (Returns a FALSE if no data in there).
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ob_clean();
            header("Content-Type: " . $row["fdFileType"]);
            echo $row["fdFile"];
        }
} else {
    $sql = "SELECT id,fdContent,fdTitle FROM `tbContent` WHERE id = " . formRequest("id");

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    // Check if $result has anything in it or not (Returns a FALSE if no data in there).
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ob_clean();
            ?>
            <html>
                <head>
                    <title><?php echo $row["fdTitle"]; ?></title>
                    <link rel="stylesheet" href="include/seemus.css">
                </head>
                <body>
                    <?php
                    echo $row["fdContent"];
                    ?>
                </body>
            </html>
            <?php
        }

}
?>