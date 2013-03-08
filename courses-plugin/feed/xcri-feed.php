<?php 
/**
 * XCRI-CAP 1.2 Feed - for cpd courses 
 *
 */

// @TODO - Cache it 


wp_redirect( 'http://www.google.com' );
// Set headers / mime type
header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
$more = 1;

// Include the HTML purifier
/*
require_once(plugin_dir_path(__FILE__) . 'html-purifier/HTMLPurifier.auto.php');
$purifier = new HTMLPurifier();
*/


// @TODO - Get all presentation info in ONE query here. Query this on the client within the feed
		
		/* EXAMPLE Single Query...
		global $wpdb;
		$presentations = $wpdb->get_results("SELECT post_id, meta_key, meta_value FROM $wpdb->postmeta WHERE post_id IN (SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'course_relation')");
		*/

// Echo header (has to be PHP, not HTML or the feed breaks)
echo '<?xml version="1.0" encoding="UTF-8"?>';  


echo '<dog>dog</dog>'; ?>

<provider
	xmlns="http://xcri.org/profiles/1.2/catalog"
	xmlns:xcriTerms="http://xcri.org/profiles/catalog/terms"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:mlo="http://purl.org/net/mlo"
	xmlns:credit="http://purl.org/net/cm"
	xsi:schemaLocation="http://xcri.org/profiles/1.2/catalog http://www.xcri.co.uk/bindings/xcri_cap_1_2.xsd http://xcri.org/profiles/1.2/catalog/terms http://www.xcri.co.uk/bindings/xcri_cap_terms_1_2.xsd http://xcri.co.uk http://www.xcri.co.uk/bindings/coursedataprogramme.xsd" 
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
> 
	<?php
	
 		// WP Loop - Loops courses
		query_posts(array('post_type' => 'courses')); 
		while (have_posts()) : the_post(); ?>

			<course>
				<dc:identifier><?php echo the_permalink(); ?></dc:identifier>
    				
					<?php foreach((get_the_category($post->ID)) as $subject){ 
						
						echo "<dc:subject>" . $subject->cat_name . "</dc:subject>";
    				
					}
    				?>

				<dc:title><?php the_title(); ?></dc:title>

				<mlo:url><?php echo the_permalink(); ?></mlo:url>

				<abstract>
			
					<?php 
				
						// Trim intro to make abstract
						$intro = get_post_meta($post->ID, 'overview', true); // no tags
						$char_count = strlen($intro);
					
						// trim if big
						if($char_count > 137){
						
							$abstract = mb_substr($intro, 0, 137);
							echo $abstract . "...";
						
						}
					
						// otherwise display
						else {
																	
							echo $intro;
							
						} ?>
					
					</abstract>	

						<?php 
					
							display_feed_item('assessment', 'assessment'); 
							//display_feed_item('application_procedure', 'applicationProcedure');  // This is optional - just having non-xcri 'contact us' for now
							display_feed_item('assessment','mlo:assessment');
							display_feed_item('learning_outcomes','learningOutcome');
							display_feed_item('objectives','mlo:objective');
						
						?>
					
					<!-- Only put this in if credits and value are filled in -->
					<mlo:credit>
					
						<?php
					
							//display_feed_item('scheme','credit:scheme');
							echo "<credit:scheme>???????? - what is this?</credit:scheme>";
							display_feed_item('level','credit:level');
							display_feed_item('credits','credit:value');
					
						?>
				
					</mlo:credit>
				
					<?php 
		
						$pres_ids = cpd_get_presentation_ids($post->ID);
		
						foreach($pres_ids as $pres_id){ ?>
            	
							<presentation>
								<dc:identifier><?php echo get_permalink($pres_id); ?></dc:identifier>

									<?php
	
										// <Start>
	 									$start_date = trim(get_post_meta($pres_id, 'start', true));

										if($start_date){ ?>
										
											<mlo:start dtf="<?php echo $start_date; ?>"> <?php
										
												// Translate the dtf format into - Tuesday, 3rd January 2011 
												$date = DateTime::createFromFormat('Y-n-j', $start_date); 
												echo $date->format('l, jS M Y'); ?>
										
											</mlo:start> <?php
									
										}

										// <Duration>
										$duration =  trim(get_post_meta($pres_id, 'duration', true));

										if($duration){ ?>
										
											<mlo:duration interval="P<?php echo $duration ?>W"><?php echo $duration ?> weeks</mlo:duration> <?php
											// for time interval notation - http://archives.postgresql.org/pgsql-patches/2003-09/msg00103.php
										
										}
						
						
										// <StudyMode>
										$study_mode = trim(get_post_meta($pres_id, 'study_mode', true));

										if($study_mode) : ?>

											<studyMode identifier="<?php echo $study_mode; ?>">
										
												<?php
									
													switch($study_mode){
														case 'FT':
															echo "Full Time";
															break;
														case 'PT':
															echo "Part Time";
															break;
														case 'FL':
															echo "Flexible";
															break;
														case 'PF':
															echo "Part of a full time programme";
															break;
														case 'NK':
															echo "Not known";
															break;
													}
												 
												?>

	      									</studyMode> 
									
										<?php 
										endif; 
									
									
										//<AttendanceMode>
										$attendance_mode = get_post_meta($pres_id, 'attendance_mode', true); 
									 
										if($attendance_mode != 'Not known'): // Element only goes in if one of the valid xcri options was chosen (Not known is not valid) ?>
										
											<attendanceMode identifier="<?php echo $attendance_mode; ?>">
										
												<?php
											
													switch($attendance_mode){
														case 'CM':
															echo "Campus";
															break;
														case 'DA':
															echo "Distance with attendance";
															break;
														case 'DS':
															echo "Distance without attendance";
															break;
														case 'NC':
															echo "Face-to-face non-campus";
															break;
														case 'MM':
															echo "Mixed mode";
															break;
														case 'ON':
															echo "Online (no attendance)";
															break;
														case 'WB':
															echo "Work-based";
															break;
													} 
											
												?>
       									
											</attendanceMode>
									
										<?php
										endif; 
									
									
										//<AttendancePattern>
										$attendance_pattern = get_post_meta($pres_id, 'attendance_pattern', true); ?>
        
										<attendancePattern identifier="<?php echo $attendance_pattern; ?>">
									
											<?php 
										
												switch($attendance_pattern){
												case 'DT':
													echo "Daytime";
													break;
												case 'EV':
													echo "Evening";
													break;
												case 'TW':
													echo "Twilight";
													break;
												case 'DR':
													echo "Day/Block release";
													break;
												case 'WE':
													echo "Weekend";
													break;
												case 'CS':
													echo "Customised";
													break;
												} 
										
											?>
									
										</attendancePattern>
									
										<mlo:cost>GBP<?php echo get_post_meta($post->ID, 'cost', true); ?></mlo:cost>

										<?php 
									    
											$venue = get_post_meta($pres_id, 'venue', true); 
									
										?>
									
										<venue>
											<provider>
												<dc:identifier>????????
											
													<?php
												
														switch ($venue){
															case "Aintree Campus, Edge Hill University":
																echo "URL";
																break;
															case "Ormskirk Campus, Edge Hill University":
																echo "URL";
																break;
															case "Armstrong House, Manchester":
																echo "URL";
																break;
															case "Respiratory Education UK (various locations)":
																echo "URL";
																break;
															case "Marie Curie Palliative Care Institute, Liverpool":
																echo "URL";
																break;
															case "Alder Hey Children's Hospital, Liverpool":
																echo "URL";
																break;
															case "Wrightington Hospital, Appley Bridge":
																echo "URL";
																break;
															default:
																echo "";
																break;
														}
												
													?>
											
												</dc:identifier>

												<dc:title><?php echo $venue; ?></dc:title>
											
												<mlo:location>
													<mlo:postcode><!-- @TODO prefill from venue (find addresses / postcodes)-->

														<?php
													
															switch ($venue){
																case "Aintree Campus, Edge Hill University":
																	echo "POSTCODE";
																	break;
																case "Ormskirk Campus, Edge Hill University":
																	echo "POSTCODE";
																	break;
																case "Armstrong House, Manchester":
																	echo "POSTCODE";
																	break;
																case "Respiratory Education UK (various locations)":
																	echo "POSTCODE";
																	break;
																case "Marie Curie Palliative Care Institute, Liverpool":
																	echo "POSTCODE";
																	break;
																case "Alder Hey Children's Hospital, Liverpool":
																	echo "POSTCODE";
																	break;
																case "Wrightington Hospital, Appley Bridge":
																	echo "POSTCODE";
																	break;
																default:
																	echo "";
																	break;
															}
														
														?>
											
												</mlo:postcode>
										
												<mlo:address><!-- @TODO prefill from venue (find addresses / postcodes)-->
											
													<?php
												
														switch ($venue){
															case "Aintree Campus, Edge Hill University":
																echo "ADDRESS";
																break;
															case "Ormskirk Campus, Edge Hill University":
																echo "ADDRESS";
																break;
															case "Armstrong House, Manchester":
																echo "ADDRESS";
																break;
															case "Respiratory Education UK (various locations)":
																echo "ADDRESS";
																break;
															case "Marie Curie Palliative Care Institute, Liverpool":
																echo "ADDRESS";
																break;
															case "Alder Hey Children's Hospital, Liverpool":
																echo "ADDRESS";
																break;
															case "Wrightington Hospital, Appley Bridge":
																echo "ADDRESS";
																break;
															default:
																echo "";
																break;
														}
												
													?>
											
												</mlo:address>
											</mlo:location>
										</provider>
									</venue>
								<applyTo>???????? - This will be the same for all courses...</applyTo>
							</presentation>
						
						<?php
						} // end foreach (presentations) 
						?>
               </course>

		<?php endwhile; ?>

