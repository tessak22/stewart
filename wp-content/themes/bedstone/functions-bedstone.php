<?php
/**
 * These should all be bedstone-specific, not project-specific.
 *
 * For this file, put all _action and _filter functions near top
 * all other functions can go below.
 *
 * @package Bedstone
 */

/**
 * Auto-update settings
 * @link https://codex.wordpress.org/Configuring_Automatic_Background_Updates
 *
 * Although not specifically referenced, plugins SHOULD recieve exploit updates
 * when the WordPress Security Team pushes a critical update.
 */
add_filter('automatic_updates_is_vcs_checkout', '__return_false', 1); // allow updates in version-controlled directories
add_filter('allow_major_auto_core_updates', '__return_false'); // disallow major core updates
add_filter('allow_minor_auto_core_updates', '__return_true'); // allow major core updates
//wp_maybe_auto_update(); // un-comment to force updates

/**
 * Debug helper
 *
 * @param mixed $var To be debugged
 * @param bool $exit Triggers php exit
 *
 * @return void
 */
function debug($var, $exit = false)
{
    echo '<pre class="debug">';
    var_dump($var);
    echo '</pre>';
    if ($exit) {
        exit();
    }
}

/**
 * Hide the admin bar on front end
 * This constant could be set to (bool) false in wp-config-local.php
 */
if (defined('SHOW_ADMIN_BAR')) {
    show_admin_bar(SHOW_ADMIN_BAR);
}

/**
 * Remove emoji introduced in WP 4.2
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/**
 * Login branding
 */
add_action('login_enqueue_scripts', 'bedstone_login_css');
function bedstone_login_css()
{
    echo "
        <style>
            body.login div#login h1 a {
                background: url('/branding/windmill-login-cobrand.png');
                background-size: 276px 77px;
                width: 276px;
                height: 77px;
            }
        </style>
    ";
}
add_filter('login_headerurl', 'bedstone_login_logo_url');
function bedstone_login_logo_url()
{
    return 'http://www.windmilldesign.com';
}
add_filter('login_headertitle', 'bedstone_login_logo_url_title');
function bedstone_login_logo_url_title()
{
    return 'Windmill Design';
}

/**
 * Admin footer branding
 */
add_action('in_admin_footer', 'bedstone_admin_footer');
function bedstone_admin_footer()
{
    echo '<p style="margin-top: 1em; margin-bottom: .8em;">';
    echo '<img alt="" style="display: inline-block; margin: 0 2px -3px 0;" src="/branding/windmill-footer-mark.png" />';
    echo 'Website Design and Development by <a target="_blank" style="color: rgb(205, 65, 44);" href="http://www.windmilldesign.com">Windmill Design</a>';
    if (defined('DOCUMENTATION_LINK') && DOCUMENTATION_LINK) {
        echo ' &mdash; <a target="_blank" href="' . DOCUMENTATION_LINK . '">Site Documentation</a>';
    }
    echo '</p>';
}

/**
 * Custom MCE editor blockformats
 *     ** this should come BEFORE any other MCE-related functions
 */
add_filter('tiny_mce_before_init', 'bedstone_editor_items');
function bedstone_editor_items($init)
{
    // Add block format elements you want to show in dropdown
    $init['block_formats'] = 'Paragraph=p; Heading (h2)=h2; Sub-Heading (h3)=h3; Minor Heading (h4)=h4';
    // Disable unnecessary items and buttons
    $init['toolbar1'] = 'bold,italic,alignleft,aligncenter,alignright,bullist,numlist,outdent,indent,link,unlink,hr'; // 'template,|,bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,wp_fullscreen,wp_adv',
    $init['toolbar2'] = 'formatselect,pastetext,removeformat,charmap,undo,redo,wp_help,styleselect'; // 'formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help',
    // Display the kitchen sink by default
    $init['wordpress_adv_hidden'] = false;
    // [optional] Add elements not included in standard tinyMCE dropdown
    //$init['extended_valid_elements'] = 'code[*]';
    return $init;
}

