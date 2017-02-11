<?php
/*
Plugin Name: Alekos Posts Plugin
Plugin URI: http://www.alekos.fr
Description: Un plugin pour afficher des articles
Version: 0.1
Author: Alexandre Gitakos
Author URI: http://www.alekos.fr
License: GPLv2
*/
 
class Alekos_posts extends WP_Widget {
    
    function Alekos_posts() {
        $widget_ops = array(
            'classname' => 'alekos_posts',
            'description' => 'Affichage d\'une liste d\'articles'
        );
        
        $control_ops = array(
            'width' => 300,
            'height' => 350,
            'id_base' => 'alekos_posts'
        );
        
        $this->WP_Widget('alekos_posts', 'Alekos Posts Plugin', $widget_ops, $control_ops);
    }

    function widget($args, $instance) {
        
        extract($args);
        global $post;
        
        echo $before_widget;
        
        if ($instance['title'] != '') {
            echo $before_title . $instance['title'] . $after_title ;
        }

        if ($instance['category'] != '') {
            $args = array( 'category' => $instance['category'] );
        } else {
            $args = '';
        }
        
        $my_posts = get_posts($args);
        add_image_size( 'taille', 100, 150 );
            
        echo '<ul>';
        foreach ($my_posts as $post) {
            echo '<li>';
            echo the_post_thumbnail('taille');
            echo '<a href="' . get_the_permalink() . '"> ' . get_the_title() . '</a>';
            echo '<p>' . get_the_excerpt() . '</p>';
            echo '</li>';
        }
        
        echo '</ul>';
        
        wp_reset_postdata();
        
        echo $after_widget;
        
    }
    
    function update($new_instance, $old_instance) {
        
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['category'] = strip_tags($new_instance['category']);
        return $instance;
    }
    
    function form($instance) {
        $defaults = array('title' => 'Publications');
        $instance = wp_parse_args($instance, $defaults);
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Titre : </label>
            
            <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('category'); ?>">Catégorie : </label>
            <select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" value="<?php echo $instance['category']; ?>" style="width:100%;">
            <option>Toutes les catégories</option>
            <?php
                foreach ( (get_categories()) as $cat ) {
                    if ( $instance['category'] == $cat->cat_ID ) {
                        $selected = 'selected="selected"'; }
                    else {
                        $selected = '';
                    }
                        echo'<option value="' . $cat->$cat_ID . '">' . $cat->cat_name . '</option>'; 
                }
            ?>
            </select>
        </p>
<?php
                              
    }
}

function register_my_widget() {
register_widget('Alekos_posts');
}

add_action('widgets_init', 'register_my_widget');

?>