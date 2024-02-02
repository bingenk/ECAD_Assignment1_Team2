<?php 
include('header.php'); 
include('navbar.php');
include('feedbackDisplay.php');
include('mysql_conn.php');
?>
<!-- MAIN -->
<main>

<!-- BANNER -->
<div class="banner">
  <div class="container">
    <div class="slider-container has-scrollbar">
      <div class="slider-item">

        <img src="Images/background_flowers.jpg" alt="women's latest fashion sale" class="banner-img">

        <div class="banner-content">

          <p class="banner-subtitle">Trending item</p>

          <h2 class="banner-title">Product on Sales</h2>

          <p class="banner-text">
            starting at &dollar; <b>20</b>.00
          </p>

          <a href="#sidebar" class="banner-btn">Shop now</a>

        </div>

      </div>

      <div class="slider-item">

        <img src="Images/background_flowers2.jpg" alt="women's latest fashion sale" class="banner-img">

        <div class="banner-content">

          <p class="banner-subtitle">Trending item</p>

          <h2 class="banner-title">Product on Sales</h2>

          <p class="banner-text">
            starting at &dollar; <b>45</b>.00
          </p>

          <a href="#sidebar" class="banner-btn">Shop now</a>

        </div>

      </div>

      <div class="slider-item">

        <img src="Images/background_flowers3.jpg" alt="women's latest fashion sale" class="banner-img">

        <div class="banner-content">

          <p class="banner-subtitle">Trending item</p>

          <h2 class="banner-title">Product on Sales</h2>

          <p class="banner-text">
            starting at &dollar; <b>45</b>.00
          </p>

          <a href="#sidebar" class="banner-btn">Shop now</a>

        </div>
      </div>     

    </div>
  </div>
</div>

<!-- SIDEBAR -->
<div class="product-container" id="sidebar">
  <div class="container">          
    <div class="sidebar  has-scrollbar" data-mobile-menu>
      <div class="sidebar-category">
        <div class="sidebar-top">
          <h2 class="sidebar-title">Category</h2>
          <!-- Other elements like close button -->
        </div>        
        
        <form action="productListing.php" method="GET">
          <div class="category-checkbox">
              <label>
                  <input type="checkbox" id="flowersCheckbox" name="category[]" value="Flowers">
                  Flowers
              </label>
          </div>

          <div class="category-checkbox">
              <label>
                  <input type="checkbox" id="giftsCheckbox" name="category[]" value="Gifts">
                  Gifts
              </label>
          </div>

          <div class="category-checkbox">
              <label>
                  <input type="checkbox" id="hampersCheckbox" name="category[]" value="Hampers">
                  Hampers
              </label>
          </div>

          <button id="submitBtn" class="filter-button">Filter</button>
        </form>        
      </div>

      <div class="product-showcase">
        <h3 class="showcase-heading">best sellers</h3>
        <div class="showcase-wrapper">
          <div class="showcase-container">
            <?php
            // Query to get the best-selling products
            $bestSellersQuery = "SELECT p.ProductID, p.ProductTitle, p.Price, p.ProductImage, SUM(sci.Quantity) AS TotalSold
                                FROM Product p
                                JOIN ShopCartItem sci ON p.ProductID = sci.ProductID
                                GROUP BY p.ProductID
                                ORDER BY TotalSold DESC
                                LIMIT 3"; 

            $bestSellersResult = $conn->query($bestSellersQuery);

            if ($bestSellersResult && $bestSellersResult->num_rows > 0) {
                while ($row = $bestSellersResult->fetch_assoc()) {
                    echo "<div class='showcase'>";

                    echo "<a href='productDetails.php?pid=" . $row['ProductID'] . "' class='showcase-img-box'>";                    
                    echo "<img src='Images/Products/" . htmlspecialchars($row['ProductImage']) . "' alt='" . htmlspecialchars($row['ProductTitle']) . "' width='75' height='75' class='showcase-img'>";
                    echo "</a>";
                    echo "<div class='showcase-content'>";
                    echo "<a href='productDetails.php?pid=" . $row['ProductID'] . "'>";
                    echo "<h4 class='showcase-title'>" . htmlspecialchars($row['ProductTitle']) . "</h4>";
                    echo "</a>";                    
                  
                    // Showcase rating and price
                    echo "<div class='price-box'>";
                    echo "<p class='price'>$" . number_format($row['Price'], 2) . "</p>";
                    echo "</div>"; // .price-box
                    echo "</div>"; // .showcase-content
                    echo "</div>"; // .showcase
                }
            } else {
                echo "<p>No best-selling products found.</p>";
            }
            ?>
          </div>
        </div>
      </div>
    </div>
    <!-- END OF SIDEBAR -->

    <!-- PRODUCT ON OFFER -->
    <?php       
      $currentDate = date('Y-m-d');
      $query = "SELECT * FROM Product WHERE Offered = 1 AND '$currentDate' >= OfferStartDate AND '$currentDate' <= OfferEndDate ORDER BY ProductTitle ASC";
      $result = $conn->query($query);
            
      echo '<div class="product-main">';
      echo '<h2 class="title">Product on Offer</h2>';
      echo '<div class="product-grid">';
      
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $discountPercentage = round((1 - ($row['OfferedPrice'] / $row['Price'])) * 100);
      
              // Display each product
              echo "<div class='showcase'>";
              echo "<div class='showcase-banner'>";
              echo "<img src='Images/Products/" . htmlspecialchars($row['ProductImage']) . "' alt='" . htmlspecialchars($row['ProductTitle']) . "' width='300' class='product-img default'>";
              echo "<img src='Images/Products/" . htmlspecialchars($row['ProductImage']) . "' alt='" . htmlspecialchars($row['ProductTitle']) . "' class='product-img hover'>";
              echo "<p class='showcase-badge'>Offer {$discountPercentage}%</p>";              
              echo "</div>"; // .showcase-banner
      
              // Showcase content
              echo "<div class='showcase-content'>";
              echo "<a href='productDetails.php?pid=" . $row['ProductID'] . "' class='showcase-category'>" . htmlspecialchars($row['ProductTitle']) . "</a>";
              echo "<h3 class='showcase-title short-description'>";
              echo htmlspecialchars(mb_strimwidth($row['ProductDesc'], 0, 60, '...')); 
              echo "</h3>"; 
              echo "<p class='showcase-title expanded-description'>";
      
              // Price box
              echo "<div class='price-box'>";
              if ($row['OfferedPrice'] < $row['Price']) {
                  echo "<p class='price'>$" . htmlspecialchars($row['OfferedPrice']) . "</p>";
                  echo "<del>$" . htmlspecialchars($row['Price']) . "</del>";
              } else {
                  echo "<p class='price'>$" . htmlspecialchars($row['Price']) . "</p>";
              }
              echo "</div>"; // .price-box
      
              echo "</div>"; // .showcase-content
              echo "</div>"; // .showcase
          }
      } else {
          echo "<p>No products on sale currently.</p>";
      }
      echo "</div>"; // .product-grid
      echo '</div>'; // .product-main
    ?>
    <!-- END OF PRODUCT ON OFFER -->
  </div>           

  <!-- Feedback -->
  <h2 class="title" style="margin: 25px;">Rating & Feedback</h2>  
  <div class="testimonial-container">
    <?php displayFeedback(); // Call the function to display feedback ?>
  </div>
  </div>
</main>

<?php include 'footer.php'; ?>