/**
 * Advanced Custom Fields: Custom MCE editor blockformats
 */
add_filter('acf/fields/wysiwyg/toolbars', 'bedstone_acf_editor_items');
function bedstone_acf_editor_items($toolbars)
{
    if (isset($toolbars['Full'][2])) {
        $toolbars['Full'][2][] = 'styleselect';
    }
    return $toolbars;
}


/**
 * add page id column to Admin views
 */
add_action('admin_head', 'bedstone_admin_id_column_style');
function bedstone_admin_id_column_style()
{
    echo "
        <style>
            .fixed .column-pid { width: 10%; }
        </style>
    ";
}
add_action('admin_init', 'bedstone_admin_id_column');
function bedstone_admin_id_column()
{
    // page
    add_filter('manage_pages_columns', 'bedstone_pid_column');
    add_action('manage_pages_custom_column', 'bedstone_pid_value', 10, 2);
    // post
    add_filter('manage_posts_columns', 'bedstone_pid_column');
    add_action('manage_posts_custom_column', 'bedstone_pid_value', 10, 2);
    // users
    add_filter('manage_users_columns', 'bedstone_pid_column');
    add_action('manage_users_custom_column', 'bedstone_pid_return_value', 10, 3);
    // taxonomy
    foreach(get_taxonomies() as $tax) {
        add_action('manage_edit-' . $tax . '_columns', 'bedstone_pid_column');
        add_filter('manage_' . $tax . '_custom_column', 'bedstone_pid_return_value', 10, 3);
    }
}
function bedstone_pid_column($cols)
{
    $cols['pid'] = 'ID';
    return $cols;
}
function bedstone_pid_value($column, $id)
{
    if ($column == 'pid') {
        echo $id;
    }
}
function bedstone_pid_return_value($value, $column, $id)
{
    if($column == 'pid') {
        $value = $id;
    }
    return $value;
}

/**
 * Filter title for trademarks
 * Replaces reg and tm with html superscript element and html chars
 */
if (!is_admin()) {
    // does not filter in the admin area
    add_filter('the_title', 'bedstone_title_trademarks');
}
function bedstone_title_trademarks($title)
{
    $title = str_replace('&copy;', '<sup>&copy;</sup>', $title);
    $title = preg_replace('/\x{00A9}/u', '<sup>&copy;</sup>', $title);
    $title = str_replace('&reg;', '<sup>&reg;</sup>', $title);
    $title = preg_replace('/\x{00AE}/u', '<sup>&reg;</sup>', $title);
    $title = str_replace('&trade;', '<sup>&trade;</sup>', $title);
    $title = preg_replace('/\x{2122}/u', '<sup>&trade;</sup>', $title);
    $title = str_replace('&#8480;', '<sup>&#8480;</sup>', $title); // service mark
    $title = preg_replace('/\x{2120}/u', '<sup>&#8480;</sup>', $title); // service mark
    return $title;
}

/**
 * Filter body class
 */
add_filter('body_class', 'bedstone_body_class');
function bedstone_body_class($classes)
{
    $root_parent = false;
    if (is_front_page()) {
        $root_parent = 'front-page';
    } elseif (is_home()) {
        $root_parent = 'home';
    } elseif (is_category()) {
        $root_parent = 'category';
    } elseif (is_tag()) {
        $root_parent = 'tag';
    } elseif (is_author()) {
        $root_parent = 'author';
    } elseif (is_day() || is_month() || is_year()) {
        $root_parent = 'date';
    } elseif (is_search()) {
        $root_parent = 'search';
    } elseif ('post' == get_post_type()) {
        $root_parent = 'post';
    } elseif ('page' == get_post_type()) {
        $root_parent = bedstone_get_the_root_parent();
    }
    if ($root_parent) {
        $classes[] = 'root-parent-' . $root_parent;
    }
    return $classes;
}

/**
 * Display google fonts
 *
 * @param string $str_fonts Same as google provides
 *
 * output: link elements for the google fonts
 *
 * @return void
 */
