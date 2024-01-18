<?php
// Detect the current session
session_start();
// Include the Page Layout header
include("header.php"); 

// Reading inputs entered in previous page
$email = $_POST["email"];
$pwd = $_POST["password"];

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php");

//Define the INSERT  SQL statement
$qry = "SELECT ShopperID,Name,Password FROM Shopper WHERE email = ?";
$stmt =$conn->prepare($qry);
$stmt->bind_param("s",$email);


//Execute the prepared statement
$stmt->execute();

//Get the result
$result = $stmt->get_result();

if($result->num_rows>0){//SQL statement executed succesfully

	$row=$result->fetch_assoc();
	$storedPassword =$row["Password"];
	$enteredPassword=$_POST["password"];
    
	// //Get the hashed password from the database
	$hashed_pwd=$row["Password"];
	// //verifies that a password matches a hash 


	if(password_verify($pwd,$hashed_pwd)==true){
		$_SESSION["ShopperID"]=$row["ShopperID"];
		$_SESSION["ShopperName"]=$row["Name"];
			// To Do 2 (Practical 4): Get active shopping cart
			include_once("mysql_conn.php");
			$qry = "SELECT sc.ShopCartID,COUNT(sci.ProductID) AS NumItems 
			FROM ShopCart sc LEFT JOIN ShopCartItem sci 
			ON sc.ShopCartID=sci.ShopCartID 
			WHERE sc.ShopperID=? AND SC.OrderPlaced=0";
			$stmt =$conn->prepare($qry);
			$stmt->bind_param("i",$_SESSION["ShopperID"]);//"i" - integer
			$stmt->execute();
			$result2 = $stmt->get_result();
			$stmt->close();
		
			if ($result2->num_rows > 0) {
				$row = $result2->fetch_array();
				$_SESSION["Cart"] = $row["ShopCartID"];
				$_SESSION["NumCartItem"] = $row["NumItems"];
			}
			
			
		header("Location: index.html");
		exit();
		$conn->close();

	}
	else{//Error message
		echo "Authentication failed: Incorrect password.";
   }
}
else{//Error message
    echo "Authentication failed: Email not found.";
}

//Release the resource allocated for prepared statement 
$stmt->close();
//Close database connection
$conn->close();


// To Do 1 (Practical 2): Validate login credentials with database

if (($email == "ecader@np.edu.sg") && ($pwd == "password")) {
	// Save user's info in session variables
	$_SESSION["ShopperName"] = "Ecader";
	$_SESSION["ShopperID"] = 1;
	
	// To Do 2 (Practical 4): Get active shopping cart
    include_once("mysql_conn.php");
	$qry = "SELECT sc.ShopCartID,COUNT(sci.ProductID) AS NumItems 
	FROM ShopCart sc LEFT JOIN ShopCartItems sci 
	ON sc.ShopCartID=sci.ShopCartID 
	WHERE sc.ShopperID=? AND SC.OrderPlaced=0";
	$stmt =$conn->prepare($qry);
	$stmt->bind_param("i",$_SESSION["ShopperID"]);//"i" - integer
	$stmt->execute();
	$result = $stmt->get_result();
    $stmt->close();

	if ($result->num_rows > 0) {
		
		$row = $result->fetch_array();
		$_SESSION["Cart"] = $row["ShopCartID"];
		$_SESSION["NumCartItem"]= 4;
	}
	
	
	// Redirect to home page
	header("Location: index.html");
	exit;
	$conn->close();
}
else {
	echo  "<h3 style='color:red'>Invalid Login Credentials</h3>";
}
	
// Include the Page Layout footer
include("footer.php");
?>