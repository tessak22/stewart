<?php
/**
 * default content output
 * page
 * single
 * attachment
 *
 * @package Bedstone
 */

// get article title (only displayed if conditions are met below)
$article_title = bedstone_get_the_alternate_title();
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <?php if ('post' == get_post_type() || $article_title != get_the_title()) : ?>
        <header class="article-header">
            <h2><?php echo $article_title; ?></h2>
            <?php
            if ('post' == get_post_type()) {
                get_template_part('nav', 'article-meta');
            }
            ?>
        </header>
    <?php endif; ?>

    <?php the_content(); ?>

    <?php comments_template(); ?>

</article>
