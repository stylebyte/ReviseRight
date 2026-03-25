<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $subject_name = $_POST['subject_name'];
    $weightage = $_POST['weight'];

    $sql = "INSERT INTO subjects (user_id, subject_name, weightage)
            VALUES ('$user_id', '$subject_name', '$weightage')";

    if ($conn->query($sql) === TRUE) {
        $success = "Subject added successfully!";
    } else {
        $error = "Error adding subject.";
    }
}

// Fetch subjects for this user
$result = $conn->query("SELECT * FROM subjects WHERE user_id='$user_id'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReviseRight - Subjects</title>
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

                <h3 class="fw-bold mb-4" style="color:rgb(15, 0, 66);">Add Subjects</h3>

                <?php
                if (isset($success)) {
                    echo "<div class='alert alert-success'>$success</div>";
                }
                if (isset($error)) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
                ?>

                <form method="POST">

                    <div class="mb-4">
                        <label class="form-label fw-semibold">SUBJECT NAME</label>
                        <input type="text" name="subject_name" class="form-control form-control-lg"
                               placeholder="Subject name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Priority (1 = Low, 5 = High)</label>
                        <select class="form-select" name="weight" required>
                            <option value="">--Select Priority--</option>
                            <option value="1">1 - Very Low</option>
                            <option value="2">2 - Low</option>
                            <option value="3">3 - Medium</option>
                            <option value="4">4 - High</option>
                            <option value="5">5 - Very High</option>
                        </select>
                    </div>

                    <button type="submit" class="btn px-4 py-2 fw-semibold"
                            style="background-color:rgb(15, 0, 66);color:azure;">
                        Add Subject
                    </button>

                </form>

                <hr class="my-4">

                <h5>Your Subjects:</h5>

                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='border p-2 mb-2 rounded'>
                                <strong>{$row['subject_name']}</strong>
                                (Priority: {$row['weightage']})
                              </div>";
                    }
                } else {
                    echo "<p>No subjects added yet.</p>";
                }
                ?>

            </div>
        </div>
    </div>
</div>
<div style="text-align:center; margin-top:20px;">
    <a href="topic.php">
        <button style="
            padding:12px 25px;
            font-size:18px;
            background-color:rgb(15, 0, 66);
            color:azure;
            border:none;
            border-radius:6px;
            cursor:pointer;
        ">
            Go to Topics
        </button>
    </a>
</div>
</body>
</html>