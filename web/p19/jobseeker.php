<!-- jobseeker.php -->
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

// Job Search
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
  $skills = $_POST["skills"];
  $city = $_POST["city"];
  $title = $_POST["title"];

  $sql = "SELECT * FROM jobs WHERE city= '$city' AND skills like '%$skills%' AND title like '%$title%'";

  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    echo "<h2>Search Results</h2>";
    while($row = mysqli_fetch_assoc($result)) {
      echo "Job Title: " . $row["title"] . ", City: " . $row["city"] . ", Skills: " . $row["skills"] . "<br>";
    }
  } else {
    echo "No results found";
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

// Job Seeker Registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $sql = "INSERT INTO users (username, password, user_type) VALUES ('$username', '$password', 'job_seeker')";

  if (mysqli_query($conn, $sql)) {
    echo "Registration successful!";
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
    <title>Job Seeker Page</title>
</head>
<body>
    <h1>Job Seeker Page</h1>
    <p>Welcome to the Job Seeker page!</p>
    
    <!-- Job Search Form -->
    <form action="" method="post">
        <h2>Job Search</h2>
        <label for="skills">Skill: </label>
        <input type="text" name="skills">
        <br>
        <label for="city">City: </label>
        <input type="text" name="city">
        <br>
        <label for="title">Job Title: </label>
        <input type="text" name="title">
        <br>
        <input type="submit" name="search" value="Search Jobs">
    </form>

    <!-- Job Seeker Registration Form -->
    <form action="" method="post">
        <h2>Job Seeker Registration</h2>
        <label for="username">Username: </label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password: </label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" name="register" value="Register">
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

    <p>Go to <a href="jobprovider.php">Job Provider Page</a></p>
</body>
</html>
