<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$date = date("Y-m-d");

// Check if today's revision plan already exists
$check_sql = "SELECT * FROM daily_revision 
              WHERE user_id='$user_id' AND revision_date='$date'";
$check_result = $conn->query($check_sql);

if ($check_result->num_rows == 0) {

    // Get 4 topics based on priority (weak topics first, then others)
    $topic_sql = "SELECT id FROM topics 
                  ORDER BY is_weak DESC, difficulty DESC, RAND()
                  LIMIT 4";

    $topic_result = $conn->query($topic_sql);

    while ($topic = $topic_result->fetch_assoc()) {

        $topic_id = $topic['id'];

        $insert_sql = "INSERT INTO daily_revision 
                       (user_id, topic_id, revision_date, status)
                       VALUES ('$user_id', '$topic_id', '$date', 'Pending')";

        $conn->query($insert_sql);
    }
}

$sql = "SELECT topics.id, topics.topic_name, daily_revision.status 
        FROM daily_revision
        JOIN topics ON daily_revision.topic_id = topics.id
        WHERE daily_revision.user_id = '$user_id'
        AND daily_revision.revision_date = '$date'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReviseRight - Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="head position-relative d-flex align-items-center p-3" style=" background:lightblue;">
        <img src="favicon.png" class="img-fuild me-4" style="width :150px; height: auto;">
        <div class="position-absolute top-50 start-50 translate-middle text-center me-5" style="color:rgb(15, 0, 66);">
            <h2 class="mb-0">Welcome To RightRevise</h2>
            <p class="mb-0">Revise smart. Stay consistent.</p>
        </div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="bg-white p-4 p-md-5 rounded shadow-sm">

                    <h3 class="fw-bold mb-4" style="color:rgb(15, 0, 66);">Today's Revision Plan</h3>

                    

                        <?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="mb-3 p-3 border rounded">
            <strong><?php echo $row['topic_name']; ?></strong><br>
            Status: <?php echo $row['status']; ?>

            <?php if ($row['status'] == "Pending") { ?>
                <form action="mark_revised.php" method="POST" class="mt-2">
                    <input type="hidden" name="topic_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="btn btn-sm"
                        style="background-color:rgb(15, 0, 66);color:azure;">
                        Mark as Revised
                    </button>
                </form>
            <?php } ?>
        </div>
        <?php
    }
} else {
    echo "<p>No revision generated for today.</p>";
}
?>

                   

                </div>
            </div>
        </div>
    </div>

</body>

</html>