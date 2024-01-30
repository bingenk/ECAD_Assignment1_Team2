<?php
ob_start(); 
include("header.php");
include("mysql_conn.php");


$shopperID = $_SESSION["ShopperID"];
$errorMessages = isset($_SESSION["error_messages"]) ? $_SESSION["error_messages"] : "";
unset($_SESSION["error_messages"]); 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {    
    $isValid = true;
    $errorMessage = "";

    // Sanitize and validate input
    $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
    $subject = trim(filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING));
    $feedback = trim(filter_input(INPUT_POST, 'feedback', FILTER_SANITIZE_STRING));

    // Validate rating
    if ($rating === false || $rating < 1 || $rating > 5) {
        $isValid = false;
        $errorMessage .= "Please provide a valid rating.\n";
    }

    // Validate subject
    if (empty($subject)) {
        $isValid = false;
        $errorMessage .= "Please enter the subject of your feedback.\n";
    }

    // Validate feedback content
    if (empty($feedback)) {
        $isValid = false;
        $errorMessage .= "Please type your feedback.\n";
    }

    // If validation fails, show error messages
    if (!$isValid) {
      $_SESSION["error_messages"] = nl2br($errorMessage);
      header("Location: feedback.php"); // Redirect back to form
      exit;
    }

    // If validation is successful, proceed with saving the feedback
    // Prepare a statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO Feedback (ShopperID, Subject, Content, Rank) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $shopperID, $subject, $feedback, $rating);        

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION["FeedbackSubmitted"] = "Your feedback has been submitted successfully.";
        // Redirect to index.php
        echo '<script>window.location.href="index.php";</script>';        
        exit;
    } else {
        echo "Error submitting feedback: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<div class="feedback_form">
  <div class="wrapper">
    <h3>Ratings & Feedbacks</h3>
    <p>Your ratings and feedback are invaluable in guiding our continuous improvement efforts.</p>
    <form action="feedback.php" method="post">
      <div class="rating">
        <input type="number" name="rating" style="display: none;">
        <i class="bx bx-star star" style="--i: 0"></i>
        <i class="bx bx-star star" style="--i: 1"></i>
        <i class="bx bx-star star" style="--i: 2"></i>
        <i class="bx bx-star star" style="--i: 3"></i>
        <i class="bx bx-star star" style="--i: 4"></i>
      </div>
      <textarea
        name="subject"
        cols="10"
        rows="1"
        placeholder="Feedback about the Service, etc."
      ></textarea>
      <textarea
        name="feedback"
        cols="30"
        rows="5"
        placeholder="Please type your feedback here..."
      ></textarea>
      <?php if (!empty($errorMessages)): ?>
          <div class="error-messages" style="color: red;">
              <?php echo $errorMessages; ?>
          </div>
      <?php endif; ?>
      <div class="btn-group">
        <button type="submit" class="btn submit" id="submit">Submit</button>
        <button type="button" class="btn cancel" id="cancel">Cancel</button>
      </div>
    </form>
  </div>
</div>
<?php
ob_end_flush(); 
// Include the Page Layout footer 
include("footer.php");
?>

<style>
  .feedback_form {    
    display: flex;
    justify-content: center;
    align-items: center;    
    padding: 1rem;
    margin: 20px;
}
  .wrapper {
  background: white;
  padding: 2rem;
  max-width: 576px;
  width: 100%;
  border-radius: 0.75rem;
  box-shadow: 8px 3px 50px rgba(0.1, 0.1, 0.1, 0.05);
  text-align: center;
  min-width: 80%;
}
.wrapper h3 {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 1rem;
}
.rating {
  display: flex;
  justify-content: center;
  align-items: center;
  grid-gap: 0.5rem;
  font-size: 2rem;
  color: #ffd700;
  margin-bottom: 2rem;
  margin-top: 13px;
}
.rating .star {
  cursor: pointer;
}
.rating .star.active {
  opacity: 0;
  animation: animate 0.5s calc(var(--i) * 0.1s) ease-in-out forwards;
}

@keyframes animate {
  0% {
    opacity: 0;
    transform: scale(1);
  }
  50% {
    opacity: 1;
    transform: scale(1.2);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}

.rating .star:hover {
  transform: scale(1.1);
}
textarea {
  width: 100%;
  background: #f5f5f5;
  font-family: "Poppins", sans-serif;
  padding: 1rem;
  border-radius: 0.5rem;
  border: none;
  outline: none;
  resize: none;
  margin-bottom: 0.5rem;
}
.btn-group {
  display: flex;
  grid-gap: 0.5rem;
  align-items: center;
}
.btn-group .btn {
  padding: 0.75rem 1rem;
  border-radius: 0.5rem;
  border: none;
  outline: none;
  cursor: pointer;
  font-size: 0.875rem;
  font-weight: 500;
}
.btn-group .btn.submit {
  background: var(--salmon-pink);
  color: white;
}
.btn-group .btn.submit:hover {
  background: hsl(353, 95%, 76%);
}
.btn-group .btn.cancel {
  background: white;
  color: #000;
}
.btn-group .btn.cancel:hover {
  background: #f5f5f5;
}

</style>

<script>
const allStar = document.querySelectorAll('.rating .star')
const ratingValue = document.querySelector('.rating input')

allStar.forEach((item, idx)=> {
	item.addEventListener('click', function () {
		let click = 0
		ratingValue.value = idx + 1

		allStar.forEach(i=> {
			i.classList.replace('bxs-star', 'bx-star')
			i.classList.remove('active')
		})
		for(let i=0; i<allStar.length; i++) {
			if(i <= idx) {
				allStar[i].classList.replace('bx-star', 'bxs-star')
				allStar[i].classList.add('active')
			} else {
				allStar[i].style.setProperty('--i', click)
				click++
			}
		}
	})
})

document.getElementById('cancel').addEventListener('click', function() {
  window.location.href = 'index.php';
});
</script>