<?php
session_start();
require 'dbconnection.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Prepare and execute query
try {
    $stmt = $conn->prepare("SELECT id, password, user_role FROM users WHERE username = ?");
    if ($stmt === false) {
        throw new Exception('Prepare statement failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password, $user_role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Password is correct, start session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_role'] = $user_role;

            // Redirect based on user_role
            if ($user_role == 1) {
                // Change nyo nalang yung "window.location.href = "../customerSide.php" para ma redirect yung CUSTOMER sa proper page nya. In this case, sa customer side lang sya
                echo '<script>
                        alert("Login Successful! Welcome ' . htmlspecialchars($username) . '!");
                        window.location.href = "../homepage.php";
                      </script>';
            } elseif ($user_role == 2) {
                // Change nyo rin toh: "window.location.href = "../adminSide.php" para ma redirect yung ADMIN sa proper page nya. In this case, sa admin side sya
                echo '<script>
                        alert("Login Successful! Welcome ' . htmlspecialchars($username) . '!");
                        window.location.href = "../admin/dashboard.php";
                      </script>';
            } 
            exit();
        } else {
            echo '<script>
                    alert("Error: Invalid username or password.");
                    window.location.href = "../login.html";
                  </script>';
        }
    } else {
        echo '<script>
                alert("Error: Invalid username or password.");
                window.location.href = "../login.html";
              </script>';
    }

    // Close statement
    $stmt->close();
    // Close connection
    $conn->close();
} catch (Exception $e) {
    echo '<script>
            alert("Error: ' . htmlspecialchars($e->getMessage()) . '");
            window.location.href = "../login.html";
          </script>';
}
?>
