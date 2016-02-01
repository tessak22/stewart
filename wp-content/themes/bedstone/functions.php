<?php
/**
 * project-specific functions
 *
 * @package Bedstone
 */

// hide admin bar in front side views
show_admin_bar( false );


// Define page id constants
define('PAGE_HOME', 6);
define('PAGE_ABOUT_US', 8);
define('PAGE_SERVICES', 9);
    define('PAGE_ASSESSMENTS', 12);
    define('PAGE_WHITE_PAPERS', 13);
define('PAGE_TESTIMONIALS', 10);
define('PAGE_NEWS', 11);


/**
 * load theme defaults
 */
require TEMPLATEPATH . '/functions-bedstone.php';

/**
 * load ajax
 */
include(TEMPLATEPATH . '/functions-ajax.php');

/**
 * Set the content width based on the theme's design and stylesheet.
 * @link http://codex.wordpress.org/Content_Width
 */
if (!isset($content_width)) {
    $content_width = 640; /* pixels */
}

/**
 * [optional] session support
 */
//add_action('init', 'session_initialize');
function session_initialize()
{
    if (!session_id()) {
        session_start();
    }
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
add_action('after_setup_theme', 'custom_theme_setup');
function custom_theme_setup()
{
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_post_type_support('page', array('excerpt'));
    add_theme_support('post-thumbnails');
}

/**
 * Enqueue scripts and styles.
 */
add_action('wp_enqueue_scripts', 'custom_enqueue_scripts');
function custom_enqueue_scripts() {
    $id = get_the_ID(); // use for testing page-specific styles and scripts
    // styles
    //wp_enqueue_style('style-name', get_template_directory_uri() . '/css/example.css', array(), '0.1.0');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', '4.3.0');
    //wp_enqueue_style('selectboxit', '//cdnjs.cloudflare.com/ajax/libs/jquery.selectboxit/3.8.0/jquery.selectBoxIt.css', '3.8.0');
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/bootstrap/3.3.4/css/bootstrap.css', array(), '3.3.4');
    wp_enqueue_style('bedstone', get_stylesheet_uri(), array('bootstrap'), (defined('CACHE_BUSTER') ? CACHE_BUSTER : ''));
    wp_enqueue_style('bedstone-responsive', get_template_directory_uri() . '/css/style-responsive.css', array('bootstrap', 'bedstone'), 'NoVersion');
    // scripts
    //wp_enqueue_script('script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true);
    //wp_enqueue_script('jquery-ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js', array('jquery'), '1.11.4', true);
    //wp_enqueue_script('selectboxit-js', '//cdnjs.cloudflare.com/ajax/libs/jquery.selectboxit/3.8.0/jquery.selectBoxIt.min.js', array('jquery', 'jquery-ui'), '3.8.0', true);
    wp_enqueue_script('bootstrap-js', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js', array('jquery'), '3.3.4', true);
    wp_enqueue_script('init-js', get_template_directory_uri() . '/js/init.js', array('jquery', 'bootstrap-js'), 'NoVersion', true);
    wp_enqueue_script('easing-js', get_template_directory_uri() . '/js/easing.1.3.js', array('jquery'), '1.3', true);
}

/**
 * [optional, enabled by default] bootstrap support for comments
 */
add_filter('comment_form_default_fields', 'bootstrap3_comment_form_fields');
function bootstrap3_comment_form_fields($fields)
{
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req) ? " aria-required='true'" : '';
    $html5 = (current_theme_supports('html5', 'comment-form')) ? true : false;
    $rand = rand(1000, 9999); // for element ids
    $fields = array(
        'author' => '<div class="form-group comment-form-author">' . '<label for="author' . $rand . '">' . __('Name') . ($req ? ' <span class="required">*</span>' : '') . '</label> '
                    . '<input class="form-control" id="author' . $rand . '" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></div>',
        'email'  => '<div class="form-group comment-form-email"><label for="email' . $rand . '">' . __('Email') . ($req ? ' <span class="required">*</span>' : '') . '</label> '
                    . '<input class="form-control" id="email' . $rand . '" name="email" ' . ($html5 ? 'type="email"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_email'])
                    . '" size="30"' . $aria_req . ' /></div>',
        'url'    => '<div class="form-group comment-form-url"><label for="url' . $rand . '">' . __('Website') . '</label> ' . '<input class="form-control" id="url' . $rand . '" name="url" '
                    . ($html5 ? 'type="url"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></div>',
    );
    return $fields;
}
add_filter('comment_form_defaults', 'bootstrap3_comment_form');
function bootstrap3_comment_form($args)
{
    $rand = rand(1000, 9999); // for element ids
    $args['comment_field'] = '<div class="form-group comment-form-comment">'
                           . '<label for="comment' . $rand . '">' . _x( 'Comment', 'noun' ) . '</label>'
                           . '<textarea class="form-control" id="comment' . $rand . '" name="comment" cols="45" rows="8" aria-required="true"></textarea>'
                           . '</div>';
    return $args;
}
add_action('comment_form', 'bootstrap3_comment_button');
function bootstrap3_comment_button()
{
    echo '<button class="btn btn-default" type="submit">' . __('Submit') . '</button>';
}

/**
 * [optional] register navigation menus
 */
//add_action('after_setup_theme', 'do_register_nav_menus');
function do_register_nav_menus()
{
    register_nav_menus(
        array(
            'nav-main' => __('Nav Main', 'bedstone'),
            //'nav-secondary' => __('Nav Secondary', 'bedstone'),
        )
    );
}

/**
 * register custom mce styles: http://codex.wordpress.org/TinyMCE_Custom_Styles
 */
add_filter('tiny_mce_before_init', 'add_style_formats');
function add_style_formats($init)
{
    $style_formats = array(
        array(
            'title' => 'Callout',
            'selector' => 'p',
            'classes' => 'callout',
        ),
        array(
            'title' => 'Footnote',
            'selector' => 'p',
            'classes' => 'footnote',
        ),
        array(
            'title' => 'Call-to-Action',
            'selector' => 'p',
            'classes' => 'call-to-action',
        ),
        array(
            'title' => 'Introduction',
            'selector' => 'h2',
            'classes' => 'introduction',
        )
    );
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init['style_formats'] = json_encode($style_formats);
    return $init;
}

/**
 * [initially disabled] Custom mce editor styles
 */
add_action('init', 'do_add_editor_styles');
function do_add_editor_styles()
{
    add_editor_style('css/style-editor-02.css'); // cached, update revision as needed
}

/**
 * external links
 *
 * @param string $key The array key of the link
 *
 * @return string Link to the resource
 */
function get_the_ext($key)
{
    $arr_ext = array(
        'windmill_design' => 'http://www.windmilldesign.com',
        // add more items below this point
    );
    $link = (array_key_exists($key , $arr_ext)) ? $arr_ext[$key] : '#get_the_ext_error';
    return $link;
}
function the_ext($key)
{
    echo get_the_ext($key);
}

/**
 * [optional] custom post types
 */
add_action('init', 'wd_register_custom_post_types', 0);
function wd_register_custom_post_types()
{
    $arr_custom_post_type_options = array(
        /*
         array(
            'label' => 'lowercase_name' // ** 20 char max, no spaces or caps
            'singlar' => 'Human-Readable Item' // singular name
            'plural' => 'Human-Readable Items' // plural name
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats')
         ),
         */
        array(
            'label' => 'assessments',
            'singular' => 'Assessment',
            'plural' => 'Assessments',
            'supports' => array('title', 'editor', 'thumbnail'),
        ),
    );
    foreach ($arr_custom_post_type_options as $cpt_opts) {
        $label = $cpt_opts['label'];
        $labels = array(
            'name'                => $cpt_opts['plural'],
            'singular_name'       => $cpt_opts['singular'],
            'menu_name'           => $cpt_opts['plural'],
            'parent_item_colon'   => 'Parent:',
            'all_items'           => $cpt_opts['plural'],
            'view_item'           => 'View',
            'add_new_item'        => 'Add New',
            'add_new'             => 'Add New',
            'edit_item'           => 'Edit',
            'update_item'         => 'Update',
            'search_items'        => 'Search ' . $cpt_opts['plural'],
            'not_found'           => 'None found',
            'not_found_in_trash'  => 'None found in Trash',
        );
        $args = array(
            'label'               => $label,
            'description'         => 'Custom Post Type: ' . $cpt_opts['plural'],
            'labels'              => $labels,
            'supports'            => $cpt_opts['supports'],
            'hierarchical'        => true,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => true,
            'menu_position'       => 25.3,
            //'menu_icon'           => '',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => true,
            'publicly_queryable'  => true,
            'rewrite'             => false,
            'capability_type'     => 'page',
        );
        register_post_type($label, $args);
    }
}

//add options from ACF
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Global Content',
        'menu_title'    => 'Global Content',
        'menu_slug'     => 'global-content',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

}
