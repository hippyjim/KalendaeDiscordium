/**
 * Created by JetBrains PhpStorm.
 * User: hippyjim
 * Date: 12/04/12 / 29th Discord, YOLD 3178
 * Time: 19:50
 */

/**
 * Set up all our live listeners to be triggered when we change anything
 */
$(document).ready(function(){
    $('select').live('change', doUpdate);
    $('#thudYear, #discYear').live('change', doUpdate);
    $('#thudYear').trigger('change');
});

/**
 * Update the main form, based on the details that changed
 * (look at the input/select id to see if it starts with thud or disc)
 * @param event
 */
function doUpdate() {
    $.ajax({
      type: 'POST',
      url: 'ajax.php',
      data: $('#kalForm').serialize() + '&act=update&type=' + $(this).get(0).id.substr(0, 4),
      success: updateForm,
      dataType: 'json'
    });
}

/**
 * After we;ve updated the form, update the calendar table
 */
function kalUpdate() {
    $.ajax({
      type: 'POST',
      url: 'ajax.php',
      data: $('#kalForm').serialize() + '&act=kal&type=disc',
      success: updateDisplay,
      dataType: 'html'
    });
}

/**
 * Apply the calendar table update to the page
 * @param response
 */
function updateDisplay(response) {
    $('#kalDisplay').html(response);
}

/**
 * Read the JSON response and update the form with appropriate values
 * @param response
 */
function updateForm(response) {
    $.each(response, function(index, item){
        element = $('#'+index);
        if (element.length > 0) {
            switch(element.get(0).nodeName.toLowerCase()){
                case "input":
                case "select":
                    element.val(item);
                    break;
                case "span":
                case "div":
                    if (index == "apostleDay" || index == "holyDay") {
                        if (item == false) {
                            element.html("").hide();
                        } else {
                            message = "Celebrate " + item;
                            if (index == "apostleDay") {
                                message += " for " + response.apostle + ", patron apostle of the season of " + response.discSeason;
                            }
                            element.html(message).show();
                        }
                    } else {
                        element.html(item);
                    }

                    break;
            }
        }
    });
    kalUpdate();
}
