<?php /* Template Name: Collections */

get_header();
the_post();
?>
	<div class="padding-top">

		<?php get_template_part('template-parts/breadcrumbs'); ?>

		<?php get_template_part('template-parts/builder/components/search_banner'); ?>

		<section class="buildings_section collections_section">
			<div class="container">

				<div class="row buildings__grid">
					<?php
					$terms = get_terms(array(
						'taxonomy' => 'collections',
						'orderby' => 'term_id',
						'number' => 6,
						'order' => 'ASC',
					));

					get_template_part('template-parts/components/collections_loop', null, ['terms' => $terms]); ?>
				</div>
				<?php
				//			$title = wp_kses_post(get_sub_field('title'));
				$wrapper = 'text-center mt-5 pt-3 preloader_container';
				$title = __('Load more collections', '_it_start');;
				$class = 'load-more-btn btn btn-outline btn-md';
				$url = "#";
				$target = false;

				get_template_part('template-parts/components/button', null, ['classes' => $class, 'title' => $title, 'url' => $url, 'target' => $target, 'wrapper' => $wrapper]); ?>

			</div>
		</section>
	</div>

	<script>
		//jQuery(document).ready(function($) {
		//	var page = 2; // set the initial page number
		//	//var maxPages = <?php ////echo $wp_query->max_num_pages; ?>////; // get the maximum number of pages
		//	var next = $('.buildings__grid .col-lg-6').length + 1;
		//
		//	$('.load-more-btn').on('click', function(e) {
		//		e.preventDefault();
		//
		//		var data = {
		//			'action': 'load_more',
		//			'page': page,
		//			next: next
		//		};
		//
		//		$.ajax({
		//			url: wpApiSettings.ajaxUrl,
		//			type: 'POST',
		//			data: data,
		//			success: function(response) {
		//				console.log(response);
		//				$('.buildings__grid').append(response);
		//
		//				// page++;
		//
		//				// if (page > maxPages) {
		//					// $('.load-more-btn').hide();
		//				// }
		//			},
		//			error: function(xhr, status, error) {
		//				console.log(xhr.responseText);
		//			}
		//		});
		//	});
		//});
	</script>
<?php
get_footer();
