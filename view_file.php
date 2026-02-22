<?php

if(isset($_GET['file'])){

    $file = $_GET['file'];   // uploads/filename.pdf
    $filePath = __DIR__ . "/Admin/" . $file;

    if(file_exists($filePath)){

        header("Content-Type: application/pdf");
        header("Content-Disposition: inline; filename=\"" . basename($filePath) . "\"");
        readfile($filePath);
        exit;

    } else {
        echo "File not found!";
    }

}
?>