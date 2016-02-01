<?php
/**
 * 404
 *
 * @package Bedstone
 */

get_header(); ?>

<header class="document-header">
	<div class="container">
	    <div class="row">
	        <div class="page-title col-md-12">
	            <h1>Page Not Found (404)</h1>
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
    <div class="content col-md-12" role="main">
        <h3>We're sorry &ndash; we could not find the page you requested.</h3>
        <p class="call-to-action"><a href="/">Visit Our Homepage</a></p>
        <?php //get_search_form(); ?>
    </div>
</div>

<?php get_footer(); ?>
