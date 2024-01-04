document.addEventListener("DOMContentLoaded", function() {
  var navigation = document.getElementById("navigation");
  var scrollLimit = 150; // Adjust the scroll limit as needed

  function updateNavigationColor() {
      if (window.scrollY > scrollLimit) {
          navigation.classList.add("scrolled");
      } else {
          navigation.classList.remove("scrolled");
      }
  }

  window.addEventListener("scroll", updateNavigationColor);

  // Initial check for the color when the page loads
  updateNavigationColor();
});