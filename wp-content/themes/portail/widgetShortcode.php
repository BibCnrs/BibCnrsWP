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
        $nodeModulesDir = get_home_path() . "wp-content/node_modules";
        $nodeModulesUrl = site_url() . DIRECTORY_SEPARATOR . "wp-content/node_modules";

        $string = file_get_contents($nodeModulesDir . "/bibcnrs-widget/package.json");
        $json = json_decode($string, true);
        // Define the URL path to the plugin...
        // Enqueue the styles in they are not already...
        if (!wp_style_is($config->tag, 'enqueued')) {

            wp_register_style(
                $config->tag,
                $nodeModulesUrl . DIRECTORY_SEPARATOR . '/bibcnrs-widget/build/app.css',
                [],
                $json['version']
            );

            wp_enqueue_style($config->tag);
        }

        if(!wp_script_is('babel-polyfill', 'enqueued')) {
            wp_register_script(
                'babel-polyfill',
                $nodeModulesUrl . DIRECTORY_SEPARATOR . 'babel-polyfill/dist/polyfill.min.js',
                [],
                '6.3.20'
            );
        }

        if(!wp_script_is('react', 'enqueued')) {
            wp_register_script(
                'react',
                $nodeModulesUrl . DIRECTORY_SEPARATOR . 'react/umd/react.production.min.js',
                [],
                '16.2.0'
            );
        }

        if(!wp_script_is('react-dom', 'enqueued')) {
            wp_register_script(
                'react-dom',
                $nodeModulesUrl . DIRECTORY_SEPARATOR . 'react-dom/umd/react-dom.production.min.js',
                ['react'],
                '16.2.0'
            );
        }

        // Enqueue the scripts if not already...
        if (!wp_script_is($config->tag, 'enqueued')) {
            wp_register_script(
                $config->tag,
                $nodeModulesUrl . DIRECTORY_SEPARATOR . 'bibcnrs-widget/build/app.js',
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
