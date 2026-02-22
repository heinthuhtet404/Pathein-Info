<?php

$file = basename($_GET['file']);
$filepath = __DIR__ . "/Admin/uploads/" . $file;

if (!file_exists($filepath)) {
    die("File not found!");
}

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"" . $file . "\"");
header("Content-Length: " . filesize($filepath));

readfile($filepath);
exit;