/**
 * Created by User on 2017.07.17.
 */
jQuery(document).ready(function() {

    quicktags({
        id: 'minimum-requirements', // id - of the text field we are adding the qicktag to
        buttons: "em,strong,link,ul,li"
    });
    quicktags({
        id: 'preferred-requirements',
        buttons: "em,strong,link,ul,li"
    });

});