function bedstone_google_fonts($str_fonts = false)
{
    if ($str_fonts) {
        // build output
        $arr_fonts = explode('|', $str_fonts); // break apart each font set
        foreach ($arr_fonts as $font) {
            if (false === strpos($font, ':')) {
                $arr_sets[] = $font . ':400'; // has no specific type, use 400
            } else {
                if (false === strpos($font, ',')) {
                    $arr_sets[] = $font; // has only one specific type
                } else {
                    // has multiple types
                    $arr_family = explode(':', $font);
                    $arr_types = explode(',', $arr_family[1]);
                    foreach ($arr_types as $type) {
                        $arr_sets[] = $arr_family[0] . ':' . $type;
                    }
                }
            }
        }
        echo "<!--[if gt IE 8]><!--> \n"
           . "<link rel='stylesheet' href='//fonts.googleapis.com/css?family=" . $str_fonts . "' /> \n"
           . "<!--<![endif]--> \n"
           . "<!--[if lte IE 8]> \n";
        foreach ($arr_sets as $set) {
            echo "<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=" . $set . "' /> \n";
        }
        echo "<![endif]--> \n";
    }
}

/**
 * Display google analytics script
 *
 * @param string $ua Client user account
 * @param bool $debug Loads analytics_debug.js script
 *
 * output: google analytics script
 *
 * @return void
 */
function bedstone_google_analytics($ua = '', $debug = false)
{
    if ($ua) {
        echo "
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics" . ($debug ? '_debug' : '') . ".js','ga');
            ga('create', '" . $ua . "', 'auto');
            ga('send', 'pageview');
        </script>
        ";
    }
}

/**
 * Display favicon meta
 *
 * @param string MS Tile Color, hex value
 * @param string Theme Color, hex value
 *
 * @return void
 */
function bedstone_favicons($color_msTile = false, $color_theme = false)
{
    /**
     * set for http://realfavicongenerator.net/
     */
    if ($color_msTile && $color_theme) {
        $directory = get_bloginfo('template_directory') . '/favicons';
        echo "
        <link rel='shortcut icon' href='$directory/favicon.ico' type='image/x-icon' />
        <link rel='icon' href='$directory/favicon.ico' type='image/x-icon' />
        <link rel='apple-touch-icon' sizes='57x57' href='$directory/apple-touch-icon-57x57.png'>
        <link rel='apple-touch-icon' sizes='60x60' href='$directory/apple-touch-icon-60x60.png'>
        <link rel='apple-touch-icon' sizes='72x72' href='$directory/apple-touch-icon-72x72.png'>
        <link rel='apple-touch-icon' sizes='76x76' href='$directory/apple-touch-icon-76x76.png'>
        <link rel='apple-touch-icon' sizes='114x114' href='$directory/apple-touch-icon-114x114.png'>
        <link rel='apple-touch-icon' sizes='120x120' href='$directory/apple-touch-icon-120x120.png'>
        <link rel='apple-touch-icon' sizes='144x144' href='$directory/apple-touch-icon-144x144.png'>
        <link rel='apple-touch-icon' sizes='152x152' href='$directory/apple-touch-icon-152x152.png'>
        <link rel='apple-touch-icon' sizes='180x180' href='$directory/apple-touch-icon-180x180.png'>
        <link rel='icon' type='image/png' href='$directory/favicon-32x32.png' sizes='32x32'>
        <link rel='icon' type='image/png' href='$directory/favicon-194x194.png' sizes='194x194'>
        <link rel='icon' type='image/png' href='$directory/favicon-96x96.png' sizes='96x96'>
        <link rel='icon' type='image/png' href='$directory/android-chrome-192x192.png' sizes='192x192'>
        <link rel='icon' type='image/png' href='$directory/favicon-16x16.png' sizes='16x16'>
        <link rel='manifest' href='$directory/manifest.json'>
        <meta name='msapplication-TileColor' content='$color_msTile'>
        <meta name='msapplication-TileImage' content='$directory/mstile-144x144.png'>
        <meta name='msapplication-config' content='$directory/browserconfig.xml' />
        <meta name='theme-color' content='$color_theme'>
        ";
    }
}

