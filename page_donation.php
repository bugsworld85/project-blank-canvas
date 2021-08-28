<?php

/**
 * Template Name: Donation Template
 *
 * @package Blank Canvas
 * @since 1.0.0
 */

get_header();
?>

<section id="primary" class="content-area page-template-donation">
    <main id="main" class="site-main" role="main">

        <?php
        /* Start the Loop */
        while (have_posts()) :
            the_post();

            get_template_part('template-parts/content/content-singular');

            if (true === get_theme_mod('show_comments', false)) :
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) {
                    comments_template();
                }
            endif;

        endwhile; // End of the loop.
        ?>
    </main><!-- #main -->
</section><!-- #primary -->

<?php
get_footer();
