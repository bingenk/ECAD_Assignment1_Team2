<nav class="desktop-navigation-menu">
    <div class="container">
        <ul class="desktop-menu-category-list">
            <li class="menu-category">
                <a href="productListing.php?category=Flowers" class="menu-title">Flowers</a>
            </li>
            <li class="menu-category">
                <a href="productListing.php?category=Gifts" class="menu-title">Gifts</a>
            </li>
            <li class="menu-category">
                <a href="productListing.php?category=Hampers" class="menu-title">Hampers</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Mobile Bottom Navigation -->
<div class="mobile-bottom-navigation">
    <button class="action-btn" data-mobile-menu-open-btn>
        <ion-icon name="menu-outline"></ion-icon>
    </button>
    <button class="action-btn">
        <ion-icon name="bag-handle-outline"></ion-icon>
        <span class="count">0</span>
    </button>
    <a class="action-btn" href="index.php">
        <ion-icon name="home-outline"></ion-icon>
    </a>  
    <?php  $linkFeedback = $isUserLoggedIn ? "feedback.php" : "login.php"; ?>
    <a class="action-btn" href="feedback.php" id="feedbackButton" style="cursor: pointer;">
      <ion-icon name="chatbox-ellipses-outline"></ion-icon>            
    </a>
    <button class="action-btn" data-mobile-menu-open-btn>
        <ion-icon name="grid-outline"></ion-icon>
    </button>
</div>

<!-- Mobile Navigation Menu -->
<nav class="mobile-navigation-menu has-scrollbar" data-mobile-menu>
    <div class="menu-top">
        <h2 class="menu-title">Menu</h2>
        <button class="menu-close-btn" data-mobile-menu-close-btn>
            <ion-icon name="close-outline"></ion-icon>
        </button>
    </div>
    <ul class="mobile-menu-category-list">
        <li class="menu-category">
            <a href="productListing.php?category=Flowers" class="menu-title">Flowers</a>
        </li>
        <li class="menu-category">
            <a href="productListing.php?category=Gifts" class="menu-title">Gifts</a>
        </li>
        <li class="menu-category">
            <a href="productListing.php?category=Hampers" class="menu-title">Hampers</a>
        </li>
    </ul>
    <div class="menu-bottom">
        <ul class="menu-social-container">
            <li>
                <a href="#" class="social-link">
                    <ion-icon name="logo-facebook"></ion-icon>
                </a>
            </li>
            <li>
                <a href="#" class="social-link">
                    <ion-icon name="logo-twitter"></ion-icon>
                </a>
            </li>
            <li>
                <a href="#" class="social-link">
                    <ion-icon name="logo-instagram"></ion-icon>
                </a>
            </li>
            <li>
                <a href="#" class="social-link">
                    <ion-icon name="logo-linkedin"></ion-icon>
                </a>
            </li>
        </ul>
    </div>
</nav>

