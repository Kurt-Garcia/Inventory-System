<?php
include('connect.php');
$target_dir    = "C:/xampp/htdocs/engineering/Attachments/";
$target_file   = $target_dir . basename($_FILES["attachment_closed"]["name"]);
$uploadOk      = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
if (isset($_POST["submit"])) {
    $check = filesize($_FILES["attachment_closed"]["tmp_name"]);
    if ($check !== false) {
        echo "File is zip - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "<script>alert('Sorry, file not valid.');window.location.href='/engineering/user_reqlist.php';</script>";
        $uploadOk = 0;
    }
}
if (file_exists($target_file)) {
    echo "<script>alert('Sorry, filename already exists.');window.location.href='/engineering/user_reqlist.php';</script>";
    $uploadOk = 0;
}
if ($_FILES["attachment_closed"]["size"] > 5000000) {
    echo "<script>alert('Sorry, your file is too large.');window.location.href='/engineering/user_reqlist.php';</script>";
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo "<script>alert('Sorry, your file was not uploaded.');window.location.href='/engineering/user_reqlist.php';</script>";
} else {
    if (move_uploaded_file($_FILES["attachment_closed"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["attachment_closed"]["name"]) . " has been uploaded.";
    } else {
        echo "<script>alert('Sorry, there was an error uploading your file.');window.location.href='/engineering/user_reqlist.php';</script>";
    }
    $attachment_closed = basename($_FILES['attachment_closed']['name']);
    $date_finished  = $_POST['date_finished'];
    $status     =  $_POST['status'];
    $req_no = $_POST['req_no'];
    $query      = "UPDATE tbl_requests SET attachment_closed = '$attachment_closed', status = '$status', date_finished = '$date_finished' WHERE req_no = '$req_no'";
    $result     = odbc_exec($connect, $query);
    if (!$result) {
        echo "<script>alert('Failed to save data.');window.location.href='/engineering/user_reqlist.php';</script>";
    } elseif ($result) {
        header('location: /engineering/user_reqlist.php');
    }
}
?>