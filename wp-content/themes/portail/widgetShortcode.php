<?php
/**
 * [ebsco-widget] shortcode action
 *
 * @param array $atts
 * @param string $content
 * @return string
 */
$getShortcode = function ($config) {
    return function ($atts, $content = null, $a) use ($config)
    {
        $widgetDir = get_home_path() . DIRECTORY_SEPARATOR . "wp-content/node_modules/bibcnrs-widget";
        $string = file_get_contents($widgetDir . "/package.json");
        $json = json_decode($string, true);
        // Define the URL path to the plugin...
        // Enqueue the styles in they are not already...
        if (!wp_style_is($config->tag, 'enqueued')) {

            wp_register_style(
                $config->tag,
                widgetDir . 'build/app.css',
                [],
                $json['version']
            );

            wp_enqueue_style($config->tag);
        }

        // Enqueue the scripts if not already...
        if (!wp_script_is($config->tag, 'enqueued')) {
            wp_register_script(
                $config->tag,
                $widgetDir . 'build/app.js',
                [],
                $json['version'],
                true
            );
            wp_register_script(
                $config->tag.'-widget',
                get_theme_root() . DIRECTORY_SEPARATOR . 'js/widget.js',
                [],
                $json['version'],
                true
            );

            wp_enqueue_script($config->tag.'Widget');
        }

        Timber::render('widget.twig', $config);
    };
};
