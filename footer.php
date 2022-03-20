		<footer class="site-footer u-textAlignCenter container">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'puma' ) ); ?>" ><?php printf( __( 'Proudly powered by %s', 'puma' ), 'WordPress' ); ?></a>
		</footer>
	</div>
	<div class="back-to-top u-hide" onclick="backToTop();">
		<span class="icon-circle-up"></span>
	</div>
	<?php // You can add your analystic code to the following hide tag and won't display.?>
	<div class="u-hide"></div>
	<?php wp_footer();?>
</body>
</html>