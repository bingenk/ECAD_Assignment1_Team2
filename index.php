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

        <img src="https://static.vecteezy.com/system/resources/previews/002/870/524/original/horizontal-backdrop-decorated-with-blooming-flowers-and-leaves-border-abstract-art-nature-background-trendy-plants-frame-flower-garden-botanical-floral-pattern-design-for-summer-sale-banner-vector.jpg" alt="women's latest fashion sale" class="banner-img">

        <div class="banner-content">

          <p class="banner-subtitle">Trending item</p>

          <h2 class="banner-title">Product on Sales</h2>

          <p class="banner-text">
            starting at &dollar; <b>20</b>.00
          </p>

          <a href="#" class="banner-btn">Shop now</a>

        </div>

      </div>

      <div class="slider-item">

        <img src="https://static.vecteezy.com/system/resources/previews/002/870/524/original/horizontal-backdrop-decorated-with-blooming-flowers-and-leaves-border-abstract-art-nature-background-trendy-plants-frame-flower-garden-botanical-floral-pattern-design-for-summer-sale-banner-vector.jpg" alt="women's latest fashion sale" class="banner-img">

        <div class="banner-content">

          <p class="banner-subtitle">Trending item</p>

          <h2 class="banner-title">Product on Sales</h2>

          <p class="banner-text">
            starting at &dollar; <b>20</b>.00
          </p>

          <a href="#" class="banner-btn">Shop now</a>

        </div>

      </div>

      <div class="slider-item">

        <img src="https://static.vecteezy.com/system/resources/previews/002/870/524/original/horizontal-backdrop-decorated-with-blooming-flowers-and-leaves-border-abstract-art-nature-background-trendy-plants-frame-flower-garden-botanical-floral-pattern-design-for-summer-sale-banner-vector.jpg" alt="women's latest fashion sale" class="banner-img">

        <div class="banner-content">

          <p class="banner-subtitle">Trending item</p>

          <h2 class="banner-title">Product on Sales</h2>

          <p class="banner-text">
            starting at &dollar; <b>20</b>.00
          </p>

          <a href="#" class="banner-btn">Shop now</a>

        </div>
      </div>     

    </div>
  </div>
</div>

<!-- SIDEBAR -->
<div class="product-container">
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
            <div class="showcase">

              <a href="#" class="showcase-img-box">
                <img src="Images/Category/Flowers.jpg" alt="baby fabric shoes" width="75" height="75"
                  class="showcase-img">
              </a>
              <div class="showcase-content">
                <a href="#">
                  <h4 class="showcase-title">Product Name</h4>
                </a>

                <div class="showcase-rating">
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                </div>

                <div class="price-box">
                  <del>$5.00</del>
                  <p class="price">$4.00</p>
                </div>
              </div>
            </div>          

            <div class="showcase">

              <a href="#" class="showcase-img-box">
                <img src="Images/Category/Flowers.jpg" alt="baby fabric shoes" width="75" height="75"
                  class="showcase-img">
              </a>
              <div class="showcase-content">
                <a href="#">
                  <h4 class="showcase-title">Product Name</h4>
                </a>

                <div class="showcase-rating">
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                </div>

                <div class="price-box">
                  <del>$5.00</del>
                  <p class="price">$4.00</p>
                </div>
              </div>
            </div>          

            <div class="showcase">

              <a href="#" class="showcase-img-box">
                <img src="Images/Category/Flowers.jpg" alt="baby fabric shoes" width="75" height="75"
                  class="showcase-img">
              </a>
              <div class="showcase-content">
                <a href="#">
                  <h4 class="showcase-title">Product Name</h4>
                </a>

                <div class="showcase-rating">
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                </div>

                <div class="price-box">
                  <del>$5.00</del>
                  <p class="price">$4.00</p>
                </div>
              </div>
            </div>          
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
