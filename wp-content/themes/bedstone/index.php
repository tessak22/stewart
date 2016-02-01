<?php
/**
 * default catch all
 *
 * author
 * category
 * custom post type archive
 * custom taxonomy archive
 * date archive -- year, month, day
 * search results
 * tag archive
 *
 * @package Bedstone
 */

get_header(); ?>

<header class="document-header">
    <div class="container">
        <div class="row">
            <div class="page-title col-sm-10 col-sm-offset-1">
                <h1>
                    <?php
                        if (is_category()) {
                            single_cat_title();
                        } elseif (is_tag()) {
                            single_tag_title();
                        } elseif (is_author()) {
                            echo 'Author: ' . get_the_author();
                        } elseif (is_day()) {
                            echo 'Archive: ' . get_the_date('l, F j, Y');
                        } elseif (is_month()) {
                            echo 'Archive: ' . get_the_date('j Y');
                        } elseif (is_year()) {
                            echo 'Archive: ' . get_the_date('Y');
                        } elseif (is_search()) {
                            echo 'Results for: ' . get_search_query();
                        } elseif (is_home() && is_front_page()) {
                            // Settings > Reading > Front Page Displays > Your Latest Posts
                            echo get_bloginfo('name');
                        } elseif (is_home()) {
                            // Settings > Reading > Front Page Displays > Static Page > Posts Page
                            echo get_the_title(get_option('page_for_posts', true));
                        } else {
                            echo 'Archives';
                        }
                    ?>
                </h1>
            </div>
        </div>
        <div class="sticky-connect">
            <div class="sticky-icon">
                <a href="#lets-connect"><i class="fa fa-comment"></i></a>
            </div>
            <div class="sticky-text">
                <h4><a href="#lets-connect">Let's Connect</a></h4>
            </div>
        </div>
    </div>
</header>

</header><!-- .site-header -->

<main class="site-main container">

<div class="container-columns row">
    <div class="content content-list col-sm-8 col-md-9 col-sm-offset-1" role="main">
        <?php
        if (is_search()) {
            get_search_form();
        }
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                get_template_part('content', 'list');
            }
            get_template_part('nav', 'archive');
        } else {
            get_template_part('content', 'none');
        }
        ?>
    </div>
    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
