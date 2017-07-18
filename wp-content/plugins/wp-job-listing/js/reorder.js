/**
 * Created by User on 2017.07.18.
 */
jQuery(document).ready(function($) {

    var sortList = $('ul#custom-type-list'); // if left without var it would also work, but by default it would become a global variable, accessable to everyone
    var animation = $('#loading-animation');
    var pageTitle = $('div h2');

    sortList.sortable({
        update: function(event, ui) { // update is a jquery event, when element is moved from one place to another
            animation.show();

            $.ajax({
               url: ajaxurl, // we have to tell jquery the url or the endpoint which to hit, ajaxurl - is variable in wp that describes where the requests should be sent (admin-ajax.php), admin-ajax.php - handles ajax requests
                type: 'POST', //type of the request
                dataType: 'json', // datatype that will be received
                data:{ // the actual data, that we are sending
                   action: 'save_post',  // save_post - custom name by bobby
                    order: sortList.sortable('toArray').toString() // order - custom variable
                },
                success: function(response) {
                    animation.hide();
                    pageTitle.after('<div class="updated"><p>Job sort order has been saved</p></div>');
                },
                error: function(error) {
                    animation.hide();
                    pageTitle.after('<div class="error"><p>There was an error saving or you dont have the permission</p></div>');
                }
            });
        }
    });
});