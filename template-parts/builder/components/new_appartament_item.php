<?php

$buildings_subtitle = get_field( 'buildings_subtitle' );
$price              = get_field( 'price' );
$bedrooms           = get_field( 'bedrooms' );
$bathrooms          = get_field( 'bathrooms' );
$gallery            = get_field( 'gallery' );
$first_month_free   = get_field( 'first_month_free' );
?>

<div class="new_appartament__item">
	<?php if ( $gallery ) : ?>
		<div class="new_appartament__item__slider">

			<?php if ( has_post_thumbnail() ): ?>
				<div class="slide">
					<a href="<?php the_permalink(); ?>" class="has_img">
						<?php the_post_thumbnail( 'full', array( "class" => "img-cover" ) ); ?>
					</a>
				</div>
			<?php endif; ?>
			<?php
			// Assuming $gallery is an array of image IDs
			$gallery_count = count( $gallery );
			$max_images    = min( $gallery_count, 4 );

			for ( $i = 0; $i < $max_images; $i ++ ):
				?>
				<div class="slide">
					<a href="<?php the_permalink(); ?>" class="has_img">
						<?php echo wp_get_attachment_image( $gallery[ $i ], 'full' ); ?>
					</a>
				</div>
			<?php
			endfor;
			?>


			<button class="slider__btn slider__btn--left">
			<svg width="22" height="27" viewBox="0 0 22 27" fill="none" xmlns="http://www.w3.org/2000/svg">
				<g filter="url(#filter0_d_42_152)">
					<path
						d="M15.5498 19.0326L10.2455 13.7167L15.5498 8.40076L13.9168 6.76776L6.9679 13.7167L13.9168 20.6656L15.5498 19.0326Z"
						fill="white"/>
				</g>
				<defs>
					<filter id="filter0_d_42_152" x="0.650691" y="0.450556" width="21.2163" height="26.5323"
							filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
						<feFlood flood-opacity="0" result="BackgroundImageFix"/>
						<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
									   result="hardAlpha"/>
						<feOffset/>
						<feGaussianBlur stdDeviation="3.1586"/>
						<feComposite in2="hardAlpha" operator="out"/>
						<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.5 0"/>
						<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_42_152"/>
						<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_42_152" result="shape"/>
					</filter>
				</defs>
			</svg>
			</button>
			<button class="slider__btn slider__btn--right">
				<svg width="22" height="27" viewBox="0 0 22 27" fill="none" xmlns="http://www.w3.org/2000/svg">
					<g filter="url(#filter0_d_42_155)">
						<path
							d="M7.02863 19.0326L12.333 13.7167L7.02863 8.40076L8.66162 6.76776L15.6105 13.7167L8.66162 20.6656L7.02863 19.0326Z"
							fill="white"/>
					</g>
					<defs>
						<filter id="filter0_d_42_155" x="0.711421" y="0.450556" width="21.2163" height="26.5323"
								filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
							<feFlood flood-opacity="0" result="BackgroundImageFix"/>
							<feColorMatrix in="SourceAlpha" type="matrix"
										   values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
							<feOffset/>
							<feGaussianBlur stdDeviation="3.1586"/>
							<feComposite in2="hardAlpha" operator="out"/>
							<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.5 0"/>
							<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_42_155"/>
							<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_42_155" result="shape"/>
						</filter>
					</defs>
				</svg>
			</button>
			<div class="dots"></div>
		</div>
	<?php else: ?>
		<div class="new_appartament__item--img">
			<?php if ( has_post_thumbnail() ): ?>
				<a href="<?php the_permalink(); ?>" class="has_img">
					<?php the_post_thumbnail( 'full', array( "class" => "img-cover" ) ); ?>
				</a>
			<?php else: ?>
				<a href="<?php the_permalink(); ?>">
					<?php it_image_placeholder(); ?>
				</a>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<div class="new_appartament__item--content">
		<h5 class="new_appartament__item--title">
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</h5>
		<?php if ( $buildings_subtitle ): ?>
			<p class="new_appartament__item--location">
				<?php echo $buildings_subtitle; ?>
			</p>
		<?php endif; ?>
		<div class="new_appartament__item--footer">
			<?php if ( $bedrooms || $bathrooms ): ?>
				<div class="new_appartament__item--exclusives">
					<?php if ( $bedrooms ): ?>
						<span>
							<?php echo $bedrooms; ?>
							<?php _e( 'BR', '_it_start' ); ?>
						</span>
					<?php endif; ?>
					<?php if ( $bathrooms ): ?>
						<span>
							<?php echo $bathrooms; ?>
							<?php _e( 'BT', '_it_start' ); ?>
						</span>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<div class="price_block">
				<?php if ( $price ):
					$price = number_format( $price, 0, '.', ',' );
					?>
					<?php if ( $first_month_free ): ?>
					<strong class="d-block new_appartament__item--price actual_price">
						$0,000 /<?php _e( 'Month', '_rentopia' ); ?>
					</strong>
					<del class="new_appartament__item--price">
						$<?php echo $price; ?>/<?php _e( 'Month', '_rentopia' ); ?>
					</del>

				<?php else: ?>
					<strong class="d-block new_appartament__item--price">
						$<?php echo $price; ?>/<?php _e( 'Month', '_rentopia' ); ?>
					</strong>
				<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
