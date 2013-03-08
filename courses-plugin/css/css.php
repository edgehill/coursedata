<?php

/*
 *	CSS for the courses plugin
 *
 */
 
 
/* -------------------------*\
	ADMIN UI 
\*--------------------------*/

add_action( 'admin_head', 'admin_css' );

function admin_css(){ ?>

	<style>
	
	  /*-----------------------------*\
	 	 Main Admin Menus
	  \*-----------------------------*/
	
	  .padding { 
			margin: 0 6px;
	  }
	
	  .postbox .inside label { 
			font-weight: bold; 
			display: block; 
			padding: 0.5em 0; 
	  }
	
	  .postbox input, textarea { 
			width: 95%; 
			margin-left: 1px;
	  }
	
	  .postbox textarea { 
			height: 150px;
	  }
	
     .postbox select {
			width: 95%;
 	  }
	
	  .postbox .caption { 
			color: #999; 
			clear: both;
			margin-top: 4px;
			font-size: .9em;
	  }
	
	  .postbox .radio_label { 
			float: left; 
			margin-right: 0.5em; 
			clear: none;
	  }
	  
	  .postbox .error, #titlewrap .error { 
			color: #f00; 
			font-weight: 500 !important;
	  }
	
	.postbox .lighter {
		color: #777;
	}
	
	/*-----------------------------*
       Options / Settings Menus
	\*-----------------------------*/
	
	.cpd_options {
	   
	} 
	
	.cpd_options .back_to {
		margin-left: 30px;
	} 
	
    
	
	
	</style>
<?php
}

?>