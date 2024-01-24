document.addEventListener("DOMContentLoaded", function () {
  const cartButton = document.getElementById("cartButton");
  const cartSidePanel = document.querySelector(
    '.side-panel[data-side-panel="cart"]'
  );

  // Function to toggle the "active" class on the side panel
  function toggleSidePanel() {
    cartSidePanel.classList.toggle("active");
  }

  // Event listener for the cart button click
  cartButton.addEventListener("click", toggleSidePanel);

  // Event listener for closing the panel using the close button
  const closeButton = cartSidePanel.querySelector(".panel-close-btn");
  closeButton.addEventListener("click", toggleSidePanel);
});
