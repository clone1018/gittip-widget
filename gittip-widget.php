<?php
/*
Plugin Name: Gittip Widget
Plugin URI: https://github.com/clone1018/gittip-widget
Description: Display your Gittip widget on your wordpress blog.
Version: 1.0
Author: <a href="http://axxim.net/">Luke Strickland</a>
License:

    This is free and unencumbered software released into the public domain.

    Anyone is free to copy, modify, publish, use, compile, sell, or
    distribute this software, either in source code form or as a compiled
    binary, for any purpose, commercial or non-commercial, and by any
    means.

    In jurisdictions that recognize copyright laws, the author or authors
    of this software dedicate any and all copyright interest in the
    software to the public domain. We make this dedication for the benefit
    of the public at large and to the detriment of our heirs and
    successors. We intend this dedication to be an overt act of
    relinquishment in perpetuity of all present and future rights to this
    software under copyright law.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
    EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
    MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
    IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR
    OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
    ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
    OTHER DEALINGS IN THE SOFTWARE.

    For more information, please refer to [http://unlicense.org]
*/

class GittipWidget extends WP_Widget {

    protected $defaults;

    public function __construct() {

        $this->defaults = array(
            'username' => ''
        );

        $widgetOptions = array(
            'classname' => 'gittip-widget',
            'description' => 'Displays a Gittip widget'
        );

        $controlOptions = array(
            'id_base' => 'gittip-widget'
        );

        $this->WP_Widget('gittip-widget', 'Gittip Widget', $widgetOptions, $controlOptions);
    }

    public function widget($args, $instance) {

        $instance = wp_parse_args((array)$instance, $this->defaults);
        $username = esc_attr($instance['username']);

        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . $instance['title'] . $args['after_title'];
        }

        echo "<script data-gittip-username='$username' src='//gttp.co/v1.js'></script>";

        echo $args['after_widget'];
    }

    public function update($newInstance, $oldInstance) {
        $newInstance['title'] = strip_tags($newInstance['title']);
        $newInstance['username'] = strip_tags($newInstance['username']);

        return $newInstance;
    }

    public function form($instance) {

        $instance = wp_parse_args((array)$instance, $this->defaults);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                Title:
            </label>
            <input type="text" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>"
                   value="<?php echo esc_attr($instance['title']); ?>"
                   class="widefat"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('username'); ?>">
                Gittip Username:
            </label>
            <input type="text"
                   id="<?php echo $this->get_field_id('username'); ?>"
                   name="<?php echo $this->get_field_name('username'); ?>"
                   value="<?php echo esc_attr($instance['username']); ?>"
                   class="widefat"/>
        </p>
    <?php
    }
}

add_action('widgets_init', create_function('', "register_widget('GittipWidget');"));
