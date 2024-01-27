<?php
include("header.php");
?>
<div class="container">
  <h4 class="header_update">Update Profile</h4>
  <div class="settings-container">
    <div class="sidebar">
      <div class="sidebar-links">
        <a href="#account-general" class="sidebar-link active"
          >Account Information</a
        >
      </div>
    </div>
    <div class="update_content">
      <div id="account-general" class="tab-content active">
        <form class="form-settings">
          <label for="username">Name</label>
          <input type="text" id="name_update" value="Name" />

          <label for="name">Date of Birth</label>
          <input type="date" id="dob_update" value="11/12/2023" />

          <label for="email">Email</label>
          <input type="email" id="email_update" value="email@mail.com" />          

          <label for="email">Phone No.</label>
          <input type="tel" id="phoneNo_update" value="+65 1234567" />  

          <label for="company">Address</label>
          <input type="text" id="address_update" value="Address" />

          <label for="company">Country</label>
          <input type="text" id="country_update" value="Country" />

          <label for="company">Old Password</label>
          <input type="password" id="password_old_update" placeholder="Old Password"/>

          <label for="company">New Password</label>
          <input type="password" id="password_new_update" placeholder="New Password"/>

          <button type="submit" class="btn_update btn-primary">Save changes</button>
          <button type="button" class="btn_update btn-default">Cancel</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
// Include the Page Layout footer 
include("footer.php");
?>

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
