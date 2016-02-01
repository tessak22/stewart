<?php
/**
 * page
 * front page
 *
 * @package Bedstone
 */

get_header(); ?>

<header class="document-header">
    <div class="container">
        <div class="row">
            <div class="page-title col-sm-10 col-sm-offset-1">
                <h1><?php the_title(); ?></h1>
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

<main class="site-main">

    <?php if(get_field('intro_text_area')): ?>
    <div class="intro-text">
        <div class="container">
            <div class="row">
                <div class="intro-text col-sm-10 col-sm-offset-1">
                    <?php the_field('intro_text_area'); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="container-columns container">
        <div class="row">
            <div class="content col-sm-10 col-sm-offset-1" role="main">

                <?php
                while (have_posts()) {
                    the_post();
                    get_template_part('content');
                }
                ?>

                <?php get_template_part('variant', 'after-content'); ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
