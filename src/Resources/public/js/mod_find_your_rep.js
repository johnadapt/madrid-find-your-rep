
// When the page is loaded
$( document ).ready(function() {
    var entry_found = false;
    
    // When our 'select_your_state' select changes
    $( ".select_your_state" ).on( "change", function() {

        // store our selected state
        var selectedState = this.value;
        // Show our state header
        $('#state_heading').html($(this).find('option:selected').text());
        
        // Loop through each listing
        $( ".rep_list .rep" ).each(function() {
            // If this rep has our selected state in it's class list, show the rep
            if($(this).hasClass(selectedState)) {
                    $(this).show();
                    entry_found = true;
            } else {
                $(this).hide();
            }
        });
        if(!entry_found){
            $('#empty').show();
        } else {
            $('#empty').hide();
        }
    });   
});