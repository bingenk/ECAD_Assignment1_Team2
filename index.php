<?php include('header.php'); include('navbar.php') ?>
<!-- MAIN -->
<main>

<!-- BANNER -->
<div class="banner">
  <div class="container">
    <div class="slider-container has-scrollbar">
      <div class="slider-item">

        <img src="https://img.freepik.com/free-photo/floral-ornaments_23-2148134159.jpg" alt="women's latest fashion sale" class="banner-img">

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

        <img src="https://img.freepik.com/free-photo/floral-ornaments_23-2148134159.jpg" alt="women's latest fashion sale" class="banner-img">

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

        <img src="https://img.freepik.com/free-photo/floral-ornaments_23-2148134159.jpg" alt="women's latest fashion sale" class="banner-img">

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
        
        <form action="product_display.php" method="GET">
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

    <!-- PRODUCT ON SALE -->
    <div class="product-main">
      <h2 class="title">Product on Sale</h2>
      <div class="product-grid">
        <div class="showcase">
          <div class="showcase-banner">
            <img src="Images/Products/Blissful_Bundle.jpg" alt="#" width="300" class="product-img default">
            <img src="Images/Products/Blissful_Bundle.jpg" alt="#" width="300" class="product-img hover">

            <p class="showcase-badge">15%</p>
            <div class="showcase-actions">

              <button class="btn-action">
                <ion-icon name="heart-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="eye-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="repeat-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="bag-add-outline"></ion-icon>
              </button>

            </div>
          </div>

          <div class="showcase-content">
            <a href="#" class="showcase-category">Product Name</a>
            <a href="#">
              <h3 class="showcase-title">Product Description....</h3>
            </a>

            <div class="showcase-rating">
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
            </div>

            <div class="price-box">
              <p class="price">$48.00</p>
              <del>$75.00</del>
            </div>

          </div>
        </div>       
        
        <div class="showcase">
          <div class="showcase-banner">
            <img src="Images/Products/Blooms_of_Sunshine.jpg" alt="#" width="300" class="product-img default">
            <img src="Images/Products/Blooms_of_Sunshine.jpg" alt="#" width="300" class="product-img hover">

            <p class="showcase-badge">15%</p>
            <div class="showcase-actions">

              <button class="btn-action">
                <ion-icon name="heart-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="eye-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="repeat-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="bag-add-outline"></ion-icon>
              </button>

            </div>
          </div>

          <div class="showcase-content">
            <a href="#" class="showcase-category">Product Name</a>
            <a href="#">
              <h3 class="showcase-title">Product Description....</h3>
            </a>

            <div class="showcase-rating">
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
            </div>

            <div class="price-box">
              <p class="price">$48.00</p>
              <del>$75.00</del>
            </div>

          </div>
        </div>           

        <div class="showcase">
          <div class="showcase-banner">
            <img src="Images/Products/Blossoming_Health.jpg" alt="#" width="300" class="product-img default">
            <img src="Images/Products/Blossoming_Health.jpg" alt="#" width="300" class="product-img hover">

            <p class="showcase-badge">15%</p>
            <div class="showcase-actions">

              <button class="btn-action">
                <ion-icon name="heart-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="eye-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="repeat-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="bag-add-outline"></ion-icon>
              </button>

            </div>
          </div>

          <div class="showcase-content">
            <a href="#" class="showcase-category">Product Name</a>
            <a href="#">
              <h3 class="showcase-title">Product Description....</h3>
            </a>

            <div class="showcase-rating">
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
            </div>

            <div class="price-box">
              <p class="price">$48.00</p>
              <del>$75.00</del>
            </div>

          </div>
        </div>           

        <div class="showcase">
          <div class="showcase-banner">
            <img src="Images/Products/Deluxe_Diaper_Cake_Girl.jpg" alt="#" width="300" class="product-img default">
            <img src="Images/Products/Deluxe_Diaper_Cake_Girl.jpg" alt="#" width="300" class="product-img hover">

            <p class="showcase-badge">15%</p>
            <div class="showcase-actions">

              <button class="btn-action">
                <ion-icon name="heart-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="eye-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="repeat-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="bag-add-outline"></ion-icon>
              </button>

            </div>
          </div>

          <div class="showcase-content">
            <a href="#" class="showcase-category">Product Name</a>
            <a href="#">
              <h3 class="showcase-title">Product Description....</h3>
            </a>

            <div class="showcase-rating">
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
            </div>

            <div class="price-box">
              <p class="price">$48.00</p>
              <del>$75.00</del>
            </div>

          </div>
        </div>           

        <div class="showcase">
          <div class="showcase-banner">
            <img src="Images/Products/Lavish_Prosperity.jpg" alt="#" width="300" class="product-img default">
            <img src="Images/Products/Lavish_Prosperity.jpg" alt="#" width="300" class="product-img hover">

            <p class="showcase-badge">15%</p>
            <div class="showcase-actions">

              <button class="btn-action">
                <ion-icon name="heart-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="eye-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="repeat-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="bag-add-outline"></ion-icon>
              </button>

            </div>
          </div>

          <div class="showcase-content">
            <a href="#" class="showcase-category">Product Name</a>
            <a href="#">
              <h3 class="showcase-title">Product Description....</h3>
            </a>

            <div class="showcase-rating">
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
            </div>

            <div class="price-box">
              <p class="price">$48.00</p>
              <del>$75.00</del>
            </div>

          </div>
        </div>           

        <div class="showcase">
          <div class="showcase-banner">
            <img src="Images/Products/Pink_Lady.jpg" alt="#" width="300" class="product-img default">
            <img src="Images/Products/Pink_Lady.jpg" alt="#" width="300" class="product-img hover">

            <p class="showcase-badge">15%</p>
            <div class="showcase-actions">

              <button class="btn-action">
                <ion-icon name="heart-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="eye-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="repeat-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="bag-add-outline"></ion-icon>
              </button>

            </div>
          </div>

          <div class="showcase-content">
            <a href="#" class="showcase-category">Product Name</a>
            <a href="#">
              <h3 class="showcase-title">Product Description....</h3>
            </a>

            <div class="showcase-rating">
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
            </div>

            <div class="price-box">
              <p class="price">$48.00</p>
              <del>$75.00</del>
            </div>

          </div>
        </div>           

        <div class="showcase">
          <div class="showcase-banner">
            <img src="Images/Products/Springtime_Bloom.jpg" alt="#" width="300" class="product-img default">
            <img src="Images/Products/Springtime_Bloom.jpg" alt="#" width="300" class="product-img hover">

            <p class="showcase-badge">15%</p>
            <div class="showcase-actions">

              <button class="btn-action">
                <ion-icon name="heart-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="eye-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="repeat-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="bag-add-outline"></ion-icon>
              </button>

            </div>
          </div>

          <div class="showcase-content">
            <a href="#" class="showcase-category">Product Name</a>
            <a href="#">
              <h3 class="showcase-title">Product Description....</h3>
            </a>

            <div class="showcase-rating">
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
            </div>

            <div class="price-box">
              <p class="price">$48.00</p>
              <del>$75.00</del>
            </div>

          </div>
        </div>           

        <div class="showcase">
          <div class="showcase-banner">
            <img src="Images/Products/Together_Forever.jpg" alt="#" width="300" class="product-img default">
            <img src="Images/Products/Together_Forever.jpg" alt="#" width="300" class="product-img hover">

            <p class="showcase-badge">15%</p>
            <div class="showcase-actions">

              <button class="btn-action">
                <ion-icon name="heart-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="eye-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="repeat-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="bag-add-outline"></ion-icon>
              </button>

            </div>
          </div>

          <div class="showcase-content">
            <a href="#" class="showcase-category">Product Name</a>
            <a href="#">
              <h3 class="showcase-title">Product Description....</h3>
            </a>

            <div class="showcase-rating">
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
            </div>

            <div class="price-box">
              <p class="price">$48.00</p>
              <del>$75.00</del>
            </div>

          </div>
        </div>           

        <div class="showcase">
          <div class="showcase-banner">
            <img src="Images/Products/Blissful_Bundle.jpg" alt="#" width="300" class="product-img default">
            <img src="Images/Products/Blissful_Bundle.jpg" alt="#" width="300" class="product-img hover">

            <p class="showcase-badge">15%</p>
            <div class="showcase-actions">

              <button class="btn-action">
                <ion-icon name="heart-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="eye-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="repeat-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="bag-add-outline"></ion-icon>
              </button>

            </div>
          </div>

          <div class="showcase-content">
            <a href="#" class="showcase-category">Product Name</a>
            <a href="#">
              <h3 class="showcase-title">Product Description....</h3>
            </a>

            <div class="showcase-rating">
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
            </div>

            <div class="price-box">
              <p class="price">$48.00</p>
              <del>$75.00</del>
            </div>

          </div>
        </div>           

        <div class="showcase">
          <div class="showcase-banner">
            <img src="Images/Products/Blissful_Bundle.jpg" alt="#" width="300" class="product-img default">
            <img src="Images/Products/Blissful_Bundle.jpg" alt="#" width="300" class="product-img hover">

            <p class="showcase-badge">15%</p>
            <div class="showcase-actions">

              <button class="btn-action">
                <ion-icon name="heart-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="eye-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="repeat-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="bag-add-outline"></ion-icon>
              </button>

            </div>
          </div>

          <div class="showcase-content">
            <a href="#" class="showcase-category">Product Name</a>
            <a href="#">
              <h3 class="showcase-title">Product Description....</h3>
            </a>

            <div class="showcase-rating">
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
            </div>

            <div class="price-box">
              <p class="price">$48.00</p>
              <del>$75.00</del>
            </div>

          </div>
        </div>           

        <div class="showcase">
          <div class="showcase-banner">
            <img src="Images/Products/Blissful_Bundle.jpg" alt="#" width="300" class="product-img default">
            <img src="Images/Products/Blissful_Bundle.jpg" alt="#" width="300" class="product-img hover">

            <p class="showcase-badge">15%</p>
            <div class="showcase-actions">

              <button class="btn-action">
                <ion-icon name="heart-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="eye-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="repeat-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="bag-add-outline"></ion-icon>
              </button>

            </div>
          </div>

          <div class="showcase-content">
            <a href="#" class="showcase-category">Product Name</a>
            <a href="#">
              <h3 class="showcase-title">Product Description....</h3>
            </a>

            <div class="showcase-rating">
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
            </div>

            <div class="price-box">
              <p class="price">$48.00</p>
              <del>$75.00</del>
            </div>

          </div>
        </div>           

        <div class="showcase">
          <div class="showcase-banner">
            <img src="Images/Products/Blissful_Bundle.jpg" alt="#" width="300" class="product-img default">
            <img src="Images/Products/Blissful_Bundle.jpg" alt="#" width="300" class="product-img hover">

            <p class="showcase-badge">15%</p>
            <div class="showcase-actions">

              <button class="btn-action">
                <ion-icon name="heart-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="eye-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="repeat-outline"></ion-icon>
              </button>

              <button class="btn-action">
                <ion-icon name="bag-add-outline"></ion-icon>
              </button>

            </div>
          </div>

          <div class="showcase-content">
            <a href="#" class="showcase-category">Product Name</a>
            <a href="#">
              <h3 class="showcase-title">Product Description....</h3>
            </a>

            <div class="showcase-rating">
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
              <ion-icon name="star-outline"></ion-icon>
            </div>

            <div class="price-box">
              <p class="price">$48.00</p>
              <del>$75.00</del>
            </div>
          </div>
        </div>           
      </div>
    </div>
    <!-- END OF PRODUCT ON SALE -->
  </div>           
</main>

<?php include 'footer.php'; ?>
