<?php
// Include the database connection file
require 'dbconnection.php';

// Use a try-catch block to handle exceptions
try {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (first_name, middle_name, last_name, suffix, username, birthdate, email_address, password, role, user_role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        throw new Exception('Prepare statement failed: ' . htmlspecialchars($conn->error));
    }

    $first_name = $_POST['firstName'];
    $middle_name = $_POST['middleName'];
    $last_name = $_POST['lastName'];
    $suffix = $_POST['suffix'];
    $username = $_POST['username'];
    $birthdate = $_POST['birthdate'];
    $email_address = $_POST['emailAddress'];
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $user_role = "1"; // 1 = customer, 2 = admin. That's why its always 1 because its just for customer registration

    $stmt->bind_param("ssssssssss", $first_name, $middle_name, $last_name, $suffix, $username, $birthdate, $email_address, $hashed_password, $role, $user_role);

    if ($stmt->execute() === false) {
        throw new mysqli_sql_exception($stmt->error, $stmt->errno);
    }

    // Close statement
    $stmt->close();
    // Close connection
    $conn->close();

    echo '<script>
            alert("Registration successful! You can now login.");
            window.location.href = "../login.html";
          </script>';
} catch (mysqli_sql_exception $e) {
    $error_message = htmlspecialchars($e->getMessage());
    // Check if the error is due to a duplicate entry for the username or email address
    if (strpos($error_message, "Duplicate entry ") !== false) {
        if (strpos($error_message, "for key 'username'") !== false) {
            // Display alert for duplicate username and redirect to registration page
            echo '<script>
                    alert("Error: Username already exists. Please choose a different username.");
                    window.location.href = "../register.html";
                  </script>';
        } elseif (strpos($error_message, "for key 'email_address'") !== false) {
            // Display alert for duplicate email address and redirect to registration page
            echo '<script>
                    alert("Error: Email address already exists. Please use a different email address.");
                    window.location.href = "../register.html";
                  </script>';
        } else {
            // Display general error alert and redirect to registration page
            echo '<script>
                    alert("Error: ' . $error_message . '");
                    window.location.href = "../register.html";
                  </script>';
        }
    } else {
        // Display general error alert and redirect to registration page
        echo '<script>
                alert("Duplicate: username or email address already exist!");
                window.location.href = "../register.html";
              </script>';
    }
} catch (Exception $e) {
    // Handle other types of exceptions
    echo '<script>
            alert("Error: ' . htmlspecialchars($e->getMessage()) . '");
            window.location.href = "../register.html";
          </script>';
}
?>
