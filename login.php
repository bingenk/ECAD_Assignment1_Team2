<?php
// Detect the current session
session_start();
// Include the Page Layout header 
include("header.php");
?>
<div class="center-container">
  <div class="register-container" id="register-container">
    <div class="form-container sign-up">
      <form action="addMember.php" method="Post">
        <h1>Create Account</h1>
        <span>Please fill in the information below</span>
        <div class="input-group">
          <input type="text" placeholder="Name" id="Name" Name="Name"/>
          <input type="email" placeholder="Email" id="Sign_Up_Email" Name="Sign_Up_Email"/>
        </div>
        <div class="input-group">
          <input type="date" id="Dob" Name="Dob" placeholder="Date of Birth" />
          <input
            type="tel"
            placeholder="Phone No."
            pattern="[0-9]+"
            title="Please enter only numbers"
            id="Phone"
            Name="Phone"
          />
        </div>
        <div class="input-group">
          <input type="text" placeholder="Address" id="Address" Name="Address" />
          <input type="text" placeholder="Country" id="Country" Name="Country" />
        </div>
        <input type="password" placeholder="password" id="Sign_Up_Password"Name="Sign_Up_Password" />
        <span>Security Questions (To retrieve password):</span>
        <div class="input-group">
          <select name="Security_Question" id="Security_Question">
            <option value="" disabled selected>Select your question</option>
            <option value="q1">Do you have any pets?</option>
            <option value="q2">In which city were you born?</option>
            <option value="q3">What is your favorite movie?</option>
          </select>
          <input type="text" placeholder="Answer" id="Answer" Name="Answer" />
        </div>
        <button>Sign Up</button>
      </form>
    </div>
    <div class="form-container sign-in">
      <form action="checkLogin.php" method="post">
        <h1>Sign In</h1>
        <span>with your email and password </span>
        <input type="email" name="Log_In_Email" id="Log_In_Email" placeholder="Email" required />
        <input type="password" name="Log_In_Password" id="Log_In_Password" placeholder="Password" required />
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
