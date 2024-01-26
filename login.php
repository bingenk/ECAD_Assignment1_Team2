<?php
// Detect the current session

// Include the Page Layout header 
include("header.php");

if (isset($_GET['error'])) {
  if ($_GET['error'] == 'password') {
      $error_message = 'Incorrect password. Please try again.';
  } elseif ($_GET['error'] == 'email') {
      $error_message = 'Email not found. Please try again.';
  }
}
?>

<div class="center-container">
  <div class="register-container" id="register-container">
    <div class="form-container sign-up">
      <form action="addMember.php" method="post">
        <h1>Create Account</h1>
        <span>Please fill in the information below</span>
        <div class="input-group">
          <input type="text" placeholder="Name" id="Name" name="Name" required maxlength="50"/>
          <input type="email" placeholder="Email" id="Sign_Up_Email" name="Sign_Up_Email" required maxlength="50"/>
        </div>
        <div class="input-group">
          <input type="date" id="Dob" name="Dob" placeholder="Date of Birth"/>
          <input
            type="tel"
            placeholder="Phone No."
            pattern="\d{0,20}"
            title="Please enter only numbers up to 20 digits"
            id="Phone"
            name="Phone"
          />
        </div>
        <div class="input-group">
          <input type="text" placeholder="Address" id="Address" name="Address" maxlength="150" />
          <input type="text" placeholder="Country" id="Country" name="Country" maxlength="50" />
        </div>
        <input type="password" placeholder="Password" id="Sign_Up_Password" name="Sign_Up_Password" required minlength="8"/>
        <span>Security Questions (To retrieve password):</span>
        <div class="input-group">
          <select name="Security_Question" id="Security_Question" required>
            <option value="" disabled selected>Select your question</option>
            <option value="Do you have any pets?">Do you have any pets?</option>
            <option value="In which city were you born?">In which city were you born?</option>
            <option value="What is your favorite movie?">What is your favorite movie?</option>
          </select>
          <input type="text" placeholder="Answer" id="Answer" name="Answer" required maxlength="50" />
        </div>
        <button type="submit">Sign Up</button>
      </form>
    </div>
    <div class="form-container sign-in">
    <form action="checkLogin.php" method="post">
        <h1>Sign In</h1>
        <span>with your email and password</span>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <input type="email" name="Log_In_Email" id="Log_In_Email" placeholder="Email" required maxlength="50"/>
        <input type="password" name="Log_In_Password" id="Log_In_Password" placeholder="Password" required maxlength="20"/>
        <a href="#">Forget Your Password?</a>
        <button type="submit">Sign In</button>
    </form>
</div>
    <div class="toggle-container">
      <div class="toggle">
        <div class="toggle-panel toggle-left">
          <h1>Welcome Back!</h1>
          <p>Enter your personal details to use all of site features</p>
          <button class="hidden" id="login">Sign In</button>
        </div>
        <div class="toggle-panel toggle-right">
          <h1>Hello, Friend!</h1>
          <p>Register with your personal details to use all of site features</p>
          <button class="hidden" id="register">Sign Up</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
// Include the Page Layout footer 
include("footer.php");
?>
