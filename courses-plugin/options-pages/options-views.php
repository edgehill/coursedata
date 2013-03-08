<?php
// -----------------------------------------------------------------------------------------------
//  MAKE VIEWS
// -----------------------------------------------------------------------------------------------
// The main function is called by the function which registers the options page. It acts as a controller, 
// ... and pulls in the pages based on the url. 

function cpd_plugin_options_page(){
	?>
	    <div class="wrap cpd_options">
	        <div class="icon32" id="icon-options-general"><br></div>
	        <h2>CPD Courses - Manage Information</h2>
        
	        <?php 
            
	            // Content pulled in based on $_GET['tab'] 
	            $tab = $_GET['tab'];
            
	            switch ($tab) {
	                case 'home':
	                    cpd_options_home();
	                    break;
					
					// Venue views
	                case 'venue':
	                    cpd_options_venue();
	                    break;    
	                case 'add-venue':
	                    cpd_options_edit_venue();
	                    break;
	                case 'edit-venue':
	                    cpd_options_edit_venue();
	                   break;
					case 'delete-venue':
	                    cpd_options_delete_venue();
	                    break;
	
					// Attendance mode views
	                case 'attendance-mode':
	                    cpd_options_attendance_mode();
	                    break;   
 					case 'add-attendance-mode':
	                    cpd_options_edit_attendance_mode();
	                    break;
	                case 'edit-attendance-mode':
	                    cpd_options_edit_attendance_mode();
	                   break;
					case 'delete-attendance-mode':
	                    cpd_options_delete_attendance_mode();
	                    break;
		
	                // Attendance patters view
					case 'attendance-pattern':
	                    cpd_options_attendance_pattern();
	                    break;   
 					case 'add-attendance-pattern':
	                    cpd_options_edit_attendance_pattern();
	                    break;
	                case 'edit-attendance-pattern':
	                    cpd_options_edit_attendance_pattern();
	                   break;
					case 'delete-attendance-pattern':
	                    cpd_options_delete_attendance_pattern();
	                    break;

	                // Provider view
	                case 'manage-provider':
	                    cpd_options_manage_provider();
	                    break;

	                default:
	                    cpd_options_home();
	                    break;
	            }
	        ?>
	    </div>
	<?php
}

// ------------------------------------
//  THE VIEWS
// ------------------------------------

// Home (of options pages)
function cpd_options_home(){
	?>
	
		<form method="post" action="options.php">

        	<?php settings_fields('main_options_section'); ?>
	        <?php do_settings_sections('main-page'); ?> 
	        <?php submit_button(); ?>
	
		</form>
		
		<h3>Manage Other Information</h3>
		<p><a href="?page=manage-info-page&tab=manage-provider">Edge Hill</a></p>
		<p><a href="?page=manage-info-page&tab=venue">Venues</a></p>
		<?php 
		/*
		<p><a href="?page=manage-info-page&tab=attendance-mode">Attendance Mode</a></p>
		<p><a href="?page=manage-info-page&tab=attendance-pattern">Attendance Pattern</a></p>
		*/
		?>		
	<?php
}


// -----------------------------------------------------------------------------------------------
//  VENUES VIEWS
// -----------------------------------------------------------------------------------------------

