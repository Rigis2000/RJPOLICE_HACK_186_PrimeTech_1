<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Police Feedback System</title>
  <link rel="stylesheet" href="bot_style.css">
  <link rel="stylesheet" href="home.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
  <script src="script.js" defer></script>
  <script src="home.js" defer></script>
  <script src="homeStyle.js" defer></script>
</head>

<body>
<?php include 'fetch_feedback.php'; ?>
  <div id="navigation">
    <div id="logo-container">
      <img src="images/emblem.png" alt="Logo 1">
      <img src="images/Logo.png" alt="Logo 2">
    </div>
    <div id="buttons-container">
        <a href="homie.php" class="nav-link">Home</a>
        <a href="#" class="nav-link">Official Login</a>
        <a href="#" class="nav-link">Help</a>
    </div>
    <button class="feedback-btn1" id="feedbackButton"><strong>Provide Feedback</strong></button>
</div>

<div id="main_view">
  <p><h1 style="font-size: 60px">Police Feedback System</h1></p>
  <h3 style="color: #8A8A8B; font-size: 30px">Help us serve you better by providing your valuable feedback.</h3>
</div>
<section id="fetch-sec" class="section">
  <div class="h2">
    <h2>Feedbacks Of Police stations</h2>
  </div>
  <p>
    <?php
    // Display the fetched data
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<section class='feedback-box-section'>";
          echo "<div class='feedback-box'>";
          echo "<strong class='strong'>User:</strong> " . $row["fd_name"] . "<br>";
          echo "<strong class='strong'>Station:</strong> " . $row["station_name"] . "<br>";
          echo "<strong class='strong'>Feedback:</strong> " . $row["feedback"] . "<br><br>";
          echo "</div>";
          echo "</section>";
        }
    } else {
        echo "No feedback available.";
    }
    ?>
  </p>
</section>
<section id="how-sec" class="section">
  <div class="h2">
    <h2>How It Works</h2>
  </div>
  <p>
    Our Police Feedback System allows you to share your experiences, commendations, or concerns regarding police
    services. Your feedback is crucial in maintaining transparency and improving our services.
  </p>
  <p>
    <strong>Provide Feedback:</strong> Click the button below to submit your feedback anonymously or include your
    contact information for follow-up.
  </p> 
  <button class="feedback-btn" id="feedbackButton"><a href="fullfeedback.html" style="text-decoration: none;">Provide Feedback</a></button>
</section>
<section class="section">
    <div class="h2">
      <h2>Why Your Feedback Matters</h2>
    </div>
      <p>
          Your feedback helps us identify areas for improvement, recognize outstanding service, and build trust within the community. We are committed to continuous enhancement based on your input.
      </p>
  </section>
  <section class="section">
    <div class="h2">
      <h2>Contact Information</h2>
    </div>
      <p>
          If you need assistance or have questions, feel free to contact us:
          <br>
          Email: <a href="mailto:feedback@policeagency.com">feedback@policeagency.com</a>
          <br>
          Phone: (555) 123-4567
      </p>
  </section>
  <button class="chatbot-toggler">
    <span class="material-symbols-rounded">mode_comment</span>
    <span class="material-symbols-outlined">close</span>
  </button>
  <div class="chatbot">
    <header>
      <h2>Chatbot</h2>
      <span class="close-btn material-symbols-outlined">close</span>
    </header>
    <ul class="chatbox">
      <li class="chat incoming">
        <span class="material-symbols-outlined">smart_toy</span>
        <p>Hi there 👋<br>How can I help you today?<br>Type "help" to recieve help, or type "support" to recieve support
        </p>

      </li>
      <div class="bot-buttons" id="botbtns">
      </div>
    </ul>
    <div class="chat-input">
      <textarea placeholder="Enter a message..." spellcheck="false" required></textarea>
      <span id="send-btn" class="material-symbols-rounded">send</span>
    </div>
  </div>

</body>
</html>