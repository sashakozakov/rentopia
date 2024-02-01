<?php /* Template Name: Neighborhood */

get_header();
the_post();
?>


	<div class="padding-top">

		<?php get_template_part('template-parts/breadcrumbs'); ?>

		<?php get_template_part('template-parts/builder/components/search_banner'); ?>

		<section class="buildings_section neighborhoods_section">
			<div class="container">
				<?php /*
				<form action="#" class="buildings_search_form">
					<input type="text" placeholder="<?php _e('Search Neighborhoods...', '_it_start'); ?>">
					<button>
						<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M8.83333 16.4167C13.0215 16.4167 16.4167 13.0215 16.4167 8.83333C16.4167 4.64517 13.0215 1.25 8.83333 1.25C4.64517 1.25 1.25 4.64517 1.25 8.83333C1.25 13.0215 4.64517 16.4167 8.83333 16.4167Z"
								stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M20.75 20.75L14.25 14.25" stroke-width="1.5" stroke-linecap="round"
								  stroke-linejoin="round"/>
						</svg>
					</button>
					<input type="hidden" name="post_type" value="neighborhood"/>
				</form>
 */ ?>

				<div class="row buildings__grid">
					<?php
					$terms = get_terms(array(
						'taxonomy' => 'neighborhood',
						'orderby' => 'term_id',
						'number' => 12,
						'order' => 'ASC',
					));
					get_template_part('template-parts/components/neighborhoods_loop', null, ['terms' => $terms]); ?>

				</div>
				<?php
				//			$title = wp_kses_post(get_sub_field('title'));
				$wrapper = 'text-center mt-5 pt-3 preloader_container';
				$title = __('Load more Neighborhoods', '_it_start');;
				$class = 'load-more-btn btn btn-outline btn-md';
				$url = "#";
				$target = false;

				get_template_part('template-parts/components/button', null, ['classes' => $class, 'title' => $title, 'url' => $url, 'target' => $target, 'wrapper' => $wrapper]); ?>
			</div>
		</section>
	</div>


<?php
get_footer();
