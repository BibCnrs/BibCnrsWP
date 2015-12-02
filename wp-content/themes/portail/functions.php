<?php
/********************************************************************************************

force user to login before accessing the site

********************************************************************************************/
function force_login() {
    if (is_ssl()) {
        add_filter('login_url', 'login_https', 10, 1);
        function login_https($login_url) {
            return str_replace('http:', 'https:', $login_url);
        }
    }
    if (!is_user_logged_in() && !is_page('login')) {
        auth_redirect();
    }
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

/* $data['principal_fr'] = wp_nav_menu( array('depth' => 1,  'menu'=>'principal-fr',  'walker'=> new Custom_Walker_Nav_Menu()));
*/

/*********************************************************************************************

Definition des Widgets

*********************************************************************************************/

register_sidebar(['name'=>'widget-f1', 'id' => 'sidebar-1', 'before_widget' => '<div class=box-container>', 'after_widget' => '</div>','before_title' => '<h2 class=widget1>', 'after_title' => '</h2>', ]);
register_sidebar(['name'=>'widget-f2', 'id' => 'sidebar-2', 'before_widget' => '<div class=box-container>', 'after_widget' => '</div>','before_title' => '<h2 class=widget2>', 'after_title' => '</h2>', ]);
register_sidebar(['name'=>'widget-f3', 'id' => 'sidebar-3', 'before_widget' => '<div class=box-container>', 'after_widget' => '</div>','before_title' => '<h2 class=widget3>', 'after_title' => '</h2>', ]);
register_sidebar(['name'=>'widget-f4', 'id' => 'sidebar-4', 'before_widget' => '<div class=box-container>', 'after_widget' => '</div>','before_title' => '<h2 class=widget4>', 'after_title' => '</h2>', ]);
register_sidebar(['name'=>'widget-f5', 'id' => 'sidebar-5', 'before_widget' => '<div class=box-container>', 'after_widget' => '</div>','before_title' => '<h2 class=widget5>', 'after_title' => '</h2>', ]);
register_sidebar(['name'=>'widget-f6', 'id' => 'sidebar-6', 'before_widget' => '<div class=box-container>', 'after_widget' => '</div>','before_title' => '<h2 class=widget6>', 'after_title' => '</h2>', ]);
register_sidebar(['name'=>'widget-f7', 'id' => 'sidebar-7', 'before_widget' => '<div class=box-container>', 'after_widget' => '</div>','before_title' => '<h2 class=widget7>', 'after_title' => '</h2>', ]);


/*********************************************************************************************

Adding Translation Option

*********************************************************************************************/
load_theme_textdomain('site5framework', get_template_directory().'/languages');
$locale = get_locale();
$locale_file = get_template_directory()."/languages/$locale.php";
if (is_readable($locale_file) ) {
    require_once($locale_file);
}

function get_cat_slug($cat_id) {
    $category = &get_category($cat_id);

    return $category->slug;
}

/*********************************************************************************************

interpretation php dans les widgets

*********************************************************************************************/

add_filter('widget_text','execute_php',100);
function execute_php($html){
     if(strpos($html,"<?php")!==false){
          ob_start();
          eval("?>".$html);
          $html=ob_get_contents();
          ob_end_clean();
     }
     return $html;
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



// add category nicenames in body and post class
function category_id_class($classes) {
    global $post;
    foreach((get_the_category($post->ID)) as $category) {
        $classes[] = $category->category_nicename;
    }
    return $classes;
}
add_filter('post_class', 'category_id_class');
add_filter('body_class', 'category_id_class');




/*********************************************************************************************

Add Thumbnail Support

*********************************************************************************************/
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 100, 100, true ); // Normal post thumbnails
add_image_size( 'single-post-image', 720, 320, TRUE );



/*********************************************************************************************

Adding Nav Menus

*********************************************************************************************/
add_action( 'init', 'register_my_menus' );
function register_my_menus() {
    register_nav_menus([
        'main-menu' => __( 'Main Menu' ),
    ]);
}

/*********************************************************************************************

Add Custom Background Support

*********************************************************************************************/
$defaults = [
    'default-color' => '000000',
    'wp-head-callback' => '_custom_background_cb',
    'admin-head-callback' => '',
    'admin-preview-callback' => ''
];
add_theme_support('custom-background', $defaults);


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

add_filter( 'excerpt_more', 'new_excerpt_more' );

/*********************************************************************************************

Array Random

*********************************************************************************************/
function array_random($arr, $num = 1) {
    shuffle($arr);

    $r = array();
    for ($i = 0; $i < $num; $i++) {
        $r[] = $arr[$i];
    }
    return $num == 1 ? $r[0] : $r;
}

/*********************************************************************************************

 BreadCrumbs
 * Author : Daniel Roch

 *********************************************************************************************/

// Get parent categories with schema.org data
function seomix_content_get_category_parents($id, $link = false,$separator = '/',$nicename = false,$visited = array()) {
    $final = '';
    $parent = &get_category($id);
    if (is_wp_error($parent)) {
        return $parent;
    }
    if ($nicename) {
        $name = $parent->name;
    } else {
        $name = $parent->cat_name;
    }
    if ($parent->parent && ($parent->parent != $parent->term_id ) && !in_array($parent->parent, $visited)) {
        $visited[] = $parent->parent;
        $final .= seomix_content_get_category_parents( $parent->parent, $link, $separator, $nicename, $visited );
    }
    if ($link) {
        $final .= '<span typeof="v:Breadcrumb"><a href="' . get_category_link($parent->term_id) . '" rel="v:url" property="v:title">'.$name.'</a></span>' . $separator;
    } else {
        $final .= $name.$separator;
    }
    return $final;
}

// Breadcrumb
function seomix_content_breadcrumb() {
    // Global vars
    global $wp_query;
    $paged = get_query_var('paged');
    $sep = ' &raquo; ';
    $data = '<span typeof="v:Breadcrumb">';
    $dataend = '</span>';
    $final = '<div xmlns:v="http://rdf.data-vocabulary.org/#" class="petit" id="breadcrumbs">'.  __('','bsn') ;
    $startdefault = $data.'<a href="'.home_url().'" rel="v:url" property="v:title"> Accueil </a>'.$dataend;
    $starthome = __('Home','bsn');

    // Breadcrumb start
    if (is_front_page() && is_home()){
        // Default homepage
        if ( $paged >= 1 ) {
            $final .= $startdefault;
        } else {
            $final .= $starthome;
        }
    } elseif (is_front_page()){
        //Static homepage
        $final .= $starthome;
    } elseif (is_home()){
        //Blog page
        if ( $paged >= 1 ) {
            $url = get_page_link(get_option('page_for_posts'));
            $final .= $startdefault.$sep.$data.'<a href="'.$url.'" rel="v:url" property="v:title">'.__('The articles','bsn').'</a>'.$dataend;
        } else {
            $final .= $startdefault.$sep.__('The articles','bsn');
        }
    } else {
        //everyting else
        $inal .= $startdefault.$sep;
    }

    // Prevent other code to interfer with static front page et blog page
    if (is_front_page() && is_home()){// Default homepage
    } elseif (is_front_page()){//Static homepage
    } elseif (is_home()){//Blog page
    } elseif (is_attachment()) {//Attachment
        global $post;
        $parent = get_post($post->post_parent);
        $id = $parent->ID;
        $category = get_the_category($id);
        $category_id = get_cat_ID( $category[0]->cat_name );
        $permalink = get_permalink( $id );
        $title = $parent->post_title;
        $final .= seomix_content_get_category_parents($category_id,TRUE,$sep).$data."<a href='$permalink' rel='v:url' property='v:title'>$title</a>".$dataend.$sep.the_title('','',FALSE);
    } elseif (is_single() && !is_singular('post')) { // Post type
        global $post;
        $nom = get_post_type($post);
        $archive = get_post_type_archive_link($nom);
        $mypost = $post->post_title;
        $final .= $data.'<a href="'.$archive.'" rel="v:url" property="v:title">'.$nom.'</a>'.$dataend.$sep.$mypost;
    } elseif (is_single()){ //post
        // Post categories
        $category = get_the_category();
        $category_id = get_cat_ID( $category[0]->cat_name );
        if ($category_id != 0) {
            $final .= seomix_content_get_category_parents($category_id,TRUE,$sep);
        } elseif ($category_id == 0) {
            $post_type = get_post_type();
            $tata = get_post_type_object( $post_type );
            $titrearchive = $tata->labels->menu_name;
            $urlarchive = get_post_type_archive_link( $post_type );
            $final .= $data.'<a class="breadl" href="'.$urlarchive.'" rel="v:url" property="v:title">'.$titrearchive.'</a>'.$dataend;
        }
        // With Comments pages
        $cpage = get_query_var( 'cpage' );
        if (is_single() && $cpage > 0) {
            global $post;
            $permalink = get_permalink( $post->ID );
            $title = $post->post_title;
            $final .= $data."<a href='$permalink' rel='v:url' property='v:title'>$title</a>".$dataend;
            $final .= $sep."Commentaires page $cpage";
        } else { // Without Comments pages
            $final .= the_title('','',FALSE);
        }
    } elseif (is_category()) { // Categories
        // Vars
        $categoryid       = $GLOBALS['cat'];
        $category         = get_category($categoryid);
        $categoryparent   = get_category($category->parent);
        //Render
        if ($category->parent != 0) {
            $final .= seomix_content_get_category_parents($categoryparent, true, $sep, true);
        }
        if ($paged <= 1) {
            $final .= single_cat_title("", false);
        } else {
            $final .= $data.'<a href="' . get_category_link( $category ) . '" rel="v:url" property="v:title">'.single_cat_title("", false).'</a>'.$dataend;
        }
    } elseif (is_page() && !is_home()) { // Page
        $post = $wp_query->get_queried_object();
        // Simple page
        if ($post->post_parent == 0) {
            $final .= the_title('', '', FALSE);
        } elseif ($post->post_parent != 0) { // Page with ancestors
            $title = the_title('','',FALSE);
            $ancestors = array_reverse(get_post_ancestors($post->ID));
            array_push($ancestors, $post->ID);
            $count = count ($ancestors);$i=0;
            foreach ($ancestors as $ancestor) {
                if($ancestor != end($ancestors)){
                    $name = strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) );
                    $final .= $data.'<a rel="v:url" property="v:title">'.$name.'</a>'.$dataend;
                    $i++;
                    if ($i < $ancestors) {
                        $final .= $sep;
                    }
                } else {
                    $final .= strip_tags(apply_filters('single_post_title',get_the_title($ancestor)));
                }
            }
        }
    } elseif (is_author()) { // authors
        if(get_query_var('author_name')) {
            $curauth = get_user_by('slug', get_query_var('author_name'));
        } else {
            $curauth = get_userdata(get_query_var('author'));
        }
        $final .= __('Articles by the author: ','bsn').$curauth->nickname;
    } elseif (is_tag()) { // tags
        $final .=__('Articles on the subject: ','bsn').single_tag_title("",FALSE);
    } elseif (is_search()) { // Search
        $final .= __('R&eacute;sultats de recherche : ','bsn').get_search_query();
    } elseif (is_date()) { // Dates
        if (is_day()) {
            $year = get_year_link('');
            $final .= $data.'<a href="'.$year.'" rel="v:url" property="v:title">'.get_query_var("year").'</a>'.$dataend;
            $month = get_month_link( get_query_var('year'), get_query_var('monthnum') );
            $final .= $sep.$data.'<a href="'.$month.'" rel="v:url" property="v:title">'.single_month_title(' ',false).'</a>'.$dataend;
            $final .= $sep.__('Archives','bsn').get_the_date();
        } elseif (is_month()) {
            $year = get_year_link('');
            $final .= $data.'<a href="'.$year.'" rel="v:url" property="v:title">'.get_query_var("year").'</a>'.$dataend;
            $final .= $sep.__('Archives','bsn').single_month_title(' ',false);
        } elseif (is_year()) {
            $final .= __('Archives','bsn').get_query_var('year');
        }
    } elseif (is_404()) { // 404 page
        $final .= __('404 Not found','bsn');
    } elseif (is_archive()) { // Other Archives
        $posttype = get_post_type();
        $posttypeobject = get_post_type_object($posttype);
        $taxonomie = get_taxonomy( get_query_var('taxonomy'));
        $titrearchive = $posttypeobject->labels->menu_name;
        if (!empty($taxonomie)) {
            $final .= $taxonomie->labels->name;
        } else {
            $final .= $titrearchive;
        }
    }
    // Pagination
    if ($paged >= 1) {
        $final .= $sep.'Page '.$paged;
    }
    // The End
    $final .= '</div>';
    echo $final;
}
