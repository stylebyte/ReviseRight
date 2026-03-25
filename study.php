<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RightRevise</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="favicon.png">
</head>

<body>

    <!-- HEADER -->
    <div class="container-fluid px-0">
        <div class="d-flex align-items-center justify-content-between px-4 py-4" style="background:lightblue;">

            <div class="d-flex align-items-center p-3">
                <img src="favicon.png" class="img-fluid" style="width:150px" alt="logo">
            </div>

            <h4 class="position-absolute start-50 translate-middle-x fw-bold"
                style="color:rgb(15, 0, 66);">
                START LEARNING
            </h4>

            <!-- Navigation Buttons -->
            <div class="d-flex align-items-center gap-3">

                <a href="subject.php" class="btn px-3 py-2 fw-semibold"
                    style="background-color:rgb(15, 0, 66);color:azure;">
                    Subjects
                </a>

                <a href="topic.php" class="btn px-3 py-2 fw-semibold"
                    style="background-color:rgb(15, 0, 66);color:azure;">
                    Topics
                </a>

                <a href="daily_revision.php" class="btn px-3 py-2 fw-semibold"
                    style="background-color:rgb(15, 0, 66);color:azure;">
                    Daily Plan
                </a>

            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="container mt-5">
        <div class="row align-items-center">
            <div class="col-md-5 text-center mb-4 mb-md-0">
                <div class="border rounded-4 p-4">
                    <img src="planner.png" class="img-fluid" alt="Revision Planner">
                </div>
            </div>

            <div class="col-md-7 ps-md-5">
                <h2 class="fw-bold mb-4" style="color: rgba(1, 4, 184, 0.546)">
                    Struggling with revision?
                    <br>
                    Get a clear, personalised plan in minutes.
                </h2>

                <p class="fs-5 text-dark mb-4">
                    <strong>This Revision Planner builds a simple, effective schedule that tells you exactly what to revise — and when.</strong>
                </p>

                <!-- Quick Action Buttons -->
                <div class="d-flex flex-wrap gap-3 mt-4">

                    <a href="subject.php" class="btn btn-lg px-4 py-3 text-white"
                        style="background-color:#031c73;">
                        Add Subjects
                    </a>

                    <a href="topic.php" class="btn btn-lg px-4 py-3 text-white"
                        style="background-color:#031c73;">
                        Add Topics
                    </a>

                    <a href="daily_revision.php" class="btn btn-lg px-4 py-3 text-white"
                        style="background-color:#031c73;">
                        View Today's Plan
                    </a>

                </div>

                <p class="fw-semibold mt-4">
                    Stay consistent. Track your streak. Improve daily.
                </p>
            </div>
        </div>
    </div>

</body>
</html>