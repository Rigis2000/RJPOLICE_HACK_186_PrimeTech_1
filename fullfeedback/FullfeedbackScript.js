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
var selectedCategory = [];
$('#feedbackTag').on('change', function () {
    var selectedTag = $(this).val();
    $('#selectedfeedbackTag').empty();
    var check = false;
    selectedCategory.forEach(element => {
        if(selectedTag===element){
            check=true;
        }
    });
    if(check===false){
        $.ajax({
            type: 'POST', // You can change this to GET if appropriate
            url: 'FeedbackTags.php', // Change this to the actual PHP script
            data: { selectedTag: selectedTag },
            success: function (response) {
                $.each(response.tags, function (key, value) {
                    $('#selectedfeedbackTag').append('<option value="' + value.tag_id + '">' + value.tag_name + '</option>');
                });
            },
            error: function (xhr, status, error) {
                // Handle error if needed
                console.error(error);
            }
        });
        
        $('#addTagButton').off('click').on('click', function () {
            var selectedTagId = $('#selectedfeedbackTag').val();
            var selectedTagName = $('#selectedfeedbackTag option:selected').text();
            selectedCategory.push(selectedTag);
            if (selectedTagId && selectedTagName) {
                selectedTagsArray.push(selectedTagName);
    
                var tagButton = '<button class="tagButton" data-tag-id="' + selectedTagId + '">' + selectedTagName + '</button>';
    
                $('#selectedTags').append(tagButton);
    
                $('#selectedfeedbackTag').empty();
            }
        });
    
        $(document).off('click', '.tagButton').on('click', '.tagButton', function () {
            var selectedTagId = $(this).data('tag-id');
            var selectedTagName = $(this).text();
    
            $(this).remove();
    
            selectedTagsArray = selectedTagsArray.filter(function (tagName) {
                return tagName !== selectedTagName;
            });
    
            $('#selectedfeedbackTag').append('<option value="' + selectedTagId + '">' + selectedTagName + '</option>');
        });
    }

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
