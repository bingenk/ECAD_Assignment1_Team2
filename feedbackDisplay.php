<?php
include("mysql_conn.php"); // Include your database connection

function displayFeedback() {
    global $conn; // Use the database connection from mysql_conn.php

    // SQL query to select the latest three feedback entries    
    $sql = "SELECT Subject, Content, Rank, DATE_FORMAT(DateTimeCreated, '%Y-%m-%d') AS FeedbackDate 
            FROM Feedback 
            ORDER BY DateTimeCreated DESC 
            LIMIT 3";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<div class='testimonial'>";
            echo "<div class='rating-wrapper'>";
            for ($i = 0; $i < $row['Rank']; $i++) {
                echo "<ion-icon name='star'></ion-icon>";
            }
            for ($i = $row['Rank']; $i < 5; $i++) {
                echo "<ion-icon name='star-outline'></ion-icon>";
            }
            echo "</div>";
            echo "<div class='name'>" . htmlspecialchars($row['Subject']) . "</div>";
            echo "<p>" . htmlspecialchars($row['Content']) . "</p>";
            echo "<div class='feedback_date'>" . $row['FeedbackDate'] . "</div>";
            echo "</div>";
        }
    } else {
        echo "No feedback available";
    }

    $conn->close();
}

?>
