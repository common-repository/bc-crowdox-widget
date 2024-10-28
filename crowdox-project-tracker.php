<?php
/*
  Plugin Name: BC Crowdox widget
  Description: Widget and shortcode that allows you to pull project informations from Crowdox.
  Version: 1.0
  Plugin URI: http://www.beocode.com/crowdox-project-tracker/
  Author: BeoCode.d.o.o.
  Author URI: http://www.beocode.com/
  Developer: Vesna Spasic
  Developer URI: http://www.beocode.com/
  Text Domain: crowdox-project-tracker
  Requires at least: 4.7.11
  Tested up to: 4.9.8

  Copyright: © 2012-2018 BeoCode.
  License: GNU General Public License, version 2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

class Crowdox_Project_Tracker extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'crowdox_project_tracker',
            __( 'BC Crowdox widget', 'crowdox_project_tracker' ),
            array(
                'customize_selective_refresh' => true,
            )
        );
    }
    

    
    // The widget form (for the backend )
    public function form( $instance ) { 
        $defaults = array(
            'title'    => '',
            'text'     => '',
            'checkbox_title'     => '',
            'checkbox_backer'     => '1',
            'checkbox_pledged'     => '1',
            'checkbox_amount'     => '1',
            'image' => '',
        );
        
        
        
        
        extract( wp_parse_args( ( array ) $instance, $defaults ) );
        

        
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'crowdox_project_tracker' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'Project Url:', 'crowdox_project_tracker' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'checkbox_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'checkbox_title' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $checkbox_title ); ?> />
            <label for="<?php echo esc_attr( $this->get_field_id( 'checkbox_title' ) ); ?>"><?php _e( 'Show Title', 'crowdox_project_tracker' ); ?></label>
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'checkbox_backer' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'checkbox_backer' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $checkbox_backer ); ?> />
            <label for="<?php echo esc_attr( $this->get_field_id( 'checkbox_backer' ) ); ?>"><?php _e( 'Show Total Supporters', 'crowdox_project_tracker' ); ?></label>
        </p>
         <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'checkbox_pledged' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'checkbox_pledged' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $checkbox_pledged ); ?> />
            <label for="<?php echo esc_attr( $this->get_field_id( 'checkbox_pledged' ) ); ?>"><?php _e( 'Show Total Pledged', 'crowdox_project_tracker' ); ?></label>
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'checkbox_amount' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'checkbox_amount' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $checkbox_amount ); ?> />
            <label for="<?php echo esc_attr( $this->get_field_id( 'checkbox_amount' ) ); ?>"><?php _e( 'Show Funded', 'crowdox_project_tracker' ); ?></label>
        </p>
        <p>
            <label for="deo-hidden-input"><?php _e( 'Project Image:', 'crowdox_project_tracker' ); ?></label>
            <img src="<?php echo esc_attr( $image ); ?>" class="deo-media-image" style="width: 100%;">
        </p>      
      <p>
        
        <input type="hidden" class="deo-hidden-input" name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" value="<?php echo esc_attr( $image ); ?>"/>
        <input type="button" class="deo-image-upload-button button button-primary" value="Upload">      
        <input type="button" class="deo-image-delete-button button" value="Remove Image">
      </p>
        

    <?php }
    
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
        $instance['text']     = isset( $new_instance['text'] ) ? wp_strip_all_tags( $new_instance['text'] ) : '';
        $instance['checkbox_title'] = isset( $new_instance['checkbox_title'] ) ? 1 : false;
        $instance['checkbox_backer'] = isset( $new_instance['checkbox_backer'] ) ? 1 : false;
        $instance['checkbox_pledged'] = isset( $new_instance['checkbox_pledged'] ) ? 1 : false;
        $instance['checkbox_amount'] = isset( $new_instance['checkbox_amount'] ) ? 1 : false;
        $instance['image'] = ( ! empty( $new_instance['image'] ) ) ? strip_tags( $new_instance['image'] ) : '';
        
        return $instance;
    }
    
    public function widget( $args, $instance ) {
        extract( $args );
        $title_main    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
        $text     = isset( $instance['text'] ) ? $instance['text'] : '';
        $checkbox_title = ! empty( $instance['checkbox_title'] ) ? $instance['checkbox_title'] : false;
        $checkbox_backer = ! empty( $instance['checkbox_backer'] ) ? $instance['checkbox_backer'] : false;
        $checkbox_pledged = ! empty( $instance['checkbox_pledged'] ) ? $instance['checkbox_pledged'] : false;
        $checkbox_amount = ! empty( $instance['checkbox_amount'] ) ? $instance['checkbox_amount'] : false;
        
        $crow_image_uri     = isset( $instance['image'] ) ? $instance['image'] : '';
       
        
        echo $args['before_widget'];
        if ( $text ) {
            echo '<div id="crowdox" class="wp_widget_crowdox"><a href="'.$text.'" target="_blanc">';
           
            $content = wp_remote_get($text);
            $doc = new DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML($content['body']);
            $finder = new DomXPath($doc);
            
            $node0 = $finder->query("//*[contains(@class, 'ui project header')]");
            $node1 = $finder->query("//*[contains(@class, 'backer amount')]");
            $node2 = $finder->query("//*[contains(@class, 'pledged amount')]");
            $node3 = $finder->query("//*[contains(@class, 'goal amount')]");
            $title = $doc->saveHTML($node0->item(0));
            $backer = $doc->saveHTML($node1->item(0));
            $pledged = $doc->saveHTML($node2->item(0));
            $goal = $doc->saveHTML($node3->item(0));
            
            if($title_main){
                echo '<h2>'.$title_main.'</h2>';
            }
            if($crow_image_uri){
                echo '<img src="'.$crow_image_uri.'" />';
            }
//             ww($crow_image_uri);
            if( $checkbox_title ){
                echo $title;
            }
            if($checkbox_backer){
                echo $backer;
            }
            if($checkbox_pledged){
                echo $pledged;
            }
            if($checkbox_amount){
                echo $goal;
            }

            echo '</a></div>';
        }
        // WordPress core after_widget hook 
        echo $args['after_widget'];
    }
    
}

// Add shortcode
add_shortcode('crowdox','crowdox_project');
function crowdox_project($atts='') {
    
    $value = shortcode_atts( array(
        'url' => 'https://app.crowdox.com/projects/kolossalgames/mezo-relaunch'
    ), $atts );

//      get url content
    $content = wp_remote_get($value['url']);
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML($content['body']);
    $finder = new DomXPath($doc);
//    ww($finder);
 
    $node_hidden = $finder->query("//*[contains(@class, 'hero header')]");
    
    $node0 = $finder->query("//*[contains(@class, 'ui project header')]");
    $node1 = $finder->query("//*[contains(@class, 'backer amount')]");
    $node2 = $finder->query("//*[contains(@class, 'pledged amount')]");
    $node3 = $finder->query("//*[contains(@class, 'goal amount')]");
    
    $hidden = $doc->saveHTML($node_hidden->item(0));
//     ww($hidden);
    $title = $doc->saveHTML($node0->item(0));
    $backer = $doc->saveHTML($node1->item(0));
    $pledged = $doc->saveHTML($node2->item(0));
    $goal = $doc->saveHTML($node3->item(0));

    
    return '<div id="crowdox_shortcode" class="wp_widget_crowdox"><div class="hidden">'.$hidden.'</div><a href="'.$value['url'].'" target="_blanc"><img src="" class="crowdox_pull_image" />'.$title.''.$backer.''.$pledged.''.$goal.'</a></div>';
    
}


// Register the admin widget scripts
function crowdox_admin_enqueue()
{
  wp_enqueue_media();
  wp_enqueue_script('crowdox_admin', plugins_url('/assets/js/crowdox_admin.js', __FILE__ ), array('jquery'), '1.0', 'true');
}
add_action('admin_enqueue_scripts', 'crowdox_admin_enqueue');


// Register the widget style and scripts
add_action('wp_enqueue_scripts','crowdox_scripts');
function crowdox_scripts() {
    wp_enqueue_style( 'crowdox_css', plugins_url( '/assets/css/crowdox_css.css', __FILE__ ) );
    wp_enqueue_script( 'crowdox_js', plugins_url('/assets/js/crowdox.js', __FILE__ ), array('jquery') );
}

// Register the widget
add_action( 'widgets_init', 'crowdox_project_tracker_widget' );
function crowdox_project_tracker_widget() {
    register_widget( 'Crowdox_Project_Tracker' );
}
