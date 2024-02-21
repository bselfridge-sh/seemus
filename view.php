<?php
include "include/top.inc.php";
include "class/Utils.class.php";

$activity = formRequest("activity");

$sql = "SELECT id,fdFile, fdFilename,fdFileType,fdFileSize,fdDateTime,fdArchive FROM `tbFiles` WHERE id = " . formRequest("id");

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

// Check if $result has anything in it or not (Returns a FALSE if no data in there).
if($result) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        header("Content-Type: " . $row["fdFileType"]);
        echo $row["fdFile"];
    }
}

include "include/bottom.inc.php";
?>