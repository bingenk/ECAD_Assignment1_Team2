<?php
include("header.php");
include_once("mysql_conn.php");

// Check if the user is logged in
if (!isset($_SESSION['ShopperID'])) {
    header('Location: login.php'); // Redirect to login page
    exit;
}

$shopperId = $_SESSION['ShopperID'];
$updatePassword = false; // Initialize the variable
$error_message = ""; // Initialize error message variable
$email_error_message = ""; 

// Fetch current user data
$query = "SELECT * FROM Shopper WHERE ShopperID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $shopperId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    echo "User data not found.";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract posted data
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $password_old = $_POST['password_old'];
    $password_new = $_POST['password_new'];

    // Check if the old password field is not empty
    if (!empty($password_old)) {
         // Check if the old password is correct
        if (!password_verify($password_old, $userData['Password'])) {
            $error_message = "Incorrect old password. Please try again.";            
        } else {
            $updatePassword = true;
        }
    }

    // Validate email uniqueness
    if ($email != $userData['Email']) {
        $checkEmailQuery = "SELECT Email FROM Shopper WHERE Email = ?";
        $checkStmt = $conn->prepare($checkEmailQuery);
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        if ($checkResult->num_rows > 0) {
            $email_error_message = "This email is already registered. Please use a different email.";            
        }
    }

    // Prepare the update query
    if ($updatePassword && !empty($password_new)) {
        // Update query including password
        $updateQuery = "UPDATE Shopper SET Name = ?, BirthDate = ?, Email = ?, Phone = ?, Address = ?, Country = ?, Password = ? WHERE ShopperID = ?";
        $passwordHash = password_hash($password_new, PASSWORD_DEFAULT);
    } else {
        // Update query without changing password
        $updateQuery = "UPDATE Shopper SET Name = ?, BirthDate = ?, Email = ?, Phone = ?, Address = ?, Country = ? WHERE ShopperID = ?";
    }

    $updateStmt = $conn->prepare($updateQuery);

    // Bind parameters based on whether password is being updated
    if ($updatePassword && !empty($password_new)) {
        $updateStmt->bind_param("sssssssi", $name, $dob, $email, $phone, $address, $country, $passwordHash, $shopperId);
    } else {
        $updateStmt->bind_param("ssssssi", $name, $dob, $email, $phone, $address, $country, $shopperId);
    }

    if (empty($error_message) && empty($email_error_message)) {
      if ($updateStmt->execute()) {
        if ($updateStmt->affected_rows > 0) {
            $_SESSION['profile_updated'] = true;  
  
          echo "<script type='text/javascript'>
                  alert('Profile updated successfully.');
                  window.location = 'index.php';
                </script>";
          exit;
        }      
      } else {        
          $error_message = "There was an error updating your profile. Please try again later.";        
      }
    }    
}

// Fetch current user data
$query = "SELECT * FROM Shopper WHERE ShopperID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $shopperId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    echo "User data not found.";
    exit;
}
?>

<div class="container">
  <h4 class="header_update">Update Profile</h4>
  <div class="settings-container">
    <div class="sidebar">
      <div class="sidebar-links">
        <a href="#account-general" class="sidebar-link active">Account Information</a>
      </div>
    </div>
    <div class="update_content">
      <div id="account-general" class="tab-content active">
        <form class="form-settings" method="post">
          <label for="username">Name</label>
          <input type="text" id="name_update" name="name" value="<?php echo htmlspecialchars($userData['Name']); ?>" />

          <label for="dob">Date of Birth</label>
          <input type="date" id="dob_update" name="dob" value="<?php echo htmlspecialchars($userData['BirthDate']); ?>" />

          <label for="email">Email</label>
          <input type="email" id="email_update" name="email" value="<?php echo htmlspecialchars($userData['Email']); ?>" />          

          <?php if (!empty($email_error_message)): ?>
            <div class="error-message" style="color: red;"><?php echo $email_error_message; ?></div>
          <?php endif; ?>

          <label for="phone">Phone No.</label>
          <input type="tel" id="phoneNo_update" name="phone" value="<?php echo htmlspecialchars($userData['Phone']); ?>" />  

          <label for="address">Address</label>
          <input type="text" id="address_update" name="address" value="<?php echo htmlspecialchars($userData['Address']); ?>" />

          <label for="country">Country</label>
          <input type="text" id="country_update" name="country" value="<?php echo htmlspecialchars($userData['Country']); ?>" />

          <label for="password_old">Old Password</label>
          <input type="password" id="password_old_update" name="password_old" placeholder="Old Password"/>

          <div id="errorMessage" style="color:red;">
              <?php if (!empty($error_message)): ?>
                  <div class="error-message"><?php echo $error_message; ?></div>
              <?php endif; ?>
          </div>

          <label for="password_new">New Password</label>
          <input type="password" id="password_new_update" name="password_new" placeholder="New Password"/>
          
          <?php if (!empty($info_message)): ?>
              <div class="info-message" style="color: blue;"><?php echo $info_message; ?></div>
          <?php endif; ?>

          <button type="submit" class="btn_update btn-primary">Save changes</button>
          <button type="button" class="btn_update btn-default">Cancel</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include("footer.php"); ?>

<style>  
  .header_update {
  font-weight: bold;
  font-size: 25px;
  margin: 20px;
}

.settings-container {
  display: flex;
}

.sidebar-link {
  display: block;
  padding: 10px 15px;
  border-bottom: 1px solid #ddd;
  color: #333;
  text-decoration: none;
}

.sidebar-link.active {
  font-weight: bold;
  color: white;
  background: var(--salmon-pink);
}

.update_content {
  flex-grow: 1;
  padding: 0px 20px 20px 20px;
  border-left: none;
}

.form-settings {
  display: grid;
  grid-gap: 5px;
}

.form-settings label {
  font-weight: bold;
  font-size: 16px;
  margin-bottom: 5px;
}

.form-settings input[type="text"],
.form-settings input[type="email"],
.form-settings input[type="tel"],
.form-settings input[type="password"],
.form-settings input[type="date"] {
  width: 100%;
  padding: 8px;
  margin-bottom: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.btn_update {
  padding: 10px 15px;
  background-color: var(--salmon-pink);
  color: white;
  border-radius: 6px;
  text-align: center;
  white-space: nowrap;
  cursor: pointer;
}

.btn_update:hover {
  background-color: hsl(353, 95%, 76%);
}

</style>
