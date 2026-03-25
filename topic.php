<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Add topic
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $subject_id = $_POST['subject_id'];
    $topic_name = $_POST['topic_name'];
    $difficulty = $_POST['difficulty'];

    $sql = "INSERT INTO topics (subject_id, topic_name, difficulty)
            VALUES ('$subject_id', '$topic_name', '$difficulty')";

    if ($conn->query($sql) === TRUE) {
        $success = "Topic added successfully!";
    } else {
        $error = "Error adding topic.";
    }
}

// Fetch subjects for dropdown
$subjects = $conn->query("SELECT * FROM subjects WHERE user_id='$user_id'");

// Fetch topics for display
$topics = $conn->query("
    SELECT topics.*, subjects.subject_name 
    FROM topics 
    JOIN subjects ON topics.subject_id = subjects.id
    WHERE subjects.user_id = '$user_id'
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReviseRight - Topics</title>
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
<div class="bg-white p-4 p-md-5 rounded shadow-sm">

<h3 class="fw-bold mb-4" style="color:rgb(15, 0, 66);">Add Topics</h3>

<?php
if (isset($success)) {
    echo "<div class='alert alert-success'>$success</div>";
}
if (isset($error)) {
    echo "<div class='alert alert-danger'>$error</div>";
}
?>

<form method="POST">

<div class="mb-3">
<label class="form-label fw-semibold">Select Subject</label>
<select name="subject_id" class="form-select" required>
<option value="">--Select Subject--</option>
<?php
while ($row = $subjects->fetch_assoc()) {
    echo "<option value='{$row['id']}'>{$row['subject_name']}</option>";
}
?>
</select>
</div>

<div class="mb-4">
<label class="form-label fw-semibold">TOPIC NAME</label>
<input type="text" name="topic_name" class="form-control form-control-lg"
       placeholder="Topic name" required>
</div>

<div class="mb-3">
<select name="difficulty" class="form-select" required>
<option value="">--Select Difficulty--</option>
<option value="Easy">Easy</option>
<option value="Medium">Medium</option>
<option value="Hard">Hard</option>
</select>
</div>

<button type="submit" class="btn px-4 py-2 fw-semibold"
        style="background-color:rgb(15, 0, 66);color:azure;">
    Add Topic
</button>

</form>

<hr class="my-4">

<h5>Your Topics:</h5>

<?php
if ($topics->num_rows > 0) {
    while ($row = $topics->fetch_assoc()) {
        echo "<div class='border p-2 mb-2 rounded'>
                <strong>{$row['topic_name']}</strong>
                ({$row['subject_name']}) - {$row['difficulty']}
              </div>";
    }
} else {
    echo "<p>No topics added yet.</p>";
}
?>

</div>
</div>
</div>
</div>
<div style="text-align:center; margin-top:20px;">
    <a href="daily_revision.php">
        <button style="
            padding:12px 25px;
            font-size:18px;
            background-color:rgb(15, 0, 66);
            color:azure;
            border:none;
            border-radius:6px;
            cursor:pointer;
        ">
            Go to Daily Plan
        </button>
    </a>
</div>
</body>
</html>