/**
 * Get the root parent
 *
 * @param int $id Post id
 *
 * @return int Post id of the root-most parent
 */
function bedstone_get_the_root_parent($id = false)
{
    $root = 0;
    if (!$id) {
        global $post;
        $id = isset($post->ID) ? $post->ID : 0;
    }
    $ancestors = get_post_ancestors($id);
    if (!empty($ancestors)) {
        $root = end($ancestors);
    } else {
        $root = $id;
    }
    return $root;
}
function bedstone_the_root_parent($id = false)
{
    echo bedstone_get_the_root_parent($id);
}

/**
 * Display an alternate title
 *
 * These are for seo when we need one "menu" title and another via title_alternate custom field
 *
 * @param string for output before title
 * @param string for output after title
 * @param bool will echo on true
 *
 * @return string title in some cases
 */
function bedstone_the_alternate_title($before = '', $after = '', $echo = true)
{
    // based on the_title() in /wp-includes/post-template.php
    $title = bedstone_get_the_alternate_title();
    if (0 == strlen($title)) {
        return;
    }
    $title = $before . $title . $after;
    if ($echo) {
        echo $title;
    } else {
        return $title;
    }
}

/**
 * Determine the alternate title
 *
 * @param mixed post that should be checked
 *
 * @return string alternate title
 */
function bedstone_get_the_alternate_title($post = 0)
{
    // based on get_the_title() in /wp-includes/post-template.php
    $post = get_post($post);
    $title = isset($post->post_title) ? $post->post_title : '';
    $id = isset($post->ID) ? $post->ID : 0;

    // alternate is found here
    $title_alternate = get_post_meta($id, 'title_alternate', true);
    $title = ('' != $title_alternate) ? $title_alternate : $title;

    if (!is_admin()) {
        if (!empty($post->post_password)) {
            $protected_title_format = apply_filters('protected_title_format', __('Protected: %s'));
            $title = sprintf($protected_title_format, $title);
        } elseif (isset($post->post_status) && 'private' == $post->post_status) {
            $private_title_format = apply_filters('private_title_format', __('Private: %s'));
            $title = sprintf($private_title_format, $title);
        }
    }
    return apply_filters('the_title', $title, $id);
}

/**
 * Nav child pages shortcode
 *
 * @param mixed $atts Array with optional string 'exclude' or optional string 'parent'
 *
 * @return string HTML output child nav
 *
 * usage: [child_pages parent="25" exclude="58,74"] ... returns children of 25 excluding 58 and 74
 */
add_shortcode('child_pages', 'bedstone_child_pages_shortcode');
function bedstone_child_pages_shortcode($atts, $content = null)
{
    extract(shortcode_atts(array(
        'exclude' => '',
        'parent' => get_the_ID(),
    ), $atts));
    $args = array(
        'exclude' => $exclude,
        'child_of' => $parent,
        'depth' => 1,
        'sort_column' => 'menu_order, title',
        'title_li' => '',
        'echo' => 0
    );
    $child_pages = wp_list_pages($args);
    return "\n<ul class='nav-child-pages-shortcode'>\n" . $child_pages . "</ul>\n\n" . do_shortcode($content);
}

/**
 * Determine if posts should use alternate title as the document title, e.g. "Blog" for a blog section
 *
 * @return string Title or empty string
 */
function bedstone_get_posts_section_title()
{
    $ret = '';
    if ('post' == get_post_type()) {
        $section_title = get_the_title(get_option('page_for_posts', true));
        if ('' != $section_title) {
            $ret = $section_title;
        }
    }
    return $ret;
}

/**
 * Breadcrumbs array
 *
 * @return array Breadrumbs string name, optional string link
 */
