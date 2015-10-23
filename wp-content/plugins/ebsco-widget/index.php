<?php
/*
Plugin Name: EbscoWidget
Plugin URI: TODO
Description: Integrates the react EbscoWidget plugin into your WordPress install.
Version: 0.1
Author: BibCnrs
Author URI: https://github.com/BibCnrs/BibCnrs
*/

defined('ABSPATH') or die('Plugin file cannot be accessed directly.');

if (!class_exists('EbscoWidget')) {
    class EbscoWidget
    {
        /**
         * Tag identifier used by file includes.
         * @var string
         */
        protected $tag = 'ebsco_widget';

        /**
         * User friendly name used to identify the plugin.
         * @var string
         */
        protected $name = 'EBBSCO Widget';

        /**
         * Current version of the plugin.
         * @var string
         */
        protected $version = '0.1';

        /**
         * List of settings displayed on the admin settings page.
         * @var array
         */
        protected $settings = array();

        public function __construct()
        {
            if ($options = get_option($this->tag)) {
                $this->options = $options;
            }
            add_shortcode($this->tag, array(&$this, 'shortcode'));
            if (is_admin()) {
                add_action('admin_init', array(&$this, 'settings'));
            }
        }

        /**
         * Allow the ebsco-widget shortcode to be used.
         *
         * @access public
         * @param array $atts
         * @param string $content
         * @return string
         */
        public function shortcode($atts, $content = null)
        {
            extract(shortcode_atts(array(), $atts));
            $this->_enqueue();
            ob_start();
            ?>
                <div id="ebsco-widget"></div>
            <?php
            return ob_get_clean();
        }

        /**
         * Add the setting fields to the Reading settings page.
         *
         * @access public
         */
        public function settings()
        {

        }

        protected function _enqueue()
        {
            // Define the URL path to the plugin...
            // Enqueue the styles in they are not already...
            if (!wp_style_is($this->tag, 'enqueued')) {

                wp_register_style(
                    $this->tag,
                    plugins_url('ebsco-widget.css', __FILE__)
                );
                wp_enqueue_style($this->tag);
            }
            // Enqueue the scripts if not already...

            if (!wp_script_is($this->tag, 'enqueued')) {
                wp_register_script(
                    $this->tag,
                    plugins_url('ebsco-widget.js', __FILE__),
                    array(),
                    $this->version,
                    true
                );
                // Make the options available to JavaScript...
                // $options = array_merge(array(
                //     'selector' => '.' . $this->tag
                // ), $this->options);
                // wp_localize_script($this->tag, $this->tag, $options);
                wp_enqueue_script($this->tag);
            }
        }
    }
    new EbscoWidget;
}
?>
