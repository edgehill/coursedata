<?php // NOTE: These page templates are here for legacy purposes. The actual course template is in the themes folder (single-courses.php)
/**
 * The Template for displaying a single course
 *
 */

get_header(); ?>


    	<h1><?php the_title(); ?></h1>
		<div id="content" class="cpd_course_page yui-u first">
			<?php the_post_thumbnail( 'full',array('style' => 'display: none;', 'class' => 'leaflet_image') ); ?> 
		
                
                <?php
				
                	// Overview
					$overview = trim(get_post_meta($post->ID, 'overview', true)); // trim it, - so won't display even if there's just whitespace in DB
					if($overview){
						?>
                        	<h2>TESTLER - Overview</h2>
                            <?php echo wpautop(cpd_filter_tags($overview)); // wpautop($text_with_spaces) - creates <p> tags so preserves formatting ?>
                        
                        <?php
					}
					
					// Details for the table
					$module_code = 	get_post_meta($post->ID, 'module_code', true); 
					$level = 		get_post_meta($post->ID, 'level', true); 
					$credits = 		get_post_meta($post->ID, 'credits', true); 
					$cost = 		get_post_meta($post->ID, 'cost', true);
				
				?>
                    
                <?php $no_result = " - "; // Displayed where there is nothing in the db ?>
                
                <!-- Module Details -->
                <table class="courseSpec">
                    <tr>
                        <td>Module Code: </td>
                        <td><?php if($module_code){ echo cpd_filter_tags($module_code); } else { echo $no_result; } ?></td>
                    </tr>
                    <tr>
                        <td>Level: </td>
                        <td><?php if($level){ echo cpd_filter_tags($level); } else { echo $no_result; }  ?></td>
                    </tr>
                    <tr>
                        <td>Credits: </td>
                        <td><?php if($credits){ echo cpd_filter_tags($credits);  } else { echo $no_result; } ?></td>
                    </tr>
                    <tr>
                        <td>Cost: </td>
                        <td><?php if($cost){ echo cpd_filter_tags($cost); } else { echo $no_result; }  ?></td>
                    </tr>
                    <?php
						// you could put some other info here as well...
						// - start date, duration, attendancemode, study mode, attendance pattern
					?>
                </table>
				
                <?php
					
                	// Audience
					$audience = trim(get_post_meta($post->ID, 'audience', true)); // trim it, - so won't display even if there's just whitespace in DB
					if($audience){
						?>
                        	<h3>Who is this module for?</h3>
                            <?php echo wpautop(cpd_filter_tags($audience)); ?>
                        
                        <?php
					}
					
					// Aims
					$aims = trim(get_post_meta($post->ID, 'aims', true)); // trim it, - so won't display even if there's just whitespace in DB
					if($aims){
						?>
                        	<h3>What are the key aims of the program?</h3>
                            <?php echo wpautop(cpd_filter_tags($aims)); ?>
                        
                        <?php
					}
					
					// Content
					$content = trim(get_post_meta($post->ID, 'content', true)); // trim it, - so won't display even if there's just whitespace in DB
					if($content){
						?>
                        	<h3>What will I study?</h3>
                            <?php echo wpautop(cpd_filter_tags($content)); ?>
                        
                        <?php
					}
					
					// Assessment
					$assessment = trim(get_post_meta($post->ID, 'assessment', true)); // trim it, - so won't display even if there's just whitespace in DB
					if($assessment){
						?>
                        	<h3>How will I be assessed?</h3>
                            <?php echo wpautop(cpd_filter_tags($assessment)); ?>
                        
                        <?php
					}
					
					// Learning Outcomes
					$learning_outcomes = trim(get_post_meta($post->ID, 'learning_outcomes', true)); // trim it, - so won't display even if there's just whitespace in DB
					if($learning_outcomes){
						?>
                        	<h3>On successful completion you will:</h3>
                            <?php echo wpautop(cpd_filter_tags($learning_outcomes)); ?>
                        
                        <?php
					}
					
					// @TODO - Wrap this in an 'if it exists then display' 
					
					
					// Presentations
					$presentations = cpd_get_presentations($post->ID);
					
					$i = 1;
					foreach($presentations as $pres_id => $title){
						
						$venue_id = get_post_meta($pres_id, 'venue', true);
						if($venue_id == 0){
							//Its online study so display that
							$venue = 'Online Study';
						}
						else{
							//else grab all the venue info
							$venue = cpd_get_venue($venue_id);
						}

						if($i == 1){ ?>
							
							<div class='presentations'>
								<h3>Study Dates and Venues</h3>
								<div id="presentations">
							
								<?php $needs_closing = true; // so we know to close the div after the loop ?>
						
						<?php }	?>
						
						<div class="presentation_box">
						
							<h4><?php echo $title; ?></h4>
                            <button class='clickme' data="<?php echo $i; ?>">View Times</button>

                            <div class="horizontal_rule"></div>

                            <p class="venue_text">
                            	<span class="bold">Venue: </span>

                            		<?php 
                        			if ($venue == 'Online Study') {
                        				echo $venue;
                        			}
                        			else {
                        				echo $venue['venue_short_title']; 
                        			}
                            		?>
                            </p>

                            <p class="start_time">
                            	<span class="bold">Starts: </span>
                            	<?php echo date("D jS M Y", strtotime(get_post_meta($pres_id, 'start', true))); ?>
                            </p>
                            
                            <?php /* Old layout....
                            <p class="startdate" style="float: left; width: 210px; margin-right: 10px">Starts- <?php echo date("l d M Y", strtotime(get_post_meta($pres_id, 'start', true))); ?></p> 
							<p class="venue" style="float: left">@<?php echo $venue['venue_short_title']; ?></p>
								<button style='float: right' class='clickme' data="<?php echo $i; ?>">View Times</button>
                                
                            */ ?>
                                
						
								<div id="session_times_<?php echo $i; ?>" class="session_times">
                                	<h5>Session Times:</h5>
                                	<div class="horizontal_rule_2"></div>
                                	<div class="session_times_content">
										<?php echo get_post_meta($pres_id, 'session_times', true); ?>
										<p class="disclaimer">Study dates and times are subject to change.</p>
									</div>
								</div>						
								
						</div>
						
						<?php $i++; 
					}
					if($needs_closing){
						echo '</div></div>';
					}
					
					
					
					
					// Application Procedure & Contact Us
					$application_procedure = trim(get_post_meta($post->ID, 'application_procedure', true)); // trim it, - so won't display even if there's just whitespace in DB
					$contact_us = trim(get_post_meta($post->ID, 'contact_us', true)); // trim it, - so won't display even if there's just whitespace in DB
					
					// Put the heading in if either exist...
					if($application_procedure || $contact_us){
						?>
                        
                        	<h3>Further Information</h3>

                        <?php
					}
					
					// Application Prodecure
					if($application_procedure || $contact_us){
						
						echo wpautop(cpd_filter_tags($application_procedure));
                        
					}
					
					// Contact Us
					if($contact_us){
						
						echo wpautop(cpd_filter_tags($contact_us)); 
					}
					
					// Pathways
					$pathways = trim(get_post_meta($post->ID, 'pathways', true)); // trim it, - so won't display even if there's just whitespace in DB
					if($pathways){
						?>
                        	<h3>Pathways</h3>
                            <?php echo wpautop(cpd_filter_tags($pathways)); ?>
                        
                        <?php
					}
					
					?>
                    
                    
                    
                    
                    
                    <?php /*
                    <h1>Dev area...</h1>
                    <div style="background: #eee; padding: 10px">
                        <h2>Subjects</h2>
                        <?php 
                        
                        $subjects = get_the_terms($post->ID, 'subjects'); 
                        
                        foreach($subjects as $subject){
                            echo "<p>" . $subject->term_id . " - " .  ucfirst($subject->name) . "</p>";
                        }
                        //print_r($subjects);
                        
                        ?>	
                        
                        
                        <h2>Keywords</h2>
                        <?php
                        $keywords = get_the_terms($post->ID, 'keywords'); 
                        foreach($keywords as $keyword){
                            echo "<p>" . $keyword->term_id . " - " .  ucfirst($keyword->name) . "</p>";
                        }
                        
                        //print_r($keywords);
                        
                        ?>
                        
                        <h2>Related Courses</h2>
                        <?php
                            
                            // Get this courses subjects, and pull all the other subjects in that field...
                            
                            global $wpdb;
                            reset($subjects); // Using the same array as before, so we reset it
                            
                            foreach($subjects as $subject){
                                
                                echo "<h3>" . ucfirst($subject->name) . "</h3>";
                                
                                $courses = $wpdb->get_results(
                                    "
                                    SELECT 	id, post_title 
                                    FROM 	$wpdb->posts 
                                    WHERE 	id 
                                    IN 		
                                        (SELECT object_id 
                                         FROM $wpdb->term_relationships 
                                         WHERE term_taxonomy_id = 
                                            (SELECT term_taxonomy_id 
                                             FROM $wpdb->term_taxonomy 
                                             WHERE term_id = '$subject->term_id' AND taxonomy = 'subjects'))
                                    ");
                                echo "<ul>";
                                foreach($courses as $course){
                                    if($course->id != $post->ID){
                                        echo '<li><a href="' .get_permalink($course->id). '">' .$course->post_title. '</a></li>';
                                    }
                                }
                                echo "</ul>";
                            }
                        
                            /*
                            
                            echo "<h2>Presentations - (Dev Area)</h2>";
                            echo "<h3>Testing new function</h3>";
                            
                            $course = cpd_get_course_and_presentation_info($post->ID);
                            
                            print_r($course);
                            
                            echo "<h2>More tests...</h2>";
                            
                            foreach($course as $thing){
                                foreach($thing as $pres_id => $value){
                                echo "$key $value<br />";
                                }
                            }
                            */
                            
                            
                            /*
                            // Get each of the presentations, display all their info...
                            $presentations = cpd_get_presentations($post->ID);
    
                            foreach($presentations as $id => $title){
                                ?>
                                
                                
                                
                                
                                <?php
                            }
                            */
                        
                        
                        // KEYWORDS
                        /* These go somewhere else...
                        $keywords = trim(get_post_meta($post->ID, 'keywords', true)); // trim it, - so won't display even if there's just whitespace in DB
                        if($keywords){
                            ?>
                                <h3>Keywords</h3>
                                <?php echo wpautop(cpd_filter_tags($keywords)); ?>
                            
                            <?php
                        }
                        */
                    
                    
                        /* RELATED PRESENTATION INFO 
                        - gives links to linked presentations 
                        echo "<h3>Related Presentations</h3>";
                        $presentations = cpd_get_presentations($post->ID); 
                        foreach($presentations as $id => $title){
                            ?>
                                <a href="<?php echo get_permalink($id); ?>"><?php echo $title; ?></a>
                            <?php
                        }
                        */
                    /*?>
                    </div> Close dev div -->
					
					*/
					
					?>
                    
                    
                    
                    
		</div><!--/cpd_course_page -->
        <div class="cpd_sidebar">
        	
            
            <?php
				
				$subjects = get_the_terms($post->ID, 'subjects'); 
				// "Courses you might be interested in..." section
				global $wpdb;
				// loop throught the related subjects to see if there are any different ones, if there aren't don't display the title, if there are, reloop through them and display them
				if($subjects){
					
					reset($subjects); // Because we used it before
					foreach($subjects as $subject){
						
						$courses = $wpdb->get_results(
							"
							SELECT 	id, post_title 
							FROM 	$wpdb->posts 
							WHERE 	id 
							IN 		
								(SELECT object_id 
								 FROM $wpdb->term_relationships 
								 WHERE term_taxonomy_id = 
									(SELECT term_taxonomy_id 
									 FROM $wpdb->term_taxonomy 
									 WHERE term_id = '$subject->term_id' AND taxonomy = 'subjects'))
							"
						);
						foreach($courses as $course){
							if($course->id != $post->ID){
								$is_course = true;
							}
						}
						
					}
					
					if($is_course){
						
						echo "<h2>Courses you might be interested in...</h2>";
						reset($subjects); // Using the same array as before, so we reset it
							
						foreach($subjects as $subject){
							
							echo "<h3>" . ucfirst($subject->name) . "</h3>";
							
							$courses = $wpdb->get_results(
								"
								SELECT 	id, post_title 
								FROM 	$wpdb->posts 
								WHERE 	id 
								IN 		
									(SELECT object_id 
									 FROM $wpdb->term_relationships 
									 WHERE term_taxonomy_id = 
										(SELECT term_taxonomy_id 
										 FROM $wpdb->term_taxonomy 
										 WHERE term_id = '$subject->term_id' AND taxonomy = 'subjects'))
								");
							echo "<ul>";
							foreach($courses as $course){
								if($course->id != $post->ID){
									echo '<li><a href="' .get_permalink($course->id). '">' .$course->post_title. '</a></li>';
								}
							}
							echo "</ul>";
						}
					}
				}
			?>
            
            
	  	</div>
            

<?php get_footer(); ?>