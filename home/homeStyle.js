document.addEventListener("DOMContentLoaded", function () {
    var navigation = document.getElementById("navigation");
    var scrollLimit = 150;

    function updateNavigationColor() {
        if (window.scrollY > scrollLimit) {
            navigation.classList.add("scrolled");
        } else {
            navigation.classList.remove("scrolled");
        }
    }

    window.addEventListener("scroll", updateNavigationColor);

    updateNavigationColor();
});

document.addEventListener('click', function(event) {
    var enlargedSections = document.querySelectorAll('.feedback-box-section.enlarged');

    enlargedSections.forEach(function(enlargedSection) {
        if (!enlargedSection.contains(event.target)) {
            enlargedSection.classList.remove('enlarged');

            var dateElement = enlargedSection.querySelector('.feedback-datetime');
            if (dateElement) {
                dateElement.remove();
            }

        }
    });
});

var buttons = document.getElementsByClassName("enlarge-button");

Array.from(buttons).forEach(function(button) {
    button.addEventListener('click', function(event) {
        var section = this.closest('.feedback-box-section');
        section.classList.toggle('enlarged');

        event.stopPropagation();

        if (section.classList.contains('enlarged')) {
            var feedbackDatetime = section.getAttribute('data-feedback-datetime');
            var dateElement = document.createElement('div');
            dateElement.classList.add('feedback-datetime');
            dateElement.innerText = feedbackDatetime;
            section.appendChild(dateElement);
        } else {
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