// Venue home
function cpd_options_venue(){ 
	?>
	
	<!-- Breadcrumbs -->
	<p><a href="?page=manage-info-page">Home</a> &gt; Venues </p>
	<h2>Manage Venues</h2>
	
	
	<?php
	
	/* Use this to initialise the options db (FOR TESTING)
	$arr = array(
		1 => array(
			'venue_title' => "Aintree Campus, Edge Hill University",
			'add1' => "78 Dog Street",
			'add2' => "Dogsville",
			'add3' => "Dogsbury",
			'postcode' => "DOG DOG",
		),
		2 => array(
			'venue_title' => "Ormskirk Campus, Edge Hill University",
			'add1' => "78 Dog Street",
			'add2' => "Dogsville",
			'add3' => "Dogsbury",
			'postcode' => "DOG DOG",
		),
		3 => array(
			'venue_title' => "Armstrong House, Manchester",
			'add1' => "78 Dog Street",
			'add2' => "Dogsville",
			'add3' => "Dogsbury",
			'postcode' => "DOG DOG",
		),
		4 => array(
			'venue_title' => "Respiratory Education UK (various locations)",
			'add1' => "78 Dog Street",
			'add2' => "Dogsville",
			'add3' => "Dogsbury",
			'postcode' => "DOG DOG",
		),
		5 => array(
			'venue_title' => "Marie Curie Palliative Care Institute, Liverpool",
			'add1' => "78 Dog Street",
			'add2' => "Dogsville",
			'add3' => "Dogsbury",
			'postcode' => "DOG DOG",
		),
		6 => array(
			'venue_title' => "Alder Hey Children's Hospital, Liverpool",
			'add1' => "78 Dog Street",
			'add2' => "Dogsville",
			'add3' => "Dogsbury",
			'postcode' => "DOG DOG",
		),
		7 => array(
			'venue_title' => "Wrightington Hospital, Appley Bridge",
			'add1' => "78 Dog Street",
			'add2' => "Dogsville",
			'add3' => "Dogsbury",
			'postcode' => "DOG DOG",
		),
	);
	update_option('venues', $arr);
	*/

	
	$venues = get_option('venues');
	?>

	<!-- Venues Table -->
	<table>
		<?php
			foreach ($venues as $venue_id => $venue) {
				$address = $venue['add1'] . ", " . $venue['add2']  . ", " . $venue['add3']  . ", " . $venue['postcode'];
				// Trim it if too big
				if((strlen($address)) > 40){ $address = (substr($address, 0, 40 )) . "..."; } 
				else { $address = $address; }
				?>
				<tr>
					<td><?php echo $venue['venue_title']; ?></td>
					<td><?php echo $address; ?></td>
					<td><a href="?page=manage-info-page&tab=edit-venue&venue_id=<?php echo $venue_id;?>">Edit</a></td>
					<td><a href="?page=manage-info-page&tab=delete-venue&venue_id=<?php echo $venue_id;?>">Delete</a></td>
				</tr>
				<?php
			}
		?>
	</table>
	<p><a href="?page=manage-info-page&tab=add-venue&venue_id=new">Add new venue</a></p>
	
	<?php
}

// Add / Edit venue - unified form adds or edits depending on choice
function cpd_options_edit_venue(){ 
	
	$venue_id = $_GET['venue_id'];
	$editmode = $_GET['tab'];
	
	?>
	<!-- Breadcrumbs -->
	<p>
		<a href="?page=manage-info-page">Home</a> &gt; 
		<a href="?page=manage-info-page&tab=venue">Venues </a> &gt; 
		<?php if($venue_id == 'new'){ echo "Add New Venue"; } else { echo "Edit Venue"; } ?>
	</p>
	<?php 
		
	
	if($venue_id == 'new'){
		echo "<h2>Add New Venue</h2>";
		$save_text = 'Add Venue';
	}
	else{	
		// its got an id number
		echo "<h2>Edit Venue</h2>";
		$save_text = 'Save Changes';
	}
	?>
	
	<form method="post" action="options.php">

		<?php settings_fields('venue_section'); ?>
        <?php do_settings_sections('venue-page'); ?> 
		<input type="hidden" name="editmode" value="<?php echo $editmode; ?>" />
		<input type="hidden" name="venue_id" value="<?php echo $venue_id; ?>" />
		<br /><br />
        <?php submit_button($save_text, 'primary', 'submit', false); ?> <a class="back_to" href="?page=manage-info-page&tab=venue">Back to venues</a></p>
	
	</form>

	<?php
}

