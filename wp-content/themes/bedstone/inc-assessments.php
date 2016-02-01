<?php
/**
 * page-specific include
 */

$assessment = new WP_Query(array(
    'post_type' => 'assessments',
    'nopaging' => true,
    'orderby' => 'menu_order',
    'order' => 'menu_order',
));
?>

<div class="assessments">
<?php if ($assessment->have_posts()) : ?>
    <?php while ($assessment->have_posts()) : $assessment->the_post(); $fields = (object) get_fields(); ?>
        <div class="assessment row">
            <div class="col-sm-2">
                <figure>
                    <?php the_post_thumbnail('full'); ?>
                </figure>
            </div>
            <div class="col-sm-10">
                <h3><?php the_title(); ?></h3>
                <?php the_content(); ?>
            </div>
        </div>
    <?php endwhile; wp_reset_postdata(); ?>
<?php endif; ?>
</div>
