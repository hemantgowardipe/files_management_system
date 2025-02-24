<?php 
    session_start();
    include('connect.php');

    // Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $id = $_SESSION['id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $updateQuery = "UPDATE register SET name='$name', email='$email', mobile='$mobile', pass='$password' WHERE id='$id'";

    // Handle profile image upload
    if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES['photo']['name'];
        $target = "profile_img/" . basename($photo);

        // Check if the file was uploaded
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
            $updateQuery = "UPDATE register SET name='$name', email='$email', mobile='$mobile', pass='$password', photo='$photo' WHERE id='$id'";
        } else {
            echo "<script>alert('Error uploading image!');</script>";
        }
    }

    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile!');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5.0.0-beta.8/daisyui.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.0.0/dist/full.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 to-indigo-200 flex justify-center items-center min-h-screen p-4">
<?php 
        $sql = mysqli_query($con,"SELECT * FROM register WHERE id = '".$_SESSION['id']."' ");
        while($abc = mysqli_fetch_array($sql)){
    ?>
      <div id="profileCard" class="card w-full max-w-3xl bg-white shadow-2xl rounded-xl p-6 sm:p-8">
        <!-- Close button -->
    <button onclick="window.history.back();" class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full hover:bg-red-600">
        ✕
    </button>
        <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6 border-b pb-6">
            <input type="file" id="fileInput" accept="image/*" class="hidden" onchange="loadImage(event)">
            <div class="avatar">
                <div class="w-24 sm:w-32 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                    <img id="profileImage" src="<?php echo "profile_img/" . $abc['photo']?>" alt="Profile Picture" class="cursor-pointer" onclick="openCropperModal()">
                </div>
            </div>
            <div class="text-center sm:text-left">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800"><?php echo $abc['name']?></h2>
                <p class="text-gray-400 text-sm"><?php echo $abc['email']?></p>
            </div>
        </div>

        <div class="mt-6 space-y-4">
            <div class="flex justify-between items-center bg-gray-100 p-4 rounded-lg shadow-md">
                <span class="text-gray-600 font-semibold">Phone:</span>
                <span class="text-gray-800"><?php echo $abc['mobile']?></span>
            </div>
            <div class="flex justify-between items-center bg-gray-100 p-4 rounded-lg shadow-md">
                <span class="text-gray-600 font-semibold">Password:</span>
                <span class="text-gray-800"><?php echo $abc['pass']?></span>
            </div>
            <div class="flex justify-between items-center bg-gray-100 p-4 rounded-lg shadow-md">
                <span class="text-gray-600 font-semibold">Account Created:</span>
                <span class="text-gray-800"><?php echo $abc['date']?></span>
            </div>
        </div>
        <?php 
        }
        ?>
        <div class="stats shadow mt-6">
            <div class="stat">
                <div class="stat-title" >Total Files</div>
                <div class="stat-value" id="fileCount"></div>
            </div>
            <div class="stat">
                <div class="stat-title">Total Storage Used</div>
                <div class="stat-value text-muted">15GB</div>
            </div>
        </div>
        
        <div class="mt-6 flex flex-col sm:flex-row gap-4">
            <button class="btn btn-primary flex-1" onclick="openEditModal()">Edit Profile</button>
            <button class="btn btn-error flex-1" onclick="window.location.href='logout.php'">Logout</button>
        </div>
    </div>

    <div id="editProfileModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex justify-center items-center p-4">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-lg w-full relative">
            <button class="absolute top-2 right-2 btn btn-sm btn-circle btn-error" onclick="closeEditModal()">✕</button>
            <h2 class="text-xl font-bold mb-4">Edit Profile</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="update_profile" value="1">
                <label class="block mb-2">Name</label>
                <input type="text" name="name" class="input input-bordered w-full mb-4" placeholder="John Doe">
                <label class="block mb-2">Email</label>
                <input type="email" name="email" class="input input-bordered w-full mb-4" placeholder="johndoe@example.com">
                <label class="block mb-2">Phone</label>
                <input type="tel" name="mobile" class="input input-bordered w-full mb-4" placeholder="+1 234 567 890">
                <label class="block mb-2">Password</label>
                <input type="password" name="password" class="input input-bordered w-full mb-4" placeholder="johndoe@example">
                <button type="submit" class="btn btn-primary w-full">Save Changes</button>
            </form>
        </div>
    </div>

    <div id="cropperModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex justify-center items-center p-4">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-lg w-full relative">
            <button class="absolute top-2 right-2 btn btn-sm btn-circle btn-error" onclick="closeCropperModal()">✕</button>
            <h2 class="text-xl font-bold mb-4">Crop Profile Picture</h2>
            <div class="w-full flex justify-center">
                <img id="cropperImage" class="max-w-full">
            </div>
            <div class="mt-4 flex justify-end">
                <button class="btn btn-primary" onclick="applyCrop()">Apply</button>
            </div>
        </div>
    </div>

    <script>
        let cropper;
        
        function openEditModal() {
            document.getElementById('editProfileModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editProfileModal').classList.add('hidden');
        }

        function logout() {
            alert("Logout functionality to be implemented.");
        }

        function openCropperModal() {
            document.getElementById('fileInput').click();
        }

        function loadImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('cropperImage').src = e.target.result;
                    document.getElementById('cropperModal').classList.remove('hidden');
                    if (cropper) cropper.destroy();
                    cropper = new Cropper(document.getElementById('cropperImage'), {
                        aspectRatio: 1,
                        viewMode: 1
                    });
                };
                reader.readAsDataURL(file);
            }
        }

        function closeCropperModal() {
            document.getElementById('cropperModal').classList.add('hidden');
        }

        function applyCrop() {
    if (cropper) {
        cropper.getCroppedCanvas().toBlob((blob) => {
            const formData = new FormData();
            formData.append("croppedImage", blob, "profile_" + Date.now() + ".png");

            // Send the cropped image to the backend
            fetch("upload_cropped_image.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('profileImage').src = "profile_img/" + data.filename;
                    closeCropperModal();
                } else {
                    alert("Error uploading cropped image!");
                }
            })
            .catch(error => console.error("Error:", error));
        }, "image/png");
    }
}

    </script>
    <!-- Total file count script -->
    <script>
        function fetchFileCount() {
            $.ajax({
                url: 'get_file_count.php',
                type: 'GET',
                success: function(response) {
                    let fileCount = parseInt(response);
                    $("#fileCount").text(fileCount);

                    // Assuming max 100 files as full storage for example
                    let percentage = (fileCount / 100) * 100;
                    $("#fileProgressBar").css("width", percentage + "%");
                }
        });
}
fetchFileCount();

    </script>
    <!-- Total storage script -->
    <script>
        function fetchStorageUsage() {
    $.ajax({
        url: 'get_total_storage.php',
        type: 'GET',
        success: function(response) {
            let totalStorageUsedMB = parseFloat(response); // Convert response to a number
            if (isNaN(totalStorageUsedMB)) totalStorageUsedMB = 0; // Handle NaN case

            let maxStorageMB = 10240; // 10GB = 10240MB
            let percentage = (totalStorageUsedMB / maxStorageMB) * 100;

            // Update storage usage text
            $(".text-muted").text(totalStorageUsedMB.toFixed(2) + "MB");
        }
    });
}

// Fetch storage usage on page load
fetchStorageUsage();
    </script>
</body>
</html>
