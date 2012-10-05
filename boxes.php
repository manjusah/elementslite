<?php
/**
 * Title: Boxes Element
 *
 * FIXME: Displays custom post type Boxes
 *
 * Please do not edit this file. This file is part of the Cyber Chimps Framework and all modifications
 * should be made in a child theme.
 * FIXME: POINT USERS TO DOWNLOAD OUR STARTER CHILD THEME AND DOCUMENTATION
 *
 * @category Cyber Chimps Framework
 * @package  Framework
 * @since    1.0
 * @author   CyberChimps
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.cyberchimps.com/
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

function cyberchimps_init_boxes_post_type() {
	register_post_type( 'boxes',
		array(
			'labels' => array(
				'name' => __('Boxes', 'cyberchimps'),
				'singular_name' => __('Boxes', 'cyberchimps'),
			),
			'public' => true,
			'show_ui' => true, 
			'supports' => array('title'),
			'taxonomies' => array( 'boxes_categories'),
			'has_archive' => true,
			'menu_icon' => get_template_directory_uri() . '/cyberchimps/lib/images/custom-types/boxes.png',
			'rewrite' => array('slug' => 'boxes')
		)
	);
	
	$meta_boxes = array();
	
	$mb = new Chimps_Metabox('boxes', 'Boxes Element', array('pages' => array('boxes')));
	$mb
		->tab("Boxes Element")
			->single_image('cyberchimps_box_image', 'Box Image', '')
			->text('cyberchimps_box_url', 'Box URL', '')
			->textarea('cyberchimps_box_text', 'Box Text', '')
		->end();
		
	foreach ($meta_boxes as $meta_box) {
		$my_box = new RW_Meta_Box_Taxonomy($meta_box);
	}
}
add_action( 'init', 'cyberchimps_init_boxes_post_type' );

add_action( 'boxes', 'boxes_render_display' );

// Define content for boxes
function boxes_render_display() {
	
	// Intialize box counter
	$box_counter = 1;
	
	// Custom box query
	$args = array(
						'numberposts'     => 3,
						'offset'          => 0,
						'orderby'         => 'post_date',
						'order'           => 'ASC',
						'post_type'       => 'boxes',
						'post_status'     => 'publish'
					);
	$boxes = get_posts( $args );
?>
	<div id="widget-boxes-container" class="row-fluid">
		<div class="boxes">
		<?php	
		foreach( $boxes as $box ):
				
				// Break after desired number of boxes displayed
				if( $box_counter > 3 )
					break;
				
				// Get the image of the box
				$box_image = get_post_meta( $box->ID, 'cyberchimps_box_image', true );
				
				// Get the URL of the box
				$box_url = get_post_meta( $box->ID, 'cyberchimps_box_url', true );
				// Get the text of the box
				$box_text = get_post_meta( $box->ID, 'cyberchimps_box_text', true );
		?>	
				<div id="box<?php echo $box_counter?>" class="box span4">
					<a href="<?php echo $box_url; ?>">
						<img class="box-image" src="<?php echo $box_image; ?>" />
          </a>
					<h2 class="box-widget-title"><?php echo $box->post_title; ?></h2>
					<p><?php echo $box_text; ?></p>
				</div><!--end box1-->
		<?php   
			$box_counter++;
			endforeach;
		?>
		</div><!-- end boxes -->
	</div><!-- end row-fluid -->
<?php		
} 
?>