</provider>

<?php // END FEED; ?>






<!-- OLD ORDER...
<applicationProcedure><?php echo get_post_meta($post->ID, 'application_procedure', true); ?></applicationProcedure>
<mlo:assessment><?php echo get_post_meta($post->ID, 'assessment', true); ?></mlo:assessment>
<learningOutcomes><?php echo get_post_meta($post->ID, 'learning_outcomes', true); ?></learningOutcomes>
<mlo:objective><?php echo get_post_meta($post->ID, 'objectives', true); ?></mlo:objective>
<mlo:credit>
	<credit:scheme>Edge Hill University</credit:scheme> Is this always EH? If not make CMS field --><!--
	<credit:level><?php //echo get_post_meta($post->ID, 'level', true); ?></credit:level>
    <credit:value><?php //echo get_post_meta($post->ID, 'value', true); ?></credit:value>
</mlo:credit>
<dc:identifier xsi:type="http://www.someCourseCodeVocabularyNameSpace...[what is this for EH?]">HEA-9087</dc:identifier>
-->





<?php 

/* PERMUTATIONS OF IFS....

<!-- V1 -->
<?php
	$app_pro = get_post_meta($post->ID, 'application_procedure', true);
	if($app_pro){ ?>
		<applicationProcedure>
			<?php echo $app_pro; ?>
		</applicationProcedure>
	<?php
	}
?>	

<!-- V2 -->
<?php
	$app_pro = get_post_meta($post->ID, 'application_procedure', true);
	if($app_pro){
		echo "<applicationProcedure>" . $app_pro . "</applicationProcedure>";
	}
?>

<!-- V3 -->
<?php
	$app_pro = get_post_meta($post->ID, 'application_procedure', true);
	echo $app_pro ? '<applicationProcedure>' . $app_pro . '</applicationProcedure>' : '' ;
?>
	*/
?>
