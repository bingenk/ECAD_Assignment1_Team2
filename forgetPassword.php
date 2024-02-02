<?php 
include("header.php"); 
include_once("mysql_conn.php"); 

$error_email = "";
$error_security = "";
$password = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $query = "SELECT PwdQuestion FROM Shopper WHERE Email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['security_question'] = $row['PwdQuestion'];
            $_SESSION['email'] = $email;
            $_SESSION['showSecurityQuestion'] = true;
        } else {
            $error_email = "Email not found. Please try again.";
            unset($_SESSION['email']);
            $_SESSION['showSecurityQuestion'] = false;            
        }
    } elseif (isset($_POST['Security_Question']) && isset($_POST['Answer'])) {
        $security_question = $_POST['Security_Question'];
        $answer = $_POST['Answer'];
        $email = $_SESSION['email'];

        $query = "SELECT * FROM Shopper WHERE Email = ? AND PwdQuestion = ? AND PwdAnswer = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $email, $security_question, $answer);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {            
            $row = $result->fetch_assoc();
            $_SESSION['retrieved_password'] = $row["Password"];     
            // Clear the email from the session after displaying the password
           
        } else {
            $error_security =  "Incorrect answer. Please try again.";
        }
    }
}
?>

<div class="container">
  <form action="#" method="post">
    <h2 class="header_forgetpassword">Forget your Password?</h2>
    <div class="input">
      <label for="email">Email Address:</label>
      <input type="email" id="email_forget" name="email" placeholder="Please enter your email" required value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>">
    </div>
    <div id="errorMessage" style="color:red; margin: 20px">
      <?php if (!empty($error_email)): ?>
        <div class="error-message"><?php echo $error_email ?></div>
      <?php endif; ?>
    </div>    
    <button type="submit" id="submit_forget">Submit</button>
  </form>

  <?php if (isset($_SESSION['showSecurityQuestion']) && $_SESSION['showSecurityQuestion']): ?>
  <form action="#" method="post">
    <div class="input-group">
      <input type="hidden" name="email_hidden" value="<?php echo htmlspecialchars($_SESSION['email']); ?>">
      <label for="Security_Question"><?php echo htmlspecialchars($_SESSION['security_question']); ?></label>
      <input type="hidden" name="Security_Question" value="<?php echo htmlspecialchars($_SESSION['security_question']); ?>">
      <input type="text" placeholder="Answer" id="Answer" name="Answer" required maxlength="50" />    
      <button type="submit" id="scr_ques">Submit Answer</button>          
    </div>    
    <div id="errorMessage" style="color:red; margin: 20px">
        <?php if (!empty($error_security)): ?>
            <div class="error-message"><?php echo $error_security ?></div>
        <?php elseif (!empty($_SESSION['retrieved_password'])): ?>
            <div class="success-message" style="color:black" >Your password is: <?php echo htmlspecialchars($_SESSION['retrieved_password']); 
            unset($_SESSION['email']);
            unset($_SESSION['showSecurityQuestion']);
            unset($_SESSION['security_question']);
            ?></div>
            <?php unset($_SESSION['retrieved_password']); // Clear the password from session
             unset($_SESSION['email']);
             unset($_SESSION['showSecurityQuestion']);
             unset($_SESSION['security_question']);
            ?>            
        <?php endif; ?>
    </div>
  </form>
  <?php endif; ?>
</div>

<style>  
.input {
    margin: 20px;
    font-family: "Poppins", sans-serif;
    font-size: 20px;
    border-radius: 5px;
}

.input-group {
    margin: 20px;    
    max-width: 50%;
}

.input-group input {
    margin: 4px 12px;    
    background-color: #eee;
    border: none;
    border-radius: 4px;
    padding: 2px 2px 2px 9px;
}

#scr_ques {
  width: 40%;
  background-color: var(--salmon-pink);
  color: white;  
  border-radius: 4px;
  margin: 4px 5px 4px 5px;
}

#scr_ques:hover {
  background-color: hsl(353, 95%, 76%);
}

</style>

<?php include("footer.php"); ?>