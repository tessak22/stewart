<?php
/**
 * footer
 *
 * @package Bedstone
 */
?>

</main>
</div> <!-- .container-non-site-footer-elements -->

<div class="footer-features">
	<div class="container">
		<div class="row">
			<div class="assessments-feature col-md-5 col-md-offset-1">
				<div class="row">
					<div class="feature-icon col-sm-3">
						<img src="<?php bloginfo('template_directory'); ?>/images/assessments-icon.png">
					</div>
					<div class="col-sm-9">
						<h3>Assessments</h3>
						<p>It's all about "fit" when it comes to assessing your biggest assets. It takes accurate, timely, and validated results to support your business success.</p>
						<p><a class="btn" href="<?php echo get_permalink(PAGE_ASSESSMENTS); ?>">Learn More</a></p>
					</div>
				</div>
			</div>
			<div class="whitepapers-feature col-md-6">
				<div class="row">
					<div class="feature-icon col-sm-3">
						<img src="<?php bloginfo('template_directory'); ?>/images/whitepapers-icon.png">
					</div>
					<div class="col-sm-9">
						<h3>White Papers</h3>
						<p>Leadership is a significant part of the answer to whatever challenges business may face. Our white papers cover just some of the aspects of what todays leaders need to develop.</p>
						<p><a class="btn" href="<?php echo get_permalink(PAGE_WHITE_PAPERS); ?>">Learn More</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<footer class="site-footer">
	<div class="lets-connect" id="lets-connect">
		<div class="container">
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
					<h2>Let’s Connect</h2>
					<p>Interested in how The Stewart Group can help your business? Please fill out the form below or contact us at 612-354-4603 or <a href="mailto:info@stewartgroupinc.com">info@stewartgroupinc.com</a>.</p>
					<?php echo do_shortcode('[contact-form-7 id="20" title="Lets Connect"]', true); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-info">
		<div class="container">
			<div class="row">
		        <div class="copyright col-sm-9">
		        	<ul>
		        		<li><b>The Stewart Group</b></li>
		        		<li>612-354-4603</li>
		        		<li><a href="mailto:info@stewartgroupinc.com">info@stewartgroupinc.com</a></li>
		        	</ul>
		            <p>&copy; <?php echo date('Y') . ' ' . get_bloginfo('name'); ?> | <a href="http://windmilldesign.com" rel="external">Site Credits</a></p>
		        </div>
		        <div class="nav-secondary col-sm-3">
		            <ul>
		                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
		                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
		                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
		            </ul>
		        </div>
		    </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

<?php /* placeholder support for legacy IE */ ?>
<!--[if lte IE 9]>
<script src="https://cdn.jsdelivr.net/jquery.placeholder/2.1.1/jquery.placeholder.min.js" type="text/javascript"></script>
<script type="text/javascript"> jQuery(document).ready(function($){ $('input, textarea').placeholder(); }); </script>
<![endif]-->

<!--[if lte IE 9]> </div> <![endif]-->
<!--[if IE 9]> </div> <![endif]-->
<!--[if IE 8]> </div> <![endif]-->

</body>
</html>
