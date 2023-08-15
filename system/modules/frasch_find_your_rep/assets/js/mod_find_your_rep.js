
var last_state = '';
  
// When the page is loaded
$( document ).ready(function() {
    
    // When our 'select_your_state' select changes
    $( ".select_your_state" ).on( "change", function() {

        // store our selected state
        var selectedState = this.value;
        
        if(last_state != '')
             $('svg .' + last_state).css("fill", "#d4dbe0");
        $('svg .' + selectedState).css("fill", "#91b8cd");
        
        // show our product line filter once a state is selected
        if(selectedState != '') {
            $('.select_product_line').fadeIn();
        } else {
            $('.select_product_line').fadeOut();
        }
        
        // Loop through each listing
        $( ".rep_list .rep" ).each(function() {
            
            // If this rep has our selected state in it's class list, show the rep
            if($(this).hasClass(selectedState)) {
                
                // Get our product line filter value
                var selectedProductLine = $( ".product_line option:selected" ).val();
                
                if(selectedProductLine == '')
                    // if there is nothing selected then show our rep
                    $(this).fadeIn();
                else {
                    // if there is something selected see if it matches our listing
                    if($(this).data('product-line') == selectedProductLine)
                        $(this).fadeIn();
                    else
                        $(this).fadeOut();
                }
            } else {
                $(this).fadeOut();
            }
        });
        
        last_state = selectedState;
        
    });
    
    
    // When our 'select_your_state' select changes
    $( ".product_line" ).on( "change", function() {
        
        // store our selected product line
        var selectedProductLine = this.value;
        
        // Loop through each listing
        $( ".rep_list .rep" ).each(function() {

            // If this rep has our selected state in it's class list, show the rep
            if($(this).data('product-line') == selectedProductLine) {
                
                // Get our selected state
                var selectedState = $( ".select_your_state option:selected" ).val();
                
                if(selectedState == '') {
                    // if our selected state is empty show our listing
                    $(this).fadeIn();
                } else {
                    // if we selected a state, make sure the state is in the class list
                    if($(this).hasClass(selectedState))
                        $(this).fadeIn();
                    else
                        $(this).fadeOut();
                }

            } else {
                $(this).fadeOut();
            }
        });

    });
    
    
    
});
