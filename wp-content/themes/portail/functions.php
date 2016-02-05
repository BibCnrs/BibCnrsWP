<?php

function modify_contact_methods($profile_fields) {

    // Add new fields
    $profile_fields['domain'] = 'Domaine';

    return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');

/********************************************************************************************

Add Database type posts

********************************************************************************************/
$dataBases = [
    'public' => true,
    'supports' => ['title', 'editor', 'thumbnail'],
    'labels' => [
        'name' => 'Bases de donnees',
        'add_new_item' => 'Ajouter une base',
        'edit_item' => 'Editer une base',
    ]

];
register_post_type( 'database', $dataBases);

register_taxonomy("databases", array("database"), array("hierarchical" => true, "label" => "Domaines", "singular_label" => "Domaine", "rewrite" => true));

add_action("admin_init", "admin_init");
function admin_init(){
    add_meta_box("db_url-meta", "URL base", "db_url", "database", "normal", "low");
}
function db_url(){
  global $post;
  $custom = get_post_custom($post->ID);
  $db_url = $custom["db_url"][0];
  ?>
  <label>URL</label>
  <input name="db_url" value="<?php echo $db_url; ?>" />
  <?php
}
add_action('save_post', 'save_details');
function save_details(){
    global $post;
    update_post_meta ($post->ID, "db_url", $_POST["db_url"]);
}


/********************************************************************************************

appel script mobile menu select*
src http://codex.wordpress.org/Function_Reference/wp_enqueue_script

********************************************************************************************/
function bsn_scripts_method() {
    wp_enqueue_script(
        'dropdownmenu',
        get_stylesheet_directory_uri() . '/js/dropdownmenu.js',
        ['jquery']
    );
}
add_action('wp_enqueue_scripts', 'bsn_scripts_method');

/*********************************************************************************************

Ajout au contexte Definition des Menus

*********************************************************************************************/
register_nav_menus([
    'principal' => __( 'Principal'),
    'secondaire' => __( 'Secondaire'),
]);

add_filter('timber_context', 'add_to_context');
function add_to_context($data) {
    /* So here you are adding data to Timber's context object, i.e...
    $data['foo'] = 'I am some other typical value set in your functions.php file, unrelated to the menu';
    */
    /* add a Timber menu and send it along to the context. */
    $data['principal'] = new TimberMenu('principal');
    $data['secondaire'] = new TimberMenu('secondaire');

    return $data;
}

/*********************************************************************************************

suppression des tags <p> dans description de la categorie

*********************************************************************************************/
remove_filter('term_description','wpautop');

/*********************************************************************************************

suppose rajouter une classe categorie a body pour les post

*********************************************************************************************/

// Add specific CSS class by filter
add_filter('body_class', 'my_class_names');
function my_class_names($classes) {
    // add 'class-name' to the $classes array
    $classes[] = 'class-name';
    // return the $classes array
    return $classes;
}

/*********************************************************************************************

Add Thumbnail Support

*********************************************************************************************/
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 100, 100, true ); // Normal post thumbnails
add_image_size( 'single-post-image', 720, 320, TRUE );

/*********************************************************************************************

Replaces the excerpt "more" text by a link

*********************************************************************************************/
function new_excerpt_more($more) {
    return '..';
}
add_filter('excerpt_more', 'new_excerpt_more');

function custom_excerpt_length($length) {
    return 15;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
