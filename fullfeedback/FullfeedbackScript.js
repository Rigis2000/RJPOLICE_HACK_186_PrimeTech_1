$(document).ready(function () {
    $.ajax({
        type: 'GET',
        url: 'full_feedback.php',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $.each(response.stations, function (key, value) {
                    $('#station').append('<option value="' + value.station_id + '">' + value.name + '</option>');
                });
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            alert('Station Fetching Error');
            console.error(error);
        }
    });
});
var selectedTagsArray = [];

$(document).ready(function () {
    
    // Assuming your PHP script for fetching FeedbackTags is named FeedbackTags.php
    var feedbackTagsUrl = 'FeedbackTags.php';
    
    // Fetch and populate initial dropdown options
    $.ajax({
        type: 'GET',
        url: feedbackTagsUrl,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $.each(response.tags, function (key, value) {
                    $('#feedbackTag').append('<option value="' + value.tag_id + '">' + value.tag_name + '</option>');
                });
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            alert('Feedback Tags Fetching Error');
            console.error(error);
        }
    });

    // Handle click event on "Add Tag" button
    $('#addTagButton').on('click', function () {
        var selectedTagId = $('#feedbackTag').val();
        var selectedTagName = $('#feedbackTag option:selected').text();
        
        if (selectedTagId && selectedTagName) {
            selectedTagsArray.push(selectedTagName);
            
            // Create a button for the selected tag
            var tagButton = '<button class="tagButton" data-tag-id="' + selectedTagId + '">' +selectedTagName + '</button>';
            
            // Append the button to the selectedTags div
            $('#selectedTags').append(tagButton);

            // Remove the selected tag from the dropdown
            $('#feedbackTag option[value="' + selectedTagId + '"]').remove();
        }
    });

    // Handle click event on dynamically created tag buttons
    $(document).on('click', '.tagButton', function () {
        var selectedTagId = $(this).data('tag-id');
        var selectedTagName = $(this).text();

        // Remove the button from the selectedTags div
        $(this).remove();

        selectedTagsArray = selectedTagsArray.filter(function (tagName) {
            return tagName !== selectedTagName;
        });

        // Add the selected tag back to the dropdown
        $('#feedbackTag').append('<option value="' + selectedTagId + '">' + selectedTagName + '</option>');
    });
});

function submitForm() {
    var selectedStationID = $('#station').val();
    var feedback = $('#Text-feedback').val();
    var Fname = $("#name").val();

    if (!Fname) {
        if (!selectedStationID || !feedback) {
            alert('Please select both a police station and provide feedback.');
            return false;
        }
        var formData = {
            stationID: selectedStationID,
            feedback: feedback,
            selectedTags: selectedTagsArray  // Include selected tags in formData
        };
        console.log(selectedTagsArray);
        $.ajax({
            type: 'POST',
            url: 'full_feedback_connection.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    alert(response.message);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                alert('Feedback Submission Error');
                console.error(error);
            }
        });

        return false;
    } else {
        if (!selectedStationID || !feedback) {
            alert('Please select both a police station and provide feedback.');
            return false;
        }
        var formData = {
            stationID: selectedStationID,
            feedback: feedback,
            name: Fname,
            selectedTags: selectedTagsArray
        };
        console.log(selectedTagsArray);
        $.ajax({
            type: 'POST',
            url: 'full_feedback_connection.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    alert(response.message);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                alert('Feedback Submission Error');
                console.error(error);
            }
        });
        return false;
    }
}

$(document).ready(function () {
    $('#menu-toggle').click(function () {
        $('body').toggleClass('overlay-active');
    });
});