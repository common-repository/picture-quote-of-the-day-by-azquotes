<?php
/*  Copyright 2013 Xplore, Inc. 

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
/*
  Plugin Name: AZQuote Widget
  Plugin URI: http://www.azquotes.com/link/wordpress_plugin.html
  Description: There are millions of interesting quotations. Everyday we choose some of the best with our own hands. Add our Quote of the Day to your website. Inspire, educate and entertain your visitors. To install, сlick the 'Activate' link to the left of this text, then go to Appearance > Widgets and look for the 'AZQuote Widget'.
  Version: 1.1
  Author: AZQuotes
  Author URI: http://www.azquotes.com
 */

/**
 * Adds AZQuote_Widget widget.
 */
class AZQuotes_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'azq_widget', // Base ID
                __('AZQuotes Widget', 'text_domain'), // Name
                array('description' => __('Add our Quote of the Day to your website. Inspire, educate and entertain your visitors.', 'text_domain'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        $qtype = apply_filters('widget_title', $instance['qtype']);

        
        $data = array(
            "qu_c_t"    => array("title" => "Quote of the Day", "url" => "quotes_of_the_day.html"),
            "qu_c_i"    => array("title" => "Quote of the Day", "url" => "quotes_of_the_day.html"),
            "qu_c_ti"   => array("title" => "Quote of the Day", "url" => "quotes_of_the_day.html"),
            "qu_f"      => array("title" => "Funny Quote of the Day", "url" => "quotes/topics/funny.html"),
            "qu_m"      => array("title" => "Motivational Quote of the Day", "url" => "quotes/topics/motivational.html"),
            "qu_l"      => array("title" => "Love Quote of the Day", "url" => "quotes/topics/love.html"),
        );

        echo $args['before_widget'];
        
        if (!empty($qtype)){
            echo $args['before_title'] . $data[$qtype]['title'] . $args['after_title'];
        }

        echo __('<script type="text/javascript" src="http://www.azquotes.com/widgets/link/' . $qtype . '_wpp.js"></script><small><i><a href="http://www.azquotes.com/' . $data[$qtype]['url'] . '" target="_blank">more Quotes</a></i></small>', 'text_domain');
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        if (isset($instance['qtype'])) {
            $qtype = $instance['qtype'];
        } else {
            $qtype = "qu_c_t";
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('qtype'); ?>">What type of quotes would you like?</label> 
            <select id="<?php echo $this->get_field_id('qtype'); ?>" name="<?php echo $this->get_field_name('qtype'); ?>" class="widefat" style="width:100%;">
                <option value="qu_c_t" <?php if ('qu_c_t' == $qtype) echo 'selected="selected"'; ?>>Quote of the Day (Text only)</option>
                <option value="qu_c_i" <?php if ('qu_c_i' == $qtype) echo 'selected="selected"'; ?>>Quote of the Day (Image only)</option>
                <option value="qu_c_ti" <?php if ('qu_c_ti' == $qtype) echo 'selected="selected"'; ?>>Quote of the Day (Text+Image)</option>
                <option value="qu_f" <?php if ('qu_f' == $qtype) echo 'selected="selected"'; ?>>Funny Quote of the Day</option>
                <option value="qu_m" <?php if ('qu_m' == $qtype) echo 'selected="selected"'; ?>>Motivational Quote of the Day</option>
                <option value="qu_l" <?php if ('qu_l' == $qtype) echo 'selected="selected"'; ?>>Love Quote of the Day</option>
            </select>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['qtype'] = (!empty($new_instance['qtype']) ) ? strip_tags($new_instance['qtype']) : '';

        return $instance;
    }

}

// class AZQuote_Widget
// register AZQuote_Widget widget
function register_azq_widget() {
    register_widget('AZQuotes_Widget');
}

add_action('widgets_init', 'register_azq_widget');
?>
