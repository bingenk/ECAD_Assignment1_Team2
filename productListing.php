<?php
include('header.php'); 
include('navbar.php'); 
include('mysql_conn.php'); // Include your database connection file

// Check if any category is selected
if (isset($_GET['category']) && is_array($_GET['category'])) {
    $selectedCategories = $_GET['category'];

    // Prepare SQL query with JOINs
    $placeholders = implode(',', array_fill(0, count($selectedCategories), '?'));
    $query = "SELECT p.ProductID, p.ProductTitle, p.ProductDesc, p.ProductImage, p.Price, p.Quantity, p.Offered, p.OfferedPrice, p.OfferStartDate, p.OfferEndDate FROM product p 
              INNER JOIN catproduct cp ON p.ProductID = cp.ProductID 
              INNER JOIN category c ON cp.CategoryID = c.CategoryID 
              WHERE c.CatName IN ($placeholders)
              ORDER BY p.ProductTitle";
    
    $stmt = $conn->prepare($query);
    // Dynamic parameter binding
    $types = str_repeat('s', count($selectedCategories));
    $stmt->bind_param($types, ...$selectedCategories);
    $stmt->execute();
    $result = $stmt->get_result();
    echo '<div class="product-grid">';
    // Display products
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Check for valid offer
            $currentDate = date('Y-m-d');
            $isOfferValid = $row['Offered'] == 1 && $currentDate >= $row['OfferStartDate'] && $currentDate <= $row['OfferEndDate'];
            $isOutOfStock = $row['Quantity'] <= 0;

            // Start showcase
            echo "<div class='showcase'>";
            echo "<div class='showcase-banner'>";
            echo "<img src='Images/Products/" . htmlspecialchars($row['ProductImage']) . "' alt='" . htmlspecialchars($row['ProductTitle']) . "' class='product-img default'>";
            echo "<img src='Images/Products/" . htmlspecialchars($row['ProductImage']) . "' alt='" . htmlspecialchars($row['ProductTitle']) . "' class='product-img hover'>";

            if ($isOfferValid) {
                $discountPercentage = round((1 - ($row['OfferedPrice'] / $row['Price'])) * 100);
                echo "<p class='showcase-badge'>Offer {$discountPercentage}%</p>";
            }

            if ($isOutOfStock) {
                echo "<p class='showcase-badge' style='background-color: red;  color: white; font-weight: var(--weight-500); padding: 0 8px; border-radius: var(--border-radius-sm); display: inline-block;'>Out of Stock!</p> ";
            }

            // Buttons (like, view, etc.)
            echo "<div class='showcase-actions'>";
            echo "<button class='btn-action'><ion-icon name='heart-outline'></ion-icon></button>";
            echo "<button class='btn-action'><ion-icon name='eye-outline'></ion-icon></button>";
            echo "<button class='btn-action'><ion-icon name='repeat-outline'></ion-icon></button>";
            echo "<button class='btn-action'><ion-icon name='bag-add-outline'></ion-icon></button>";
            echo "</div>"; // .showcase-actions
            echo "</div>"; // .showcase-banner

            // Showcase content
            echo "<div class='showcase-content'>";
            echo "<a href='productDetails.php?pid=" . $row['ProductID'] . "' class='showcase-category'>" . htmlspecialchars($row['ProductTitle']) . "</a>";
            echo "<div class='description-container'>";
            echo "<h3 class='showcase-title short-description'>";
            echo htmlspecialchars(mb_strimwidth($row['ProductDesc'], 0, 100, '...')); // Display first 100 characters
            echo "</h3>";
            echo "<p class='showcase-title expanded-description'>";
            echo htmlspecialchars($row['ProductDesc']); // Display full description
            echo "</p>";
            echo "<a href='#' class='read-more-link'>Read more</a>";
            echo "<a href='#' class='read-less-link'>Read less</a>";
            echo "</div>"; // .description-container            

            // Price box
            echo "<div class='price-box'>";
            if ($isOfferValid) {
                echo "<p class='price'>$" . htmlspecialchars($row['OfferedPrice'],2) . "</p>";
                echo "<del>$" . htmlspecialchars($row['Price'],2) . "</del>";
            } else {
                echo "<p class='price'>$" . htmlspecialchars($row['Price'],2) . "</p>";
            }
            echo "</div>"; // .price-box
            echo "</div>"; // .showcase-content
            echo "</div>"; // .showcase
        }
    } else {
        echo "<p>No products found for the selected categories.</p>";
    }
    $stmt->close();
    echo "</div>"; // GRID
} else {
    echo "<p>Please select at least one category.</p>";
}
include('footer.php');
?>


<style>
.product-grid {
    display: flex-end;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
    align-items: flex-start; 
    padding: 1rem; 
}

@media (min-width: 600px) {
    .product-grid {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    }
}

.showcase {
    max-width: 300px; 
    margin: auto; 
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
}

.description-container {
    position: relative;
}

.showcase-title.expanded-description {
    display: none;
}

.read-less-link {
    display: none;
}

.showcase-title.short-description {
    max-height: 60px; 
    overflow: hidden;
}

.read-more-link,
.read-less-link {   
    color: black;
    font-size: smaller;
    bottom: 0;
    right: 0;
}
</style>

<script>
document.addEventListener('click', function(event) {
    if (event.target && event.target.classList.contains('read-more-link')) {
        event.preventDefault();
        const descriptionContainer = event.target.closest('.description-container');
        descriptionContainer.querySelector('.short-description').style.display = 'none';
        descriptionContainer.querySelector('.expanded-description').style.display = 'block';
        descriptionContainer.querySelector('.read-more-link').style.display = 'none';
        descriptionContainer.querySelector('.read-less-link').style.display = 'inline';
    }

    if (event.target && event.target.classList.contains('read-less-link')) {
        event.preventDefault();
        const descriptionContainer = event.target.closest('.description-container');
        descriptionContainer.querySelector('.short-description').style.display = 'block';
        descriptionContainer.querySelector('.expanded-description').style.display = 'none';
        descriptionContainer.querySelector('.read-more-link').style.display = 'inline';
        descriptionContainer.querySelector('.read-less-link').style.display = 'none';
    }
});
</script>
