 <?php
session_start();
include_once("mysql_conn.php");

// Check if user is logged in
$isUserLoggedIn = isset($_SESSION['ShopperID']);
if (!empty($_POST['currency'])) {
  $selectedCurrency = $_POST['currency'];

  // Your API key
  $apiKey = '0034b819603ae4ceb5e116ea';
  $req_url = "https://v6.exchangerate-api.com/v6/{$apiKey}/latest/SGD";

  $response_json = file_get_contents($req_url);
  $response = json_decode($response_json);

  if ($response && $response->result == 'success') {
      // Store the conversion rates in session
      $_SESSION['conversion_rates'] = $response->conversion_rates;
      $_SESSION['selected_currency'] = $selectedCurrency;
      $_SESSION['ConversionRate'] = $response->conversion_rates->$selectedCurrency;
  }
}



$occasionQuery = "SELECT DISTINCT SpecVal FROM ProductSpec WHERE SpecID = (SELECT SpecID FROM Specification WHERE SpecName = 'Occasion') ORDER BY SpecVal";
$occasionResult = $conn->query($occasionQuery);

?>

<?php include_once('mysql_conn.php');

// Initialize user name variable
$userName = "Guest";

// Fetch user's name if logged in
if ($isUserLoggedIn) {
    $shopper_id = $_SESSION['ShopperID'];

    // Fetch the user's name from the database
    $query = "SELECT Name FROM Shopper WHERE ShopperID = $shopper_id";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userName = $row['Name'];
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FloraGifts E-commerce Shop</title>

  <link rel="shortcut icon" href="Images/Web_Icon/web_icon.png" type="image/x-icon">

  <link rel="stylesheet" href="css/style-prefix.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body>

  <div class="overlay" data-overlay></div>

  <div class="modal" data-modal>

    <div class="modal-close-overlay" data-modal-overlay></div>

    <div class="modal-content">

      <button class="modal-close-btn" data-modal-close>
        <ion-icon name="close-outline"></ion-icon>
      </button>

      <div class="newsletter-img">
        <img src="Images/Products/Deluxe_Diaper_Cake_Girl.jpg" alt="subscribe newsletter" width="400" height="400">
      </div>

      <div class="newsletter">

        <form action="#">

          <div class="newsletter-header">

            <h3 class="newsletter-title">Subscribe Newsletter.</h3>

            <p class="newsletter-desc">
              Subscribe to <b>FloraGifts</b> to get latest products and discount update.
            </p>

          </div>

          <input type="email" name="email" class="email-field" placeholder="Email Address" required>

          <button type="submit" class="btn-newsletter">Subscribe</button>

        </form>

      </div>

    </div>

  </div>

  <!-- NOTIFICATION TOAST -->

  <div class="notification-toast" data-toast>

    <button class="toast-close-btn" data-toast-close>
      <ion-icon name="close-outline"></ion-icon>
    </button>

    <div class="toast-banner">
      <img src="Images/Products/Pink_Lady.jpg" alt="Rose Gold Earrings" width="80" height="70">
    </div>

    <div class="toast-detail">

      <p class="toast-message">
        Someone in new just bought
      </p>

      <p class="toast-title">
        Product Name
      </p>

      <p class="toast-meta">
        <time datetime="PT2M">2 Minutes</time> ago
      </p>

    </div>

  </div>

  <!-- HEADER -->

  <header>

    <div class="header-top">

      <div class="container">

        <ul class="header-social-container">

          <li>
            <a href="https://facebook.com" class="social-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>

          <li>
            <a href="https://x.com" class="social-link">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>

          <li>
            <a href="https://instagram.com" class="social-link">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>

          <li>
            <a href="https://www.linkedin.com/in/bing-en-koo/" class="social-link">
              <ion-icon name="logo-linkedin"></ion-icon>
            </a>
          </li>

        </ul>

        <div class="header-alert-news">
          <p>
            Welcome to <b>FloraGifts</b> gift shop
          </p>
        </div>

        <div class="header-top-actions">

        <?php
            // Check if form was submitted and currency was selected
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['currency'])) {
          $_SESSION['selectedCurrency'] = $_POST['currency'];
        }

        // Use the session-stored currency or default to "SGD"
        $selectedCurrency = isset($_SESSION['selectedCurrency']) ? $_SESSION['selectedCurrency'] : 'SGD';

        echo "Selected Currency: " . htmlspecialchars($selectedCurrency);
        ?>

       <!-- Assuming this form is part of a PHP file -->
      <form method="post">
          <select name="currency" id="currency-select" onchange="this.form.submit()">
              <option value="" disabled selected>Change currency</option>
              <option value="SGD">SGD $</option>
              <option value="EUR">EUR €</option>
              <option value="USD">USD $</option>
          </select>
      </form>

  



        </div>

      </div>

    </div>

    <div class="header-main">

      <div class="container">

        <a href="#" class="header-logo">
          <a href="index.php" style="color: black; font-weight: 700; font-size: 1.7em;">FloraGifts</a>
        </a>

        <div class="header-search-container">

        <form name="frmSearch" action="search.php" method="get" class="header-search-form">
          <div class="header-search-container">
            <input type="search" name="search" id="search" class="search-field" placeholder="Enter your product name here">
            <!-- Filter button -->
            <button type="button" class="filter-btn" onclick="toggleFilterDropdown()">
              <ion-icon name="funnel-outline"></ion-icon>
            </button>
            <button class="search-btn" type="submit">
              <ion-icon name="search-outline"></ion-icon>
            </button>
          </div>

          <!-- Filter dropdown (hidden by default) -->
          <div class="filter-dropdown" id="filterDropdown" style="display: none;">
            <div class="filter-option">
              <label for="occasion">Occasion:</label>
              <select name="occasion" id="occasion">
                <option value="">Select</option>
                <?php
                // Check if the query returned any rows
                if ($occasionResult && $occasionResult->num_rows > 0) {
                    // Iterate through the result set and output option elements
                    while ($row = $occasionResult->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['SpecVal']) . "'>" . htmlspecialchars($row['SpecVal']) . "</option>";
                    }
                }
                ?>
            </select>
            </div>
            <div class="filter-option">
              <label for="priceRange">Price Range:</label>
              <select name="priceRange" id="priceRange">
                <option value="">Select</option>
                <option value="0-50">$0 - $50</option>
                <option value="51-100">$51 - $100</option>
                <!-- Add more options as needed -->
              </select>
            </div>
            <button type="submit" class="apply-filters-btn">Apply Filters</button>
          </div>
        </form>

        </div>  
    

        <div class="header-user-actions">
            <?php if ($isUserLoggedIn): ?>
                <!-- Dropdown for logged in users -->
                <div class="user-dropdown">
                    <button class="action-btn dropdown-toggle" onclick="toggleDropdown()">
                        <ion-icon name="person-outline"></ion-icon>
                    </button>
                    <div class="dropdown-content" id="userDropdown">
                      <div class="sub-dropdown-content">
                        <div class="user-info">
                          <h4><?php echo $userName; ?></h4>                   
                        </div>
                        <hr>
                        <div class="dropdown-item">
                            <ion-icon name="person-add-outline"></ion-icon>
                            <a href="updateProfile.php">Update Profile</a>                            
                        </div>
                        <div class="dropdown-item">
                            <ion-icon name="log-out-outline"></ion-icon>
                            <a href="logout.php">Logout</a>                            
                        </div>
                      </div>  
                    </div>
                </div>
            <?php else: ?>
                <!-- Button for users not logged in -->
                <button class="action-btn" onclick="redirectToLogin()">
                    <ion-icon name="person-outline"></ion-icon>
                </button>
            <?php endif; ?>

            

          <a class="action-btn" id="feedbackButton" style="cursor: pointer;">
            <ion-icon name="chatbox-ellipses-outline"></ion-icon>            
          </a>
          <?php 
