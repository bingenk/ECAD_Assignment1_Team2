<?php 
include("header.php"); // Include the Page Layout header

// Check if the search query is set and not empty
if (isset($_GET["search"])) {
    // Trim the search query and check if it's empty
    $searchQuery = trim($_GET["search"]);
    if ($searchQuery == "") {
        // Redirect to index.php if the search query is empty
        echo '<script>window.location.href="index.php";</script>';     
        exit();
    }

    include_once("mysql_conn.php");
    $qry = "SELECT * FROM product WHERE ProductTitle LIKE '%" . $conn->real_escape_string($searchQuery) . "%' OR ProductDesc LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
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
        echo "<p>No products found for the search query.</p>";
    }
} else {
    // Redirect to index.php if the search parameter is not set
    header("Location: index.php");
    exit();
}

include("footer.php"); // Include the Page Layout footer
?>
