<?php
/**
 * [ebsco-widget] shortcode action
 *
 * @param array $atts
 * @param string $content
 * @return string
 */
$getShortcode = function ($config) {
    return function ($atts = [], $content = null, $a) use ($config)
    {
        $language = $atts['language'];
        if ( !function_exists( 'get_home_path' ) )
	       require_once( dirname(__FILE__) . '/../../../wp-admin/includes/file.php' );
        $widgetDir = get_home_path() . "wp-content/node_modules/bibcnrs-widget";
        $widgetUrl = site_url() . DIRECTORY_SEPARATOR . "wp-content/node_modules/bibcnrs-widget";

        $string = file_get_contents($widgetDir . "/package.json");
        $json = json_decode($string, true);
        // Define the URL path to the plugin...
        // Enqueue the styles in they are not already...
        if (!wp_style_is($config->tag, 'enqueued')) {

            wp_register_style(
                $config->tag,
                $widgetUrl . DIRECTORY_SEPARATOR . 'build/app.css',
                [],
                $json['version']
            );

            wp_enqueue_style($config->tag);
        }

        if(!wp_script_is('babel-polyfill', 'enqueued')) {
            wp_register_script(
                'babel-polyfill',
                $widgetUrl . DIRECTORY_SEPARATOR . 'node_modules/babel-polyfill/dist/polyfill.min.js',
                [],
                '6.3.14'
            );
        }

        if(!wp_script_is('react', 'enqueued')) {
            wp_register_script(
                'react',
                $widgetUrl . DIRECTORY_SEPARATOR . 'node_modules/react/dist/react-with-addons.min.js',
                [],
                '0.14.3'
            );
        }

        if(!wp_script_is('react-dom', 'enqueued')) {
            wp_register_script(
                'react-dom',
                $widgetUrl . DIRECTORY_SEPARATOR . 'node_modules/react-dom/dist/react-dom.min.js',
                ['react'],
                '0.14.3'
            );
        }

        // Enqueue the scripts if not already...
        if (!wp_script_is($config->tag, 'enqueued')) {
            wp_register_script(
                $config->tag,
                $widgetUrl . DIRECTORY_SEPARATOR . 'build/app.js',
                ['babel-polyfill', 'react', 'react-dom'],
                $json['version'],
                true
            );
            wp_enqueue_script($config->tag);
        }

        if (!wp_script_is($config->tag . '-init', 'enqueued')) {
            wp_register_script(
                $config->tag . '-init',
                get_theme_root_uri() . DIRECTORY_SEPARATOR . 'portail' . DIRECTORY_SEPARATOR . 'js/'.$config->tag.'Init.js',
                [$config->tag],
                $json['version'],
                true
            );

            // add filter to bibcnrs widget
            add_filter('script_loader_tag', function ( $tag, $handle ) use ($config, $language) {
                if ($handle != $config->tag . '-init') return $tag;
                $addedAttr = sprintf(' id="%s" data-language="%s" src', $handle, $language);

                return str_replace(' src', $addedAttr, $tag);
            }, 10, 2);

            wp_enqueue_script($config->tag . '-init');
        }

        Timber::render('widget.twig', [
            "tag" => $config->tag
        ]);
    };
};
