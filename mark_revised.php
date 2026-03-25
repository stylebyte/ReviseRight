<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$topic_id = $_POST['topic_id'];
$date = date("Y-m-d");

$conn->query("UPDATE daily_revision
SET status='Revised'
WHERE topic_id='$topic_id'
AND user_id='$user_id'
AND revision_date='$date'");

header("Location: daily_revision.php");
exit();
?>