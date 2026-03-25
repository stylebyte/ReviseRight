<?php
session_start();
include "config.php";

$user_id = $_SESSION['user_id'];
$today = date("Y-m-d");

$query = "SELECT * FROM streaks WHERE user_id='$user_id'";
$result = $conn->query($query);

$data = $result->fetch_assoc();

$current_streak = $data['current_streak'];
$last_active = $data['last_active_date'];

if ($last_active == date("Y-m-d", strtotime("-1 day")) || $last_active == $today) {

    if ($last_active != $today) {
        $current_streak++;
    }

} else {

    $current_streak = 1;

}

$conn->query("UPDATE streaks
              SET current_streak='$current_streak',
              last_active_date='$today'
              WHERE user_id='$user_id'");
?>