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
        $widgetDir = get_home_path() . "wp-content/node_modules/bibcnrs-widget";
        $widgetUrl = home_url() . DIRECTORY_SEPARATOR . "wp-content/node_modules/bibcnrs-widget";

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

        // Enqueue the scripts if not already...
        if (!wp_script_is($config->tag, 'enqueued')) {
            wp_register_script(
                $config->tag,
                $widgetUrl . DIRECTORY_SEPARATOR . 'build/app.js',
                [],
                $json['version'],
                true
            );
            wp_enqueue_script($config->tag);
            wp_register_script(
                $config->tag.'-widget',
                get_theme_root_uri() . DIRECTORY_SEPARATOR . portail . DIRECTORY_SEPARATOR . 'js/BibHeaderWidget.js',
                [],
                $json['version'],
                true
            );

            wp_enqueue_script($config->tag.'Widget');

        }

        Timber::render('widget.twig', [
            "tag" => $config->tag
        ]);
    };
};