// Delete Venue
function cpd_options_delete_venue(){ 
	?>
	
	<!-- Breadcrumbs -->
	<p>
		<a href="?page=manage-info-page">Home</a> &gt; 
		<a href="?page=manage-info-page&tab=venue">Venues </a> &gt; 
		Delete Venue
	</p>
	
	<h2>Delete Venue</h2>
	
	<?php 
		// Check if it has already deleted, (when it saves it shows this page again). It it has, give a link back instead of the content
		$deleted = $_GET['settings-updated'];
		if($deleted){
			
			echo "<a href='?page=manage-info-page&tab=venue'>Back to venues</a>";
			
		}
		else {
			
			// Normal delete page
			?>
			<p>Are you sure you want to remove this venue?</p>

			<?php

			$venue_id = $_GET['venue_id'];
			$editmode = $_GET['tab'];
			$venues = get_option('venues');

			echo "<ul>";
			echo "<li>" . $venues[$venue_id]['venue_title'] . "</li>";
			echo "<li>" . $venues[$venue_id]['add1'] . "</li>";
			echo "<li>" . $venues[$venue_id]['add2'] . "</li>";
			echo "<li>" . $venues[$venue_id]['add3'] . "</li>";
			echo "<li>" . $venues[$venue_id]['postcode'] . "</li>";
			echo "<li>" . $venues[$venue_id]['phone'] . "</li>";
			echo "</ul>";

			?>

			<form method="post" action="options.php">

				<?php settings_fields('venue_section'); ?>
				<input type="hidden" name="editmode" value="<?php echo $editmode; ?>" />
				<input type="hidden" name="venue_id" value="<?php echo $venue_id; ?>" />
		        <?php submit_button('Yes Remove', 'secondary', 'submit'); ?>

			</form>

			<?php
		}
	
}


// -----------------------------------------------------------------------------------------------
//  ATTENDANCE MODE VIEWS
// -----------------------------------------------------------------------------------------------

// Attendance mode home
function cpd_options_attendance_mode(){
	?>
	<!-- Breadcrumbs -->
	<p><a href="?page=manage-info-page">Home</a> &gt; Attendance Mode </p>
	<h2>Attendance Mode Tag</h2>
	<p>Manage this tag's contents if the XCRI fields change</p>
	<?php 
	
	/*	Use this to initialise the options db  
		$arr = array(
		1 => array(
			'text' => 'Campus',
			'key' => 'CM'
		),
		2 => array(
			'text' => 'Distance with attendance',
			'key' => 'DA'
		),
		3 => array(
			'text' => 'Distance without attendance',
			'key' => 'DS'
		),
		4 => array(
			'text' => 'Face-to-face non-campus',
			'key' => 'NC'
		),
		5 => array(
			'text' => 'Mixed mode',
			'key' => 'MM'
		),
		6 => array(
			'text' => 'Online (no attendance)',
			'key' => 'ON'
		),
		7 => array(
			'text' => 'Work-based',
			'key' => 'WB'
		),
	
	);
	update_option('attendance_modes', $arr); // NB this calls the validate function as well (how?)
	*/
	
	$attendance_modes = get_option('attendance_modes');
	?>

	<!-- Attendance Mode Table -->
	<table>
		<?php
			foreach ($attendance_modes as $am_id => $attendance_mode) {
				?>
				<tr>
					<td><?php echo $attendance_mode['text']; ?></td>
					<td><?php echo $attendance_mode['key']; ?></td>
					<td><a href="?page=manage-info-page&tab=edit-attendance-mode&am_id=<?php echo $am_id;?>">Edit</a></td>
					<td><a href="?page=manage-info-page&tab=delete-attendance-mode&am_id=<?php echo $am_id;?>">Delete</a></td>
				</tr>
				<?php
			}
		?>
	</table>
	<p><a href="?page=manage-info-page&tab=add-attendance-mode&am_id=new">Add a new option</a></p>
	<p>Make an option for not inserting attendanceMode</p>
	
	<?php
}
	
