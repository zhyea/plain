<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class();?>>
<div class="surface-content">
	<header class="site-header u-textAlignCenter">
		<div class="header-inner">
			<h1 class="site-title">
				<a href="<?php echo home_url();?>" title="<?php bloginfo( 'name' ); ?>"><?php bloginfo( 'name' ) ?></a>
			</h1>
			<p class="site-description"><?php get_bloginfo( 'description', 'display' ); ?></p>
			<div class="social-links">
				<?php echo header_social_link();?>
			</div>
			<div class="">
				<?php get_search_form();?>
			</div>
		</div>
		<div class="custom-header-media">
			<?php the_custom_header_markup(); ?>
		</div>
    </header>
    <nav class="top-nav u-textAlignCenter">
        <div class="layoutSingleColumn">
            <?php wp_nav_menu( array( 'theme_location' => 'puma','menu_class'=>'top-nav-items','container'=>'ul','fallback_cb' => 'link_to_menu_editor')); ?>
        </div>
    </nav>