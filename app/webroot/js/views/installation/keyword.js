if( typeof JS_IS_INSTALTION_PAGE !== 'undefined'){
    $(document).ready(function() {

        $(".keywords-uploadForm").each(function() {
            var id = $(this).attr('name');
            var html4 = '<fieldset class="users-fieldset">';
            if ($(this).hasClass("needs-req")){
                html4 += '<select id ="'+ id +'" name="'+ id +'[]" data-placeholder="'+ id +'" multiple class="chosen-select req" style="width:90%;">';
            }
            else{
                html4 += '<select id ="'+ id +'" name="'+ id +'[]" data-placeholder="'+ id +'" multiple class="chosen-select" style="width:90%;">';
            }
            html4 += '</select></fieldset>';
            $(this).html(html4);
        });


        //fill in the select
        $(".keywords-uploadForm").css('display','block');

        /////uses the chosen.js to turn the select into a fancy thingy
        $(".chosen-select").chosen();

        //$('.form-wrapper').find('input').each(function(e){
        //    $(this).click();
        //});


        //add new keyword with a comma
        $(".search-field").on('keyup', "input", function (e) {
            var selectTag = $(this).parents().eq(3).children().eq(0)
            var id = $(this).val();
            if ((id == "" || id == ',') && e.key == 'Backspace') {
                //backspace will do nothing if no keyword

            } else if (e.key == ',') {
                id = id.substring(0, id.length - 1);  //remove comma
                if (id == '') { //keyword is empty, so ignore.
                    $(this).val('');
                    return;
                }

                $(selectTag).append('<option selected="selected" data-id="' + id + '">' + id + '</option>');
                $(".chosen-select").trigger("chosen:updated");

            }
        });
    });

}
