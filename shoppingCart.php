<?php
// Detect the current session
session_start();
// Include the Page Layout header 
include("header.php");
?>
<aside class="aside">
  <div class="side-panel" data-side-panel="cart">
    <button
      class="panel-close-btn"
      aria-label="Close cart"
      data-panel-btn="cart"
    >
      <ion-icon name="close-outline"></ion-icon>
    </button>

    <ul class="panel-list">
      <li class="panel-item">
        <a href="#" class="panel-card">
          <figure class="item-banner">
            <img
              src="Images/Products/Blissful_Bundle.jpg"
              width="46"
              height="46"
              loading="lazy"
              alt="Blissful Bundle"
            />
          </figure>

          <div>
            <p class="item-title">Blissful Bundle</p>

            <span class="item-value">$20.15x1</span>
          </div>

          <button class="item-close-btn" aria-label="Remove item">
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </a>
      </li>

      <li class="panel-item">
        <a href="#" class="panel-card">
          <figure class="item-banner">
            <img
              src="Images/Products/Pink_Lady.jpg"
              width="46"
              height="46"
              loading="lazy"
              alt="Eco Vegetable"
            />
          </figure>

          <div>
            <p class="item-title">Pink Lady</p>

            <span class="item-value">$13.25x2</span>
          </div>

          <button class="item-close-btn" aria-label="Remove item">
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </a>
      </li>
    </ul>

    <div class="subtotal">
      <p class="subtotal-text">Subtotal:</p>

      <data class="subtotal-value" value="215.14">$215.14</data>
    </div>

    <a href="#" class="panel-btn">View Cart</a>
  </div>
</aside>
<?php
// Include the Page Layout footer 
include("footer.php");
?>
