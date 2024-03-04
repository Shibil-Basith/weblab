<!-- jobprovider.php -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobdb";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Job Provider Registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $job_title = $_POST["job_title"];
  $city = $_POST["city"];
  $skills = $_POST["skills"];

  // Insert job provider details
  $sql = "INSERT INTO users (username, password, user_type) VALUES ('$username', '$password', 'job_provider')";

  if (mysqli_query($conn, $sql)) {
    // Insert job details
    $job_sql = "INSERT INTO jobs (title, city, skills) VALUES ('$job_title', '$city', '$skills')";

    if (mysqli_query($conn, $job_sql)) {
      echo "Registration successful!";
    } else {
      echo "Error: " . $job_sql . "<br>" . mysqli_error($conn);
    }
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}

// User Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
  $username = $_POST["username"];
  $new_password = $_POST["new_password"];

  $sql = "UPDATE users SET password = '$new_password' WHERE username = '$username'";

  if (mysqli_query($conn, $sql)) {
    if(mysqli_affected_rows($conn) > 0){
      echo "User updated successfully!";
    } else {
      echo "No user found with that username.";
    }
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}

// User Deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
  $username = $_POST["username"];

  $sql = "DELETE FROM users WHERE username = '$username'";

  if (mysqli_query($conn, $sql)) {
    if (mysqli_affected_rows($conn) > 0) {
      echo "User deleted successfully!";
    } else {
      echo "No user found with that username.";
    }
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Provider Page</title>
</head>
<body>
    <h1>Job Provider Page</h1>
    <p>Welcome to the Job Provider page!</p>

    <!-- Job Registration Form -->
    <form action="" method="post">
        <h2>Job Registration</h2>
        <label for="username">Username: </label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password: </label>
        <input type="password" name="password" required>
        <br>
        <label for="job_title">Job Title: </label>
        <input type="text" name="job_title">
        <br>
        <label for="city">City: </label>
        <input type="text" name="city">
        <br>
        <label for="skills">Skills: </label>
        <input type="text" name="skills">
        <br>
        <input type="submit" name="register" value="Register Job">
    </form>

    <!-- Update Form -->
    <form action="" method="post">
        <h2>Update User</h2>
        <label for="username">Username: </label>
        <input type="text" name="username" required>
        <br>
        <label for="new_password">New Password: </label>
        <input type="password" name="new_password" required>
        <br>
        <input type="submit" name="update" value="Update User">
    </form>

    <!-- Delete Form -->
    <form action="" method="post">
        <h2>Delete User</h2>
        <label for="username">Username: </label>
        <input type="text" name="username" required>
        <br>
        <input type="submit" name="delete" value="Delete User">
    </form>

    <p>Go to <a href="jobseeker.php">Job Seeker Page</a></p>
</body>
</html>