function bedstone_get_breadcrumbs()
{
    $breadcrumbs = array();
    $page_on_front = get_option('page_on_front');
    $page_for_posts = get_option('page_for_posts', true);

    // if exists, initialize with front page
    if ($page_on_front && !is_front_page()) {
        $breadcrumbs[] = array(
            'name' => get_the_title($page_on_front),
            'link' => get_permalink($page_on_front)
        );
    }

    if ($page_for_posts && is_home()) {
        $breadcrumbs[] = array(
            'name' => get_the_title($page_for_posts)
        );
    } elseif (is_404()) {
        $breadcrumbs[] = array(
            'name' => 'Page Not Found'
        );
    } elseif (is_search()) {
        $breadcrumbs[] = array(
            'name' => 'Search Results'
        );
    } elseif ($page_for_posts && (is_single() || is_category() || is_tag() || is_author() || is_day() || is_month() || is_year())) {
        // set blog for single and archives
        $breadcrumbs[] = array(
            'name' => get_the_title($page_for_posts),
            'link' => get_permalink($page_for_posts)
        );
        if (is_category()) {
            $breadcrumbs[] = array(
                'name' => single_cat_title('', false)
            );
        } elseif (is_tag()) {
            $breadcrumbs[] = array(
                'name' => single_tag_title('', false)
            );
        }
    } elseif (!is_front_page()) {
        $ancestors = array_reverse(get_ancestors(get_the_ID(), 'page'));
        foreach ($ancestors as $ancestor) {
            $breadcrumbs[] = array(
                'name' => get_the_title($ancestor),
                'link' => get_permalink($ancestor)
            );
        }
        $breadcrumbs[] = array(
            'name' => get_the_title()
        );
    }

    return $breadcrumbs;
}

/**
 * Add Bootstrap classes to wp_list_pages()
 *
 * @uses Walker_Page
 */
class Bedstone_Bootstrap_Walker_Page extends Walker_Page
{
    /**
     * WINDMILL CUSTOM
     * The menu depth
     * Note: Is NOT zero-based
     *
     * @access protected
     * @var int
     */
    protected $max_depth;

    /**
     * Traverse elements to create list from elements.
     *
     * Display one element if the element doesn't have any children otherwise,
     * display the element and its children. Will only traverse up to the max
     * depth and no ignore elements under that depth. It is possible to set the
     * max depth to include all depths, see walk() method.
     *
     * This method should not be called directly, use the walk() method instead.
     *
     * @since 2.5.0
     *
     * @param object $element           Data object.
     * @param array  $children_elements List of elements to continue traversing.
     * @param int    $max_depth         Max depth to traverse.
     * @param int    $depth             Depth of current element.
     * @param array  $args              An array of arguments.
     * @param string $output            Passed by reference. Used to append additional content.
     * @return null Null on failure with no changes to parameters.
     */
    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

        if ( !$element )
            return;

        /**
         * WINDMILL CUSTOM
         * Make the max depth accessible to the class.
         */
        $this->max_depth = $max_depth;

        $id_field = $this->db_fields['id'];
        $id       = $element->$id_field;

        //display this element
        $this->has_children = ! empty( $children_elements[ $id ] );
        if ( isset( $args[0] ) && is_array( $args[0] ) ) {
            $args[0]['has_children'] = $this->has_children; // Backwards compatibility.
        }

        $cb_args = array_merge( array(&$output, $element, $depth), $args);
        call_user_func_array(array($this, 'start_el'), $cb_args);

        // descend only when the depth is right and there are childrens for this element
        if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

