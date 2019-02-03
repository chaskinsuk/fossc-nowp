<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 *
 * @package ShuttleThemes
 */

get_header(); ?>
			
			<?php 
			$shuttle_general_breadcrumbswitch = shuttle_var ( 'shuttle_general_breadcrumbswitch' );
			if ( ! is_front_page() ) {

				// Determine if breadcrumb is enables. Ensures table-cells align correctly with css
				if ( $shuttle_general_breadcrumbswitch == '1' ) {
					$class_intro = 'option2';
				} else {
					$class_intro = 'option1';	
				}

				// If no breadcrumbs are available on current page then change intro class to option1
				if ( shuttle_input_breadcrumbswitch() == '' ) { 
					$class_intro = 'option1'; 
				}

				// Output intro with breadcrumbs if set
				if ( empty( $shuttle_general_introswitch ) or $shuttle_general_introswitch == '1' ) {
					echo	shuttle_input_breadcrumbswitch();
				}
			} ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; wp_reset_postdata(); ?>

<?php get_footer(); ?>