<?php
/**
 * sidebar
 *
 * @package Bedstone
 */
?>

<aside class="sidebar col-md-2 col-sm-3" role="complementary">

    <nav class="nav-categories hidden-print">
        <h4>Categories</h4>
        <ul>
        	<li class="cat-item"><a href="<?php echo get_permalink(PAGE_NEWS); ?>">Show All</a></li>
            <?php wp_list_categories('title_li='); ?>
        </ul>
    </nav>

</aside>