            foreach( $children_elements[ $id ] as $child ){

                if ( !isset($newlevel) ) {
                    $newlevel = true;
                    //start the child delimiter
                    $cb_args = array_merge( array(&$output, $depth), $args);
                    call_user_func_array(array($this, 'start_lvl'), $cb_args);
                }
                $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
            }
            unset( $children_elements[ $id ] );
        }

        if ( isset($newlevel) && $newlevel ){
            //end the child delimiter
            $cb_args = array_merge( array(&$output, $depth), $args);
            call_user_func_array(array($this, 'end_lvl'), $cb_args);
        }

        //end this element
        $cb_args = array_merge( array(&$output, $element, $depth), $args);
        call_user_func_array(array($this, 'end_el'), $cb_args);
    }

    /**
     * @see Walker::start_lvl()
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     * @param array $args
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        /**
         * WINDMILL CUSTOM
         * Add .dropdown-menu for Bootstrap
         */
        $output .= "\n$indent<ul class='children dropdown-menu bedstone-bootstrap-hover-dropdown'>\n";
    }

    /**
     * @see Walker::start_el()
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $page Page data object.
     * @param int $depth Depth of page. Used for padding.
     * @param int $current_page Page ID.
     * @param array $args
     */
    public function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
        if ( $depth ) {
            $indent = str_repeat( "\t", $depth );
        } else {
            $indent = '';
        }

        $css_class = array( 'page_item', 'page-item-' . $page->ID);

        /**
         * WINDMILL CUSTOM
         * Initialize anchor attributes
         */
        $anchor_css_class = array();
        $anchor_data_toggle = '';

        /**
         * WINDMILL CUSTOM
         * Do not append attributes if max depth has been reached.
         * Note: Depth is zero-based, max depth is not.
         */
        if ( ($this->max_depth == 0 || $this->max_depth > $depth+1 ) && isset( $args['pages_with_children'][ $page->ID ] ) ) {
            // these items are for parents that are not at the lowest depth of the menu
            $css_class[] = 'page_item_has_children';
            $css_class[] = 'dropdown';
            $anchor_css_class[] = 'dropdown-toggle';
            $anchor_data_toggle = 'dropdown';
        }

        if ( ! empty( $current_page ) ) {
            $_current_page = get_post( $current_page );
            if ( $_current_page && in_array( $page->ID, $_current_page->ancestors ) ) {
                $css_class[] = 'current_page_ancestor';
            }
            if ( $page->ID == $current_page ) {
                $css_class[] = 'current_page_item';
            } elseif ( $_current_page && $page->ID == $_current_page->post_parent ) {
                $css_class[] = 'current_page_parent';
            }
        } elseif ( $page->ID == get_option('page_for_posts') ) {
            $css_class[] = 'current_page_parent';
        }

        /**
         * Filter the list of CSS classes to include with each page item in the list.
         *
         * @since 2.8.0
         *
         * @see wp_list_pages()
         *
         * @param array   $css_class    An array of CSS classes to be applied
         *                             to each list item.
         * @param WP_Post $page         Page data object.
         * @param int     $depth        Depth of page, used for padding.
         * @param array   $args         An array of arguments.
         * @param int     $current_page ID of the current page.
         */
        $css_classes = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );
        $anchor_css_classes = implode(' ', $anchor_css_class);

        if ( '' === $page->post_title ) {
            $page->post_title = sprintf( __( '#%d (no title)' ), $page->ID );
        }

        $args['link_before'] = empty( $args['link_before'] ) ? '' : $args['link_before'];
        $args['link_after'] = empty( $args['link_after'] ) ? '' : $args['link_after'];

        /** This filter is documented in wp-includes/post-template.php */
        $output .= $indent . sprintf(
            '<li class="%s"><a href="%s" class="%s" data-toggle="%s">%s%s%s</a>',
            $css_classes,
            get_permalink( $page->ID ),
            $anchor_css_classes,
            $anchor_data_toggle,
            $args['link_before'],
            apply_filters( 'the_title', $page->post_title, $page->ID ),
            $args['link_after']
        );

        if ( ! empty( $args['show_date'] ) ) {
            if ( 'modified' == $args['show_date'] ) {
                $time = $page->post_modified;
            } else {
                $time = $page->post_date;
            }

            $date_format = empty( $args['date_format'] ) ? '' : $args['date_format'];
            $output .= " " . mysql2date( $date_format, $time );
        }
    }

    /**
     * @see Walker::end_el()
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $page Page data object. Not used.
     * @param int $depth Depth of page. Not Used.
     * @param array $args
     */
    public function end_el( &$output, $page, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }

}