// Start the session


// Check if the user is logged in
$isUserLoggedIn = isset($_SESSION['ShopperID']);

// Determine the link's HREF based on login status
$linkHref = $isUserLoggedIn ? "shoppingCart.php" : "login.php";
$linkFeedback = $isUserLoggedIn ? "feedback.php" : "login.php";

// Continue with the rest of your logged-in user's logic if logged in
if ($isUserLoggedIn):
    include_once('mysql_conn.php');
    $shopper_id = $_SESSION['ShopperID'];

    $query = "SELECT SUM(Quantity) AS total_quantity
              FROM shopcartitem
              WHERE ShopCartID IN (
                  SELECT ShopCartID
                  FROM shopcart
                  WHERE ShopperID = $shopper_id
                  AND OrderPlaced = 0
              )";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalQuantity = $row['total_quantity'];
    } else {
        $totalQuantity = 0; // Set to 0 if there are no items in the cart
    }
endif;
?>

<!-- Shopping Cart Link -->
<a href="<?php echo $linkHref; ?>" class="action-btn" id="cartButton">
    <ion-icon name="bag-handle-outline"></ion-icon>
    <?php if ($isUserLoggedIn && $totalQuantity > 0): ?>
        <span class='count'><?php echo $totalQuantity; ?></span>
    <?php endif; ?>
</a>



        </div>

      </div>

    </div>    

    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById("userDropdown");
            if (dropdown) {
                dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
            }
        }

        function redirectToLogin() {
            window.location.href = 'login.php';
        }

        function redirectToFeedback() {
            window.location.href = 'feedback.php';
        }

        document.getElementById('feedbackButton').addEventListener('click', function() {
        <?php if ($isUserLoggedIn): ?>
            window.location.href = 'feedback.php';
        <?php else: ?>
            window.location.href = 'login.php';
        <?php endif; ?>
      });

      function toggleFilterDropdown() {
      var dropdown = document.getElementById("filterDropdown");
      dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
      }    

    </script>


