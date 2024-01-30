<?php 
include("header.php"); // Include the Page Layout header
?>

<?php
if (isset($_GET["search"]) && trim($_GET['search']) != "") {
    include_once("mysql_conn.php");
    $qry = "SELECT * FROM product WHERE ProductTitle LIKE '%" . $_GET["search"] . "%' OR ProductDesc LIKE '%" . $_GET["search"] . "%'";
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
}

include("footer.php"); // Include the Page Layout footer
?>
