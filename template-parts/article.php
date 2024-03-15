<?php
$i     = isset( $args['item'] ) ? $args['item'] : null;
$paged = isset( $args['paged'] ) ? $args['paged'] : null;
?>
<div class="<?php echo $i == 1 && $paged == 1 ? 'col-lg-12' : 'col-lg-4'; ?> <?php echo is_search() ? 'col-xl-3' : ''; ?>">
	<article class="article">
		<a class="article__thumbnail" href="<?php the_permalink(); ?>">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'large', [ 'class' => 'img-cover' ] ); ?>
			<?php else: ?>
				<?php it_image_placeholder(); ?>
			<?php endif; ?>
		</a>
		<div class="article__content">
			<h5 class="article__title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h5>
			<div class="article--meta text-center">
				<span class="article--author">
					<?php
					$author_id         = get_the_author_meta( 'ID' );
					$author_first_name = get_the_author_meta( 'first_name', $author_id );
					$author_last_name  = get_the_author_meta( 'last_name', $author_id );

					echo " $author_first_name $author_last_name"
					?>
				</span>
				<span
					class="article--date text-uppercase"><?php echo get_the_date( 'M d Y' ); ?></span>
			</div>
			<?php if ( $i == 1 && $paged == 1 ): ?>
				<div class="article__excerpt text-md text-capitalize">
					<p>
						<?php it_excerpt( 40 ); ?>
					</p>
				</div>
			<?php endif; ?>
		</div>
	</article>
</div>
