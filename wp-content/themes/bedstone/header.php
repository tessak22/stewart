<?php
/**
 * header
 *
 * @package Bedstone
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<?php
/**
 * meta
 * these next couple meta are recommended by Bootstrap to come before other document data
 */
?>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<?php
/**
 * title element
 * if front page, display the blog name (usually the company name)
 * otherwise render the wp_title() and append the blog name
 */
?>
<title><?php is_front_page() ? bloginfo('name') : wp_title(' - ' . get_bloginfo('name'), true, 'right'); ?></title>

<?php
 /**
  * legacy IE responsive support
  * recommended by Bootstrap, legacy IE8 support for HTML5 elements and media queries
  */
?>
<!--[if lte IE 8]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv-printshiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<?php
/**
 * google fonts
 * accepts a string of font sets
 * see functions-bedstone.php for more info
 * e.g. bedstone_google_fonts('Roboto:400,400italic,700,700italic|Open+Sans|Roboto+Condensed:300');
 */
bedstone_google_fonts('Raleway:300,400,700|Merriweather:400,700');
?>

<?php
/**
 * favicons
 * the Design team will generate favicons
 * see functions-bedstone.php for more info
 * https://sites.google.com/a/windmilldesign.com/development/blade-sites/dev-specs/favicons
 * e.g. bedstone_favicons('#ffffff', '#0066cc');
 */
bedstone_favicons();
?>

<?php wp_head(); ?>

<?php
/**
 * analytics
 * Google recommends that the asynchronous js is loaded in the head
 * requires the UA value passed to the function
 * e.g. bedstone_google_analytics('UA-434233232-1');
 * https://support.google.com/analytics/answer/1008080?hl=en#GA
 */
if (defined('ENV_SHOW_ANALYTICS') && ENV_SHOW_ANALYTICS) {
    bedstone_google_analytics(); // put UA as string, e.g. 'UA-434233232-1'
}
?>
</head>
<body <?php body_class('sticky-site-footer'); ?>>
<!--[if lte IE 9]> <div class="ie9-"> <![endif]-->
<!--[if IE 9]> <div class="ie9"> <![endif]-->
<!--[if IE 8]> <div class="ie8"> <![endif]-->
<div class="container-non-site-footer-elements">

<header class="site-header" role="banner">
    <div class="main-navigation">
        <div class="container">
            <div class="row">
                <div class="logo col-md-4 col-sm-6">
                    <a class="hidden-print" href="/"><img src="<?php bloginfo('template_directory'); ?>/images/logo.svg" alt="<?php bloginfo('name'); ?>"></a>
                    <h1 class="visible-print-block"><?php bloginfo('name'); ?></h1>
                </div>
                <div class="nav-bar col-md-7 col-sm-6 hidden-print">
                    <div class="toggle-nav pull-right">
                            <i class="fa fa-bars"></i>
                    </div>
                    <nav id="nav" class="nav-main">
                        <ul class="nav">
                            <?php
                                // run the nav through the walker to add Bootstrap classes
                                wp_list_pages(array(
                                    'depth' => 2,
                                    'title_li' => '',
                                    'exclude' => '6,21',
                                    'walker' => new Bedstone_Bootstrap_Walker_Page(),
                                ));
                            ?>
                        </ul>
                    </nav>
                </div>
            </div><!--.row-->
        </div><!--.container-->
    </div><!--.main-navigation-->

<!-- .site-header closes in specific templates-->
