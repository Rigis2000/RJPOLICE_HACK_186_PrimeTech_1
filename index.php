<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Police Feedback System</title>
  <link rel="stylesheet" href="home/home.css">
  <link rel="stylesheet" href="chatbot/bot_style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
  <script src="chatbot/bot_script.js" defer></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="home/homeStyle.js" defer></script>
</head>

<body>
<?php include 'home/fetch_feedback.php'; ?>
<div id="overlay">
    <div id="menu-links">
        <a href="index.php">Home</a>
        <a href="login/login.html">Official Login</a>
        <a href="Help/help.html">Help</a>
        <a href="fullfeedback/fullFeedback.html"><button class="feedback-btn2"><strong>Provide Feedback</strong></button></a>
    </div>
</div>
<div id="navigation">
  <div id="logo-container">
    <img src="home/images/emblem1.png" alt="Logo 1">
    <img src="home/images/Logo.png" alt="Logo 2">
  </div>
  <div id="buttons-container">
    <a href="index.php" class="nav-link">Home</a>
    <a href="login/login.html" class="nav-link">Official Login</a>
    <a href="Help/help.html" class="nav-link">Help</a>
  </div>
  
  <div class="toggle-button-cover">
    <div id="button-3" class="button r">
      <input class="checkbox" type="checkbox" onclick="changeText()">
      <div class="knobs"></div>
      <div class="layer"></div>
    </div>
  </div>
  <a href="fullfeedback/fullFeedback.html"><button class="feedback-btn1"><strong>Provide Feedback</strong></button></a>
  <div id="menu-toggle">
    <div class="line"></div>
    <div class="line"></div>
    <div class="line"></div>
  </div>
</div>

<div id="main_view">
  <p><h1 id="main_title">Police Feedback System</h1></p>
  <h3 id="main_desc">Help us serve you better by providing your valuable feedback.</h3>
</div>

<section id="how-sec" class="section">
  <div class="h2">
    <h2 id="Change1">How It Works</h2><br><br>
  </div>
  <p class="p" id="Change2">
    Our Police Feedback System allows you to share your experiences, commendations, or concerns regarding police
    services. Your feedback is crucial in maintaining transparency and improving our services.
  </p>
  <p class="p" id="Change10">
    <strong class='strong'>Provide Feedback:</strong> Click the button below to submit your feedback anonymously or include your contact information for follow-up.
  </p> <br><br>
  <a href="fullfeedback/fullfeedback.html" style="text-decoration: none;"><button class="feedback-btn" id="feedbackButton">Provide Feedback</button></a>
</section>


<section id="fetch-sec" class="section">
  <div class="h2">
    <h2 id="fx_title">Feedbacks Of Police stations</h2>
  </div>
  <p>
    <?php
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<section class='feedback-box-section' id='fd_sec' data-feedback-datetime='{$row["feedback_datetime"]}'>";
        echo "<button class='enlarge-button' id='btn_sec'>";
        echo "<div class='feedback-box'>";
        echo "<div class='content-wrapper'>";
        echo "<strong class='strong'>User:</strong> " . $row["fd_name"] . "<br><br>";
        echo "<strong class='strong'>Station:</strong> " . $row["station_name"] . "<br><br>";
        echo "<strong class='strong'>Feedback:</strong> " . $row["feedback"] . "<br><br>";
        echo "</div>";
        echo "</div>";
        echo "</button>";
        echo "</section>";
      }
    } else {
        echo "No feedback available.";
    }
    ?>
  </p>
</section>


<section class="section">
    <div class="h2">
      <h2 id="Change4">Why Your Feedback Matters</h2><br><br>
    </div>
      <p class="p" id="Change5">
          Your feedback helps us identify areas for improvement, recognize outstanding service, and build trust within the community. We are committed to continuous enhancement based on your input.
      </p>
  </section>
  <section class="section">
    <div class="h2" id="Change6">
      <h2>Contact Information</h2><br><br>
    </div>
      <p class="p">
        <div id="Change7">
          If you need assistance or have questions, feel free to contact us:
        </div>
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
  <script>
      function changeText() {
          var checkbox = document.getElementById("button-3").querySelector(".checkbox");
          var mainDesc = document.getElementById("main_desc");
          var change1 = document.getElementById("Change1");
          var change2 = document.getElementById("Change2");
          var change4 = document.getElementById("Change4");
          var change5 = document.getElementById("Change5");
          var change6 = document.getElementById("Change6");
          var change7 = document.getElementById("Change7");
          var change8 = document.getElementById("fx_title");
          var change9 = document.getElementById("main_title");
          var change10 = document.getElementById("Change10");
          
          if (checkbox.checked) {
              mainDesc.textContent = "अपनी बहुमूल्य प्रतिक्रिया देकर आपको बेहतर सेवा प्रदान करने में हमारी सहायता करें।";
              change1.textContent = "यह काम किस प्रकार करता है?";
              change2.textContent = "हमारा पुलिस फीडबैक सिस्टम आपको पुलिस सेवाओं के संबंध में अपने अनुभव, प्रशंसा या चिंताएं साझा करने में मदद करता है। पारदर्शिता बनाए रखने और हमारी सेवाओं को बेहतर बनाने में आपकी प्रतिक्रिया महत्वपूर्ण है।";
              change4.textContent = "आपकी प्रतिक्रिया क्यों मायने रखती है:";
              change5.textContent = "आपकी प्रतिक्रिया हमें सुधार के क्षेत्रों की पहचान करने, उत्कृष्ट सेवा को पहचानने और समुदाय के भीतर विश्वास बनाने में मदद करती है। हम आपके इनपुट के आधार पर निरंतर वृद्धि के लिए प्रतिबद्ध हैं।";
              change6.textContent = "संपर्क जानकारी:";
              change7.textContent = "यदि आपको सहायता चाहिए या कोई सवाल हो, तो कृपया हमसे संपर्क करें:";
              change8.textContent = "पुलिस स्टेशनों की प्रतिक्रिया:";
              change9.textContent = "पुलिस फीडबैक प्रणाली";
              change10.textContent = "राय देने: गुमनाम रूप से अपना फीडबैक सबमिट करने के लिए नीचे दिए गए बटन पर क्लिक करें, या फॉलो-अप के लिए अपनी संपर्क जानकारी शामिल करें।";
            } else {
              mainDesc.textContent = "Help us serve you better by providing your valuable feedback.";
              change1.textContent = "How It Works";
              change2.textContent = "Our Police Feedback System allows you to share your experiences, commendations, or concerns regarding police services. Your feedback is crucial in maintaining transparency and improving our services.";
              change4.textContent = "Why Your Feedback Matters";
              change5.textContent = "Your feedback helps us identify areas for improvement, recognize outstanding service, and build trust within the community. We are committed to continuous enhancement based on your input.";
              change6.textContent = "Contact Information";
              change7.textContent = "If you need assistance or have questions, feel free to contact us:";
              change8.textContent = "Feedbacks Of Police stations";
              change9.textContent = "Police Feedback System";
              change10.textContent = "Provide Feedback: Click the button below to submit your feedback anonymously or include your contact information for follow-up.";
          }
      }
  </script>
</body>
</html>