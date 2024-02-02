<?php
include("header.php"); // Include the Page Layout header

// Initialize variables to hold the filter conditions
$occasionFilter = "";
$priceRangeFilter = "";

// Check if the search query is set and not empty
if (isset($_GET["search"])) {
    $searchQuery = trim($_GET["search"]);
    $occasion = isset($_GET["occasion"]) ? $_GET["occasion"] : '';
    $priceRange = isset($_GET["priceRange"]) ? $_GET["priceRange"] : '';
    $currentDate = date('Y-m-d'); // Get current date to check against offer period

    // Redirect to index.php if the search query is empty and no filters are selected
    if ($searchQuery == "" && $occasion == "" && $priceRange == "") {
        echo '<script>window.location.href="index.php";</script>';
        exit();
    }

    // Start building the query
    $qry = "SELECT p.*, 
            (CASE 
                WHEN p.Offered = 1 AND '$currentDate' BETWEEN p.OfferStartDate AND p.OfferEndDate THEN p.OfferedPrice 
                ELSE p.Price 
            END) AS EffectivePrice 
            FROM Product p";

    // Condition for filtering by occasion
    if (!empty($occasion)) {
        $occasion = $conn->real_escape_string($occasion);
        $qry .= " JOIN ProductSpec ps ON p.ProductID = ps.ProductID AND ps.SpecVal = '$occasion'";
    }

    $qry .= " WHERE (p.ProductTitle LIKE '%" . $conn->real_escape_string($searchQuery) . "%' OR p.ProductDesc LIKE '%" . $conn->real_escape_string($searchQuery) . "%')";

    // Modifying the query to include effective price in the condition
    if (!empty($priceRange)) {
        list($minPrice, $maxPrice) = explode('-', $priceRange);
        // Applying the price range filter using HAVING clause because it's calculated in SELECT
        $qry .= " HAVING EffectivePrice BETWEEN " . $conn->real_escape_string($minPrice) . " AND " . $conn->real_escape_string($maxPrice);
    }

    // Execute the query
    include_once("mysql_conn.php");
    $result = $conn->query($qry);

    if ($result->num_rows > 0) {
        echo '<div class="shopping-cart">';
        while ($row = $result->fetch_array()) {
            echo '<div class="product">';
            echo '<div class="product-image">';
            echo "<img src='Images/Products/$row[ProductImage]' />";
            echo '</div>';
            echo '<div class="product-details">';
            echo "<div class='product-title'><a href='productDetails.php?pid=$row[ProductID]' style=color:black>$row[ProductTitle]</a></div>";
            echo "<p class='product-description'>$row[ProductDesc]</p>";
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo "<p style='text-align: center; font-weight:bold; margin-top:5em; margin-bottom:5em; color: red; font-size: 24px;'>No products found matching your criteria.</p>";

    }
} else {
    // Redirect to index.php if the search parameter is not set
    header("Location: index.php");
    exit();
}

include("footer.php"); // Include the Page Layout footer
?>
