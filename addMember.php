<?php
session_start(); //Detect the current session

//Read the data input from previous page
$name=$_POST["name"];
$address=$_POST["address"];
$country=$_POST["country"];
$phone=$_POST["phone"];
$email=$_POST["email"];
$password=$_POST["password"];

// // Create a password hase  using the defualt bcrypt algorithm
$password = password_hash($_POST["password"],PASSWORD_DEFAULT);
// $password = password_hash($_POST["password"],PASSWORD_DEFAULT)

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php");

//Define the INSERT  SQL statement
$qry = "INSERT INTO Shopper (Name,Address,Country,Phone,Email,Password)
        VALUES(?,?,?,?,?,?)";
$stmt = $conn->prepare($qry);
// "ssssss" - 6 string parameters
$stmt ->bind_param("ssssss",$name,$address,$country,$phone,$email,$password);

if($stmt->execute()){//SQL statement executed succesfully
//Retrieve the shopper ID assigned to the new shopper
   $qry="SELECT LAST_INSERT_ID() AS ShopperID";
   $result =$conn->query($qry);//Execute the SQL and get the returned result
    while ($row = $result->fetch_array()){
        $_SESSION["ShopperID"]=$row["ShopperID"];
    }

    //Successful message and shopper ID
    $Message ="Registration succesful!<br/>
                Your  ShopperID is $_SESSION[ShopperID]<br/>";
    //Save the shopper name in a session variable
    $_Session["ShoperName"] =$name;
}
else{//Error message
     $Message = "<h3 style='color:red'>Error in inserting record</h3>";
}

//Release the resource allocated for prepared statement 
$stmt->close();
//Close database connection
$conn->close();

//Display Page Layout header with updated session state and links
include("header.php");
//Display message
echo $Message;
//Display Page Layout footer
include("footer.php");
?>
