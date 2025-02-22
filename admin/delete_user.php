<?php
session_start();
include('connect.php'); // Ensure you have database connection

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $userId = intval($_POST["id"]);

    // Delete user query
    $deleteQuery = "DELETE FROM register WHERE id = ?";
    $stmt = mysqli_prepare($con, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "i", $userId);

    if (mysqli_stmt_execute($stmt)) {
        echo "success"; // Return success message to AJAX
    } else {
        echo "error";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    echo "invalid";
}
?>
