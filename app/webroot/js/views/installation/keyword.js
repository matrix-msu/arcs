////TAKE 1


$(document).ready(function() {
    var html4 = '<fieldset class="users-fieldset">';
    html4 += '<select id ="urlAuthor" name="Country" data-placeholder="Country" multiple class="chosen-select" style="width:90%;">';

    html4 += '</select></fieldset>';

    //fill in the select
    $(".keywords-uploadForm").css('display','block');
    $(".keywords-uploadForm").html(html4);

    /////uses the chosen.js to turn the select into a fancy thingy
    $(".chosen-select").chosen();

    //add new keyword with a comma
    $(".search-field").on('keyup', "input", function (e) {
        var id = $(this).val();
        if ((id == "" || id == ',') && e.key == 'Backspace') {
            //backspace will do nothing if no keyword

        } else if (e.key == ',') {
            id = id.substring(0, id.length - 1);  //remove comma
            if (id == '') { //keyword is empty, so ignore.
                $(this).val('');
                return;
            }

            $("#urlAuthor").append('<option selected="selected" data-id="' + id + '">' + id + '</option>');
            $(".chosen-select").trigger("chosen:updated");
        }
    });
});



