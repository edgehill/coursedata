	// 
	// Shows and hides the presentation information on the front end
	//

	jQuery(document).ready(function($) {
		
		// hide the presentations ( so intially visible to people w.out js )
		$('.session_times').css('display', 'none')
		
		// show the button ( users w.out js won't need it )
		$('.clickme').css('display', 'block')
		
		// Make the show hide functionality for presentations
		$('.clickme').click(function() {
		
			// use attr to see which was clicked
			clicked = $(this).attr('data');
			
			if($(this).text() == 'View Times'){
				
				// Show text and change to 'Hide'
				$(this).text("Hide Times");
				$('#session_times_' + clicked).toggle('slow', function() {})
				
			}
			else if($(this).text() == 'Hide Times'){
				
				$(this).text("View Times");
				$('#session_times_' + clicked).toggle('slow', function() {})
			}
		});
	
	})

		
