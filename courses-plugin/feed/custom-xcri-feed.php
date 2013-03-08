<?php 

// XCRI-feed - Health CPD Courses 


header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true); $more = 1;
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; 

// Set global variables
$options = get_option('options');
$attendance_modes = get_option('attendance_modes');
$attendance_patterns = get_option('attendance_patterns');
$provider = get_option('xcri_provider');

// Get HTML purifier
include(WP_CONTENT_DIR.'/plugins/courses-plugin/html-purifier/HTMLPurifier.auto.php');
$purifier = new HTMLPurifier();

?>



<!-- NOTE: Catalog is not the real root. Its for validation only. The real root is below... -->
<catalog xmlns="http://xcri.org/profiles/1.2/catalog"
	xmlns:xcriTerms="http://xcri.org/profiles/catalog/terms"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:mlo="http://purl.org/net/mlo"
	xmlns:credit="http://purl.org/net/cm"
	xsi:schemaLocation="http://xcri.org/profiles/1.2/catalog http://www.xcri.co.uk/bindings/xcri_cap_1_2.xsd http://xcri.org/profiles/1.2/catalog/terms http://www.xcri.co.uk/bindings/xcri_cap_terms_1_2.xsd http://xcri.co.uk http://www.xcri.co.uk/bindings/coursedataprogramme.xsd" 
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	generated="2012-04-11T17:36:22.218Z"
>
	<dc:description>This feed and its contents are liscensed under the Open Government Licence (OGL) v1.0. See http://www.nationalarchives.gov.uk/doc/open-government-licence/ for how you can use this information. The owner of this licence is Edge Hill University.</dc:description>

	<provider>
		<dc:description><?php echo $provider['description']; ?></dc:description>
		<dc:identifier><?php echo $provider['url']; ?></dc:identifier>
		<dc:title><?php echo $provider['title']; ?></dc:title>
		<mlo:url><?php echo $provider['url']; ?></mlo:url>

		<?php 
		// loop the courses
		query_posts(
			array(
				'post_type' => 'courses', 
				'posts_per_page' => -1) // -1 means all of them
		); 
		while (have_posts()) : the_post(); ?>

			<?php /* <!-- COURSE POST ID: <?php echo $post->ID; ?> --> */ ?>
			<course>
				
				<dc:description>This is a CPD course that is part of Health &amp; Social Care at Edge Hill.</dc:description>
				<?php // TODO: Make description field - Ask Steve <dc:description>The description...</dc:description>?>
				<dc:identifier><?php echo htmlspecialchars(the_permalink(), ENT_QUOTES); ?></dc:identifier>
	

				<?php 
				/* ---------------------------------------- */ 
				/*     Subjects 							*/
				/* ---------------------------------------- */
				$subjects = get_the_terms($post->ID, 'subjects');
				
				// If none default to 'health'
				if(!$subjects){  ?>
					<dc:subject>Health</dc:subject>	
				<?php 
				// If it has any display the subjects
				} elseif($subjects){
					
					foreach($subjects as $subject){ ?>
					
						<dc:subject><?php echo $subject->name; ?></dc:subject>
					<?php } 
				} ?>

				<dc:title><?php the_title(); ?></dc:title>
				<mlo:url><?php echo the_permalink(); ?></mlo:url>

				<?php 

				
				/* ---------------------------------------- */ 
				/*     Abstract								*/
				/* ---------------------------------------- */
				$abstract = get_post_meta($post->ID, 'overview', true); 
				
				// If there's nothing to make the abstract from make a generic one
				if(!$abstract){	?>
					
					<abstract><?php echo $options['abstract']; ?></abstract>
				
				<?php

				// Otherwise make it from trimming the overview
				} else {
					
					$char_count = strlen($abstract);

					// Trim if too big
					if($char_count > 137){
						$abstract = mb_substr($abstract, 0, 137); 
						$abstract = $abstract . "..."; 
					// Otherwise display it
					} 
					else { $abstract = $abstract; }
					$clean_abstract = wp_kses($abstract, array());
					?>
					<abstract><?php echo $clean_abstract; ?></abstract>
				
				<?php }	?>
				
				
				<?php // display_feed_item('application_procedure', 'applicationProcedure'); // NOTE: Put an application_procedure url here... edgehill/cpd/how_to_apply ?>
				<?php display_feed_item_no_tags('assessment', 'mlo:assessment'); ?>
				<?php display_feed_item_no_tags('learning_outcomes','learningOutcome'); ?>
				<?php $purifier->purify(display_feed_item('objectives','mlo:objective')); ?>
				
				
				
				<?php 
				/* ---------------------------------------- */ 
				/*     CREDIT TAG							*/
				/* ---------------------------------------- */

				// Display logic for credits:
				
				// --if level and credits, 		display the credit tag
				// --if credit, no level, 		display credit tag, put '-' in the the level (as that validates)
				// --if level, no credit, 		don't display the credit tag (credit value is mandatory for a credit tag, and it has to be a number. We don't want to pass false info so just don't display the credit tag at all)
				// --if no credits, no level,	don't display the credit tag

				// ... divides the if based on credits 
				
				$level = trim(get_post_meta($post->ID, 'level', true));
				$credits = trim(get_post_meta($post->ID, 'credits', true));

				if($credits){ ?>
					<mlo:credit>
						<credit:level>
							<?php
							$level = trim(get_post_meta($post->ID, 'level', true));
							if ("" == $level) {
								echo '-';
							}
							else{
								echo $level;
							}
							?>
						</credit:level>	
						<?php $purifier->purify(display_feed_item('credits','credit:value')); ?>
					</mlo:credit>
				<?php }
				else{
					// Dont display the credit tag
				} ?>

				<?php 
				/* ---------------------------------------- */ 
				/*     PRESENTATIONS						*/
				/* ---------------------------------------- */
				$pres_ids = cpd_get_presentation_ids($post->ID);
				foreach($pres_ids as $pres_id): 
					if(!wp_is_post_revision($pres_id)): ?>

						<?php /* <!-- PRESENTATION POST ID: <?php echo $pres_id; ?> --> */ ?>
						<presentation>
							<dc:identifier><?php echo htmlspecialchars(get_permalink($pres_id), ENT_QUOTES); ?></dc:identifier>

							<dc:title><?php echo get_the_title($pres_id); ?></dc:title>
							
							<?php 
							/* ---------------------------------------- */ 
							/*     START DATE							*/
							/* ---------------------------------------- */
	 						$start_date = trim(get_post_meta($pres_id, 'start', true));
	 						if(!$start_date){
	 							echo "<mlo:start>Start date to be announced.</mlo:start>";
	 						}
	 						else{ ?>
	 							<mlo:start dtf="<?php echo $start_date; ?>"> 
									<?php
									// Translate the dtf format into - Tuesday, 3rd January 2011 
									$date = new DateTime($start_date);
									echo date_format($date, 'l, jS F Y');
									?>
								</mlo:start>
	 						<?php } // ---- end Start Date ?>

							
							<?php 
							/* ---------------------------------------- */ 
							/*     DURATION								*/
							/* ---------------------------------------- */
							$duration = trim(get_post_meta($post->ID, 'duration', true));
							if($duration): ?>
										
								<mlo:duration interval="P<?php echo $duration ?>W"><?php echo $duration ?> weeks</mlo:duration> 
								<?php // for time interval notation see - http://archives.postgresql.org/pgsql-patches/2003-09/msg00103.php ?>
										
							<?php endif; // ---- end Duration ?>

							<applyTo><?php echo $options['apply_to_url']; ?></applyTo>
							
							<?php 
							/* ---------------------------------------- */ 
							/*     ATTENDANCE MODE						*/
							/* ---------------------------------------- */
							$attendance_mode_id = get_post_meta($pres_id, 'attendance_mode', true); ?>
							<attendanceMode identifier="<?php echo $attendance_modes[$attendance_mode_id]['key']; ?>"><?php echo $attendance_modes[$attendance_mode_id]['text']; ?></attendanceMode>

							<?php
							// ---- Attendance Pattern
							$attendance_pattern_id = get_post_meta($pres_id, 'attendance_pattern', true);?>
							<attendancePattern identifier="<?php echo $attendance_patterns[$attendance_pattern_id]['key']; ?>"><?php echo $attendance_patterns[$attendance_pattern_id]['text']; ?></attendancePattern>

							<?php
							/* ---------------------------------------- */ 
							/*     COST									*/
							/* ---------------------------------------- */
							// Change £'s and &pound;'s to GBP...
							$cost = get_post_meta($post->ID, 'cost', true);
							$cost = str_replace("£", "GBP", $cost);
							$cost = str_replace("&pound;", "GBP", $cost);
							?>
							<mlo:cost><?php echo $cost; ?></mlo:cost>

							<?php 
							/* ---------------------------------------- */ 
							/*     VENUE								*/
							/* ---------------------------------------- */
							$venue_id = get_post_meta($pres_id, 'venue', true);
							//echo "<presID>" . $pres_id  . "</presID>";
							//echo "<venueID>" . $venue_id . "</venueID>";
							if($venue_id == 0){

								// Its online study don't display a venue								
							}
							elseif(!$venue_id){

								// No venue id unfortunately, lets just say its ormskirk
								$venue_id = 1; 
							}
							else{
								// else grab all the venue info
								$venue = cpd_get_venue($venue_id);
							?>
								<venue>
									<provider>
										<dc:identifier>http://www.edgehill.ac.uk/</dc:identifier>
										<dc:title><?php echo $venue['venue_short_title']; ?></dc:title>
										<mlo:location>
											<?php
											// Put venue items in if they exist
											// display_venue_item($venue, 'postcode', 'mlo:postcode');
											?>
											
											<?php // Echo postcode & phone manually as they are a required field ?>
											
											<mlo:postcode><?php if(!$venue['postcode']){ echo "P00 5ST"; } else { echo $venue['postcode']; } ?></mlo:postcode>
											<?php
											display_venue_item($venue, 'add1', 'mlo:address');
											display_venue_item($venue, 'add2', 'mlo:address');
											display_venue_item($venue, 'add3', 'mlo:address');
											display_venue_item($venue, 'add4', 'mlo:address');
											//display_venue_item($venue, 'phone', 'mlo:phone');
											?>
											
											<mlo:phone><?php if(!$venue['phone']){ echo "00000 000000"; } else { echo $venue['phone']; } ?></mlo:phone>
										</mlo:location>
									</provider>
								</venue>
							<?php } ?>
							<?php /* <!-- <description xsi:type="ehu:SessionTimes">The session times...</description> --><!-- TODO: Put this SessionTimes Field in --> */ ?>
						</presentation> 

					<?php endif; ?>
				<?php endforeach; // End Presentations  ?>

			</course>
		
		<?php endwhile; ?>

		<mlo:location>
			<mlo:town>Ormskirk</mlo:town>
			<mlo:postcode><?php echo $provider['postcode']; ?></mlo:postcode>
			<mlo:address><?php echo $provider['add1']; ?></mlo:address>
			<mlo:address><?php echo $provider['add2']; ?></mlo:address>
			<mlo:address><?php echo $provider['add3']; ?></mlo:address>
			<mlo:phone><?php echo $provider['phone']; ?></mlo:phone>
			<mlo:email><?php echo $provider['email']; ?></mlo:email>
			<mlo:url><?php echo $provider['location_url']; ?></mlo:url><?php /* <!-- TODO: Make this point to EH's location page --> */ ?>
		</mlo:location>
	</provider>
</catalog>
<?php // end feed; ?>


<?php 
/*
<!-- The Real Root Element -->

<provider
xmlns="http://xcri.org/profiles/1.2/catalog"
xmlns:xcriTerms="http://xcri.org/profiles/catalog/terms"
xmlns:dc="http://purl.org/dc/elements/1.1/"
xmlns:mlo="http://purl.org/net/mlo"
xmlns:credit="http://purl.org/net/cm"
xsi:schemaLocation="http://xcri.org/profiles/1.2/catalog http://www.xcri.co.uk/bindings/xcri_cap_1_2.xsd http://xcri.org/profiles/1.2/catalog/terms http://www.xcri.co.uk/bindings/xcri_cap_terms_1_2.xsd http://xcri.co.uk http://www.xcri.co.uk/bindings/coursedataprogramme.xsd" 
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
> 
*/ 
?>





