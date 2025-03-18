<?php
require 'connect.php';

if (!isset($_GET['q'])) {
    exit;
}

$search = mysqli_real_escape_string($con, $_GET['q']);

$query = mysqli_query($con, "SELECT id, name, photo FROM register WHERE name LIKE '%$search%' LIMIT 5");

if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        // Set profile image path
        $photo = !empty($row['photo']) ? "profile_img/" . $row['photo'] : "profile_img/default.png";

        echo "<a href='#' class='list-group-item list-group-item-action d-flex align-items-center' 
                onclick=\"selectUser('{$row['id']}', '{$row['name']}', '{$photo}')\">
                <img src='$photo' class='rounded-circle me-2' width='40' height='40' 
                     style='border: 2px solid #000;'>
                {$row['name']}
              </a>";
    }
} else {
    echo "<p class='list-group-item'>No users found.</p>";
}
?>
