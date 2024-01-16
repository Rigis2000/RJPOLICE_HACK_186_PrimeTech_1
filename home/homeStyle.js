document.addEventListener("DOMContentLoaded", function () {
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

document.addEventListener('click', function(event) {
    var enlargedSections = document.querySelectorAll('.feedback-box-section.enlarged');

    enlargedSections.forEach(function(enlargedSection) {
        // Check if the click target is not within the enlarged section
        if (!enlargedSection.contains(event.target)) {
            // Remove the 'enlarged' class from the section
            enlargedSection.classList.remove('enlarged');

            // Remove the feedback_datetime display if it exists
            var dateElement = enlargedSection.querySelector('.feedback-datetime');
            if (dateElement) {
                dateElement.remove();
            }

            // Reset the line clamp value to the normal state
            // var contentWrapper = enlargedSection.querySelector('.content-wrapper');
            // contentWrapper.style.webkitLineClamp = 9;
        }
    });
});

var buttons = document.getElementsByClassName("enlarge-button");

Array.from(buttons).forEach(function(button) {
    button.addEventListener('click', function(event) {
        var section = this.closest('.feedback-box-section');
        section.classList.toggle('enlarged');

        // Stop the click event propagation to prevent it from triggering the document click event
        event.stopPropagation();

        if (section.classList.contains('enlarged')) {
            // If the section is enlarged, display feedback_datetime
            var feedbackDatetime = section.getAttribute('data-feedback-datetime');
            var dateElement = document.createElement('div');
            dateElement.classList.add('feedback-datetime');
            dateElement.innerText = feedbackDatetime;
            section.appendChild(dateElement);
        } else {
            // If the section is not enlarged, remove feedback_datetime display
            var dateElement = section.querySelector('.feedback-datetime');
            if (dateElement) {
                dateElement.remove();
            }
        }
    });
});



$(document).ready(function () {
    $('#menu-toggle').click(function () {
        $('body').toggleClass('overlay-active');
    });
});

