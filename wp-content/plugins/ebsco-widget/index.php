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
        protected $settings = array('url' => array(
            'description' => 'url pour accéder à BibCnrs Api',
            'validator' => 'url',
            'type' => 'url',
            'placeholder' => 'http://BibCnrsHost'
        ));

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
            $section = 'general';
            add_settings_section(
                $this->tag . '_settings_section',
                'Réglages pour ' . $this->name,
                function () {
                    echo '<p>Options de configurations pour le plugin ' . esc_html( $this->name ) . '.</p>';
                },
                $section
            );
            foreach ( $this->settings AS $id => $options ) {
                $options['id'] = $id;
                add_settings_field(
                    $this->tag . '_' . $id . '_settings',
                    $id,
                    array( &$this, 'settings_field' ),
                    $section,
                    $this->tag . '_settings_section',
                    $options
                );
            }
            register_setting(
                $section,
                $this->tag,
                array( &$this, 'settings_validate' )
            );
        }

        /**
         * Append a settings field to the the fields section.
         *
         * @access public
         * @param array $args
         */
        public function settings_field( array $options = array() )
        {
            $atts = array(
                'id' => $this->tag . '_' . $options['id'],
                'name' => $this->tag . '[' . $options['id'] . ']',
                'type' => ( isset( $options['type'] ) ? $options['type'] : 'text' ),
                'class' => 'small-text',
                'value' => ( array_key_exists( 'default', $options ) ? $options['default'] : null )
            );
            if ( isset( $this->options[$options['id']] ) ) {
                $atts['value'] = $this->options[$options['id']];
            }
            if ( isset( $options['placeholder'] ) ) {
                $atts['placeholder'] = $options['placeholder'];
            }
            if ( isset( $options['type'] ) && $options['type'] == 'checkbox' ) {
                if ( $atts['value'] ) {
                    $atts['checked'] = 'checked';
                }
                $atts['value'] = true;
            }
            if ( isset( $options['type'] ) && $options['type'] == 'url' ) {
                $atts['type'] = 'url';
                $atts['class'] = 'regular-text code';
            }
            array_walk( $atts, function( &$item, $key ) {
                $item = esc_attr( $key ) . '="' . esc_attr( $item ) . '"';
            } );
            ?>
            <label>
                <input <?php echo implode( ' ', $atts ); ?> />
                <?php if ( array_key_exists( 'description', $options ) ) : ?>
                <?php esc_html_e( $options['description'] ); ?>
                <?php endif; ?>
            </label>
            <?php
        }

        /**
         * Validate the settings saved.
         *
         * @access public
         * @param array $input
         * @return array
         */
        public function settings_validate( $input )
        {
            $errors = array();
            foreach ( $input AS $key => $value ) {
                if ( $value == '' ) {
                    unset( $input[$key] );
                    continue;
                }
                $validator = false;
                if ( isset( $this->settings[$key]['validator'] ) ) {
                    $validator = $this->settings[$key]['validator'];
                }
                switch ( $validator ) {
                    case 'url':
                        $pattern = '/^http(s)?:\/\/.*$/';
                        if ( preg_match($pattern, $value) ) {
                            $input[$key] = $value;
                        } else {
                            $errors[] = $key . ' doit être un url valide.';
                            unset( $input[$key] );
                        }
                    break;
                    default:
                         $input[$key] = strip_tags( $value );
                    break;
                }
            }
            if ( count( $errors ) > 0 ) {
                add_settings_error(
                    $this->tag,
                    $this->tag,
                    implode( '<br />', $errors ),
                    'error'
                );
            }
            return $input;
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
                wp_register_script(
                    $this->tag.'-index',
                    plugins_url("index.js", __FILE__),
                    array('jquery', $this->tag),
                    $this->version,
                    true
                );

                $term = get_query_var('term');
                // add url attribute on script tag
                add_filter( 'script_loader_tag', function ( $tag, $handle ) use ($term) {
                    if ( $handle !== 'ebsco_widget-index' ) return $tag;
                    return str_replace( ' src', ' id="'. $handle .'" data-url="' . ($this->options['url']) . '" data-term="' . $term . '" src', $tag );
                }, 10, 2 );
                wp_enqueue_script($this->tag.'-index');
            }
        }
    }
    new EbscoWidget;
}
?>
