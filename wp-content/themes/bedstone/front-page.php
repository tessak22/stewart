<?php
/**
 * page
 * front page
 *
 * @package Bedstone
 */

get_header(); ?>

<div class="document-header">
    <div class="container">
        <div class="row">
            <div class="page-title col-md-12">
                <h1><?php the_title(); ?></h1>
                <h2><?php the_field('homepage_subtitle'); ?></h2>
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
</div>

</header><!-- .site-header -->

<div class="content-box white">
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <p><img src="<?php bloginfo('template_directory'); ?>/images/block-1-infographic.png"></p>
                <h2>Removing the mystery from clarity for small business</h2>
                <p>The Stewart Group is committed to the support and growth of small business in the Twin Cities and surrounding areas.
                The Stewart Group is in the change business. Neither coach nor consultant, TSG are experienced advisors and advocates
                using ROP (Return on Partnering) to generate ROI (Return on Investment) for its clients. You are the captain of your boat.
                We are your navigator.</p>
                <p><a class="btn" data-toggle="modal" data-target="#youtube-modal">Why We're Different (Video)</a></p>
            </div>
        </div>
    </div>
</div>

<div class="content-box black">
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <h2>One Size <span>Does Not Fit All</span></h2>
                <p>There is no “one size fits all” process that works for today’s small business owners. A customized approach designed
                by both advisor and client has been and will be the best way to initiate positive results that will be sustainable and
                flexible enough to take your business to the next level of success. The approach has to be easily implemented.</p>
                <p><a class="btn" href="#lets-connect">Connect</a></p>
            </div>
        </div>
    </div>
</div>

<div class="content-box white">
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <h2>Why partner with The Stewart Group?</h2>
                <p><img src="<?php bloginfo('template_directory'); ?>/images/block-3-infographic.png"></p>
                <p>We are not consultants, coaches, or trainers. We are business advisors. Our size and flexibility sets us apart from
                others that offer training manuals, PowerPoints, or cliché therapy. We are NOT designed for the masses. We are leadership
                agents advising you on solutions to achieve leadership performance. We have been doing this for 25+ years in a corporate
                world while staying in the real world. We are local but our network is national. We know your business, your market, and
                your industry. We are your neighbor, your partner, your friend. Because it’s your business. Our bet is on you to have the
                right answers, we may just have the right questions.</p>
                <p><a class="btn" href="<?php echo get_permalink(PAGE_SERVICES); ?>">Services</a></p>
            </div>
        </div>
    </div>
</div>

<!--YouTube Modal Code-->
<div class="modal fade" id="youtube-modal" tabindex="-1" role="dialog" aria-labelledby="youtube-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Learn More About Us</h4>
      </div>
      <div class="modal-body">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/dZTPTLKv8cU" frameborder="0" allowfullscreen></iframe>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--End of YouTube Modal Code-->

<?php get_footer(); ?>