// Add / Edit attendance mode
function cpd_options_edit_attendance_mode(){
	
	$am_id = $_GET['am_id'];
	$editmode = $_GET['tab'];
	
	?>
	<!-- Breadcrumbs -->
	<p>
		<a href="?page=manage-info-page">Home</a> &gt; 
		<a href="?page=manage-info-page&tab=attendance-mode">Attendance Mode Tag </a> &gt; 
		<?php if($venue_id == 'new'){ echo "Add New Attendance Mode Option"; } else { echo "Edit Attendance Mode Option"; } ?>
	</p>
	<?php 
		
	
	// Determine if adding or editing. Create titles and text for the submit button accordingly
	if($am_id == 'new'){
		echo "<h2>Add New Attendance Mode Option</h2>";
		$save_text = 'Add Option';
	}
	else{	
		// its got an id number
		echo "<h2>Edit Attendance Mode Option</h2>";
		$save_text = 'Save Changes';
	}
	?>
	
	<form method="post" action="options.php">

		<?php settings_fields('am_section'); ?>
        <?php do_settings_sections('am-page'); ?> 
		<input type="hidden" name="editmode" value="<?php echo $editmode; ?>" />
		<input type="hidden" name="am_id" value="<?php echo $am_id; ?>" />
		<br /><br />
        <?php submit_button($save_text, 'primary', 'submit', false); ?> <a class="back_to" href="?page=manage-info-page&tab=attendance-mode">Back to Attendance Mode Menu</a></p>
	
	</form>

	<?php
}

// Delete Attendance Mode
function cpd_options_delete_attendance_mode(){
	?>
	<!-- Breadcrumbs -->
		<!-- Breadcrumbs -->
		<p>
			<a href="?page=manage-info-page">Home</a> &gt; 
			<a href="?page=manage-info-page&tab=attendance-mode">Attendance Mode Tag </a> &gt;
			Delete Attendance Mode Option
	</p>
	
	<h2>Delete Attendance Mode Option</h2>
	
	<?php 
		// Check if it has already deleted, (when it saves it shows this page again). It it has, give a link back instead of the content
		$deleted = $_GET['settings-updated'];
		if($deleted){
			
			echo "<a href='?page=manage-info-page&tab=attendance-mode'>Back to attendance mode options</a>";
			
		}
		else {
			
			// Normal delete page
			?>
			<p>Are you sure you want to remove this option?</p>

			<?php

			$am_id = $_GET['am_id'];
			$editmode = $_GET['tab'];
			$attendance_modes = get_option('attendance_modes');

			echo "<ul>";
			echo "<li>" . $attendance_modes[$am_id]['text'] . "</li>";
			echo "<li>" . $attendance_modes[$am_id]['key'] . "</li>";
			echo "</ul>";

			?>

			<form method="post" action="options.php">

				<?php settings_fields('am_section'); ?>
				<input type="hidden" name="editmode" value="<?php echo $editmode; ?>" />
				<input type="hidden" name="am_id" value="<?php echo $am_id; ?>" />
		        <?php submit_button('Yes Remove', 'secondary', 'submit'); ?>

			</form>

			<?php
		}
}


// -----------------------------------------------------------------------------------------------
// ATTENDANCE PATTERN VIEWS
// -----------------------------------------------------------------------------------------------

// Attendance pattern home
function cpd_options_attendance_pattern(){
	
	
	?>
	<!-- Breadcrumbs -->
	<p><a href="?page=manage-info-page">Home</a> &gt; Attendance Pattern </p>
	<h2>Attendance Pattern Tag</h2>
	<p>Manage this tag's possible contents:</p>
	<?php 
	
		/* Use this to prepopulate the attendance patterns  
		$arr = array(
		1 => array(
			'text' => 'Daytime',
			'key' => 'DT'
		),
		2 => array(
			'text' => 'Evening',
			'key' => 'EV'
		),
		3 => array(
			'text' => 'Twilight',
			'key' => 'TW'
		),
		4 => array(
			'text' => 'Day/Block release',
			'key' => 'DR'
		),
		5 => array(
			'text' => 'Weekend',
			'key' => 'WE'
		),
		6 => array(
			'text' => 'Customised',
			'key' => 'MM'
		)
	);
	update_option('attendance_patterns', $arr); // NB this calls the validate function as well (how?)
	*/
	
	$attendance_patterns = get_option('attendance_patterns');
	?>

	<!-- Attendance patterns Table -->
	<table>
		<?php
			foreach ($attendance_patterns as $ap_id => $attendance_pattern) {
				?>
				<tr>
					<td><?php echo $attendance_pattern['text']; ?></td>
					<td><?php echo $attendance_pattern['key']; ?></td>
					<td><a href="?page=manage-info-page&tab=edit-attendance-pattern&ap_id=<?php echo $ap_id;?>">Edit</a></td>
					<td><a href="?page=manage-info-page&tab=delete-attendance-pattern&ap_id=<?php echo $ap_id;?>">Delete</a></td>
				</tr>
				<?php
			}
		?>
	</table>
	<p><a href="?page=manage-info-page&tab=add-attendance-pattern&ap_id=new">Add a new option</a></p>
	<p>Make a blank option for not inserting attendance_pattern</p>
	
	<?php
	
}


