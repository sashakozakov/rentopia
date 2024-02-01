<?php
$mobile_feature_image = get_field( 'mobile_feature_image' );
?>
<section class="search_banner">
	<?php if ( $mobile_feature_image ) : ?>
		<?php echo wp_get_attachment_image( $mobile_feature_image, 'full', '', array( "class" => "hidden-sm-up search_banner--img" ) ); ?>
	<?php endif; ?>
	<div class="container d-flex flex-column">
		<div class="text-lg text-center">
			<p>
				<?php the_post_thumbnail( '', array( 'class' => 'search_banner--desktop_img visible-sm-up' ) ); ?>
			</p>
			<?php the_content(); ?>
		</div>

		<?php get_template_part( 'template-parts/builder/components/search_banner_form' ); ?>
	</div>
</section>
