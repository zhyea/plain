<?php
/*
Template Name: Instagram 模板
*/
?>
<?php get_header();?>
    <main class="main-content container">
        <section class="section-body">
            <?php while ( have_posts() ) : the_post(); ?>
                <header class="section-header u-textAlignCenter">
                    <h2 class="grap--h2"><?php the_title();?></h2>
                </header>
            <?php endwhile; ?>
        </section>
    </main>
<?php get_footer();?>