// Add / Edit attendance pattern
function cpd_options_edit_attendance_pattern(){
	
	$ap_id = $_GET['ap_id'];
	$editmode = $_GET['tab'];
	
	?>
	<!-- Breadcrumbs -->
	<p>
		<a href="?page=manage-info-page">Home</a> &gt; 
		<a href="?page=manage-info-page&tab=attendance-pattern">Attendance Pattern Tag </a> &gt; 
		<?php if($venue_id == 'new'){ echo "Add New Attendance Pattern Option"; } else { echo "Edit Attendance Pattern Option"; } ?>
	</p>
	<?php 
		
	
	// Determine if adding or editing. Create titles and text for the submit button accordingly
	if($am_id == 'new'){
		echo "<h2>Add New Attendance Pattern Option</h2>";
		$save_text = 'Add Option';
	}
	else{	
		// its got an id number
		echo "<h2>Edit Attendance Pattern Option</h2>";
		$save_text = 'Save Changes';
	}
	?>
	
	<form method="post" action="options.php">

		<?php settings_fields('ap_section'); ?>
        <?php do_settings_sections('ap-page'); ?> 
		<input type="hidden" name="editmode" value="<?php echo $editmode; ?>" />
		<input type="hidden" name="ap_id" value="<?php echo $ap_id; ?>" />
		<br /><br />
        <?php submit_button($save_text, 'primary', 'submit', false); ?> <a class="back_to" href="?page=manage-info-page&tab=attendance-pattern">Back to Attendance Pattern Menu</a></p>
	
	</form>

	<?php
}

function cpd_options_delete_attendance_pattern(){
	?>
	<!-- Breadcrumbs -->
		<!-- Breadcrumbs -->
		<p>
			<a href="?page=manage-info-page">Home</a> &gt; 
			<a href="?page=manage-info-page&tab=attendance-pattern">Attendance Pattern Tag </a> &gt;
			Delete Attendance Pattern Option
	</p>
	
	<h2>Delete Attendance Pattern Option</h2>
	
	<?php 
		// Check if it has already deleted, (when it saves it shows this page again). It it has, give a link back instead of the content
		$deleted = $_GET['settings-updated'];
		if($deleted){
			
			echo "<a href='?page=manage-info-page&tab=attendance-pattern'>Back to attendance pattern options</a>";
			
		}
		else {
			
			// Normal delete page
			?>
			<p>Are you sure you want to remove this option?</p>

			<?php

			$ap_id = $_GET['ap_id'];
			$editmode = $_GET['tab'];
			$attendance_patterns = get_option('attendance_patterns');

			echo "<ul>";
			echo "<li>" . $attendance_patterns[$ap_id]['text'] . "</li>";
			echo "<li>" . $attendance_patterns[$ap_id]['key'] . "</li>";
			echo "</ul>";

			?>

			<form method="post" action="options.php">

				<?php settings_fields('ap_section'); ?>
				<input type="hidden" name="editmode" value="<?php echo $editmode; ?>" />
				<input type="hidden" name="ap_id" value="<?php echo $ap_id; ?>" />
		        <?php submit_button('Yes Remove', 'secondary', 'submit'); ?>

			</form>

			<?php
		}
}

// -----------------------------------------------------------------------------------------------
// PROVIDER VIEW
// -----------------------------------------------------------------------------------------------

function cpd_options_manage_provider(){ ?>

	<!-- Breadcrumbs -->
	<p>
		<a href="?page=manage-info-page">Home</a>
	</p>
	
	<h2>Manage Provider Info</h2>
	
	<form method="post" action="options.php">

		<?php settings_fields('provider_section'); ?>
        <?php do_settings_sections('provider-page'); ?> 
		<br /><br />
        <?php submit_button($save_text, 'primary', 'submit', false); ?>
	
	</form>

<?php } ?>