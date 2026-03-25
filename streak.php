<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$today = date("Y-m-d");
$current_streak = 0;
$last_active = NULL;

$result = $conn->query("SELECT * FROM streaks WHERE user_id='$user_id'");
$row = $result->fetch_assoc();

if (!$row) {

    $conn->query("INSERT INTO streaks (user_id, current_streak, last_active_date)
                  VALUES ('$user_id', 0, CURDATE())");

} else {

    $current_streak = $row['current_streak'];
    $last_active = $row['last_active_date'];

}

/* When user clicks "I Studied Today" */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $yesterday = date("Y-m-d", strtotime("-1 day"));

    if ($last_active == $today) {
        // already counted today
    }
    elseif ($last_active == $yesterday) {
        $current_streak++;
    }
    else {
        $current_streak = 1;
    }

    $conn->query("UPDATE streaks
                  SET current_streak='$current_streak',
                      last_active_date='$today'
                  WHERE user_id='$user_id'");

    header("Location: streak.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ReviseRight - Study Streak</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="head position-relative d-flex align-items-center p-3" style="background:lightblue;">
    <img src="favicon.png" class="img-fluid me-4" style="width:150px;">
    <div class="position-absolute top-50 start-50 translate-middle text-center">
        <h2 class="mb-0">Welcome To RightRevise</h2>
        <p class="mb-0">Revise smart. Stay consistent.</p>
    </div>
</div>

<div class="container py-5">
<div class="row justify-content-center">
<div class="col-12 col-md-8 col-lg-6">

<div class="bg-white p-4 p-md-5 rounded shadow-sm text-center">

<h3 class="fw-bold mb-4" style="color:rgb(15,0,66);">Study Streak</h3>

<h1 class="display-4 text-success">
<?php echo $current_streak; ?> 🔥
</h1>

<p class="mb-4">Keep studying daily to maintain your streak!</p>

<form method="POST">
<button type="submit" class="btn px-4 py-2 fw-semibold"
style="background-color:rgb(15,0,66);color:white;">
I Studied Today
</button>
</form>

</div>

</div>
</div>
</div>

<div style="text-align:center; margin-top:20px;">
<a href="study.php">
<button style="
padding:12px 25px;
font-size:18px;
background-color:rgb(15,0,66);
color:white;
border:none;
border-radius:6px;
cursor:pointer;
">
Home
</button>
</a>
</div>

</body>
</html>