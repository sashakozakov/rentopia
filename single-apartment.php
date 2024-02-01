<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package _it_start
 */

get_header();
the_post();
global $post;
$preview = $_GET['preview'];
if ( $preview ) {
	$post_id             = $_GET['post_id'];
	$title               = $_GET['title'];
	$apartment_number    = $_GET['apartment_number'];
	$price               = $_GET['price'];
	$beds                = $_GET['bedrooms'];
	$bath                = $_GET['bathrooms'];
	$squares             = $_GET['squares_ft'];
	$move_in             = $_GET['move_in'];
	$first_month_free    = $_GET['first_month_free'] ? $_GET['first_month_free'] : get_field( 'first_month_free' );
	$new_to_market       = $_GET['new_to_market'];
	$overview_content    = $_GET['overview_content'];
	$user_agent          = $_GET['user_agent'];
	$building_amenities  = $_GET['building_amenities'];
	$apartment_amenities = $_GET['apartment_amenities'];
	$collections         = $_GET['collections'];
//	echo "<div class='mt-5 pt-5'></div>";
//	echo "<div class='preview_mode'></div>";
//	echo "preview - " . $preview . "<br>";

	$building_terms = array();
	foreach ( $building_amenities as $term_slug ) {
		$building_terms[] = get_term_by( 'slug', $term_slug, 'building_amenities' );
	}

	$apartment_terms = array();
	foreach ( $apartment_amenities as $term_slug ) {
		$apartment_terms[] = get_term_by( 'slug', $term_slug, 'apartment_amenities' );
	}

	$collections_terms = array();
	foreach ( $collections as $term_slug ) {
		$collections_terms[] = get_term_by( 'slug', $term_slug, 'collections' );
	}
} else {
	$title            = get_the_title();
	$apartment_number = get_field( 'apartment_number' );
	$price            = get_field( 'price' );
	$beds             = get_field( 'bedrooms' );
	$bath             = get_field( 'bathrooms' );
	$squares          = get_field( 'squares_ft' );
	$move_in          = get_field( 'move_in' );
	$first_month_free = get_field( 'first_month_free' );
	$new_to_market    = get_field( 'new_to_market' );
	$overview_content = get_field( 'overview_content' );
	$user_agent       = get_field( 'user_agent' );

	$connected_building = get_field( 'connected_building' );
	echo $connected_building;
	$building_terms    = wp_get_object_terms( $connected_building ? $connected_building : $post->ID, 'building_amenities', array(
//		'taxonomy' => 'building_amenities',
		'orderby' => 'term_id',
		'order'   => 'ASC',
	) );
	$apartment_terms   = get_terms( array(
		'taxonomy' => 'apartment_amenities',
		'orderby'  => 'term_id',
		'order'    => 'ASC',
	) );
	$collections_terms = get_the_terms( $post->ID, 'collections' );
}


//gallery section
$gallery_ids = get_field( 'gallery' );

//Nearby section
$nearby_group = get_field( 'nearby_group' );

$location = get_field( 'buildings_subtitle' );
$city     = get_field( 'city' );
$state    = get_field( 'state' );
$zip      = get_field( 'zip' );


// Get the post's URL that will be shared
$post_url = urlencode( esc_url( get_permalink( $post->ID ) ) );
// Get the post's title
$post_title = urlencode( $post->post_title );

// Compose the share links for Facebook, Twitter and Google+
$facebook_link = sprintf( 'https://www.facebook.com/sharer/sharer.php?u=%1$s', $post_url );
$twitter_link  = sprintf( 'https://twitter.com/intent/tweet?text=%2$s&url=%1$s', $post_url, $post_title );
$linkedin_link = sprintf( 'https://www.linkedin.com/shareArticle?mini=true&url=%1$s&title=%2$s', $post_url, $post_title );
?>


	<section class="single_appartament__banner">
		<div class="single_appartament__banner--img">
			<?php if ( $gallery_ids && count( $gallery_ids ) != 0 ): ?>
				<div class="swiper appartament_banner_slider">
					<div class="swiper-wrapper">
						<?php if ( has_post_thumbnail() ): ?>
							<div class="swiper-slide">
								<div>
									<?php the_post_thumbnail(); ?>
								</div>
							</div>
						<?php endif; ?>
						<?php foreach ( $gallery_ids as $gallery_id ): ?>
							<div class="swiper-slide">
								<div>
									<?php echo wp_get_attachment_image( $gallery_id, 'full' ); ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="swiper-pagination hidden-md-up"></div>
					<div class="swiper-button-prev">
						<svg width="31" height="26" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd"
								  d="M4.8281 14.25L13.8352 24.1592L11.9852 25.8407L0.313477 13L11.9852 0.15918L13.8352 1.84073L4.8281 11.75L30.0899 11.75V14.25L4.8281 14.25Z"
								  fill="#2A2F38"/>
						</svg>
					</div>
					<div class="swiper-button-next">
						<svg width="31" height="26" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd"
								  d="M19.0227 0.15918L30.6944 13L19.0227 25.8407L17.1727 24.1592L26.1798 14.25L0.917969 14.25V11.75L26.1798 11.75L17.1727 1.84073L19.0227 0.15918Z"
								  fill="#2A2F38"/>
						</svg>
					</div>
				</div>
			<?php else: ?>
				<div class="inner_img">
					<?php the_post_thumbnail(); ?>
				</div>
			<?php endif; ?>
			<svg class="hidden-md-up" width="376" height="67" viewBox="0 0 376 67" fill="none"
				 xmlns="http://www.w3.org/2000/svg">
				<path
					d="M44 28.5C25.5385 20.3077 16.0494 14.6634 0 3.5V67H375.5V0C375.5 0 361.5 9 352 14C342.5 19 315.5 29.5 304 33.5C292.5 37.5 277 41.5 258 45.5C239 49.5 231 50 209.5 52C188 54 174 54.5 163.5 54C153 53.5 125 51 106.5 47.5C88 44 61 35 44 28.5Z"
					fill="white"/>
			</svg>
			<svg class="visible-md-up" width="1045" height="635" viewBox="0 0 1045 635" fill="none"
				 xmlns="http://www.w3.org/2000/svg">
				<path
					d="M1 0V24.316C1.51504 66.1878 4.80853 94.9145 10 138C13.5197 171.002 17.7132 186.88 21.5 213.5C27.0202 247.409 32.1388 265.632 40.5 298.5C52.1259 340.376 59.9608 363.17 78.5 403.5C97.3343 443.377 105.769 458.098 125.5 488C140.315 508.678 149.471 520.234 166 537.5C183.066 556.546 193.559 565.076 213.5 579C238.995 596.864 254.718 603.756 284 615L284.267 615.088C305.556 622.149 317.514 626.115 342 629.5C362.78 632.892 377.793 633.108 407 633L473.5 625L508 618C508 618 530 612 541.5 608.5C553 605 561.5 601 561.5 601C567.403 598.387 616.201 575.758 624.5 571.5C664.992 552.659 673.294 549.418 715.5 531.5C715.5 531.5 821 490 860.5 477C900 464 953.5 449 953.5 449L1003.5 435.5L1045 425V635H1V24.316C0.906329 16.7007 0.904563 8.65047 1 0Z"
					fill="white"/>
			</svg>
		</div>

		<div class="container padding-top">
			<div class="visible-md-up">
				<?php get_template_part( 'template-parts/breadcrumbs' ); ?>
			</div>

			<span class="d-block single_appartament__banner--id hidden-md-up">
				ID#
				<?php echo $post->ID; ?>
			</span>

			<p class="text-xl single_appartament__banner--location">
				<?php if ( $location ): ?>
					<?php echo $location; ?>
				<?php else: ?>
					<?php
					$taxonomy       = 'neighborhood';
					$primary_cat_id = get_post_meta( $post->ID, '_yoast_wpseo_primary_' . $taxonomy, true );
					if ( $primary_cat_id ) { ?>
						<?php $primary_cat = get_term( $primary_cat_id, $taxonomy );
						if ( isset( $primary_cat->name ) ) {
							echo $primary_cat->name;
						}
						?>
					<?php } ?>
				<?php endif; ?>
			</p>
			<h1 class="single_appartament__banner--title h3">
				<?php echo $title; ?>
				<?php echo $apartment_number ?>
			</h1>
			<span class="d-block single_appartament__banner--id visible-md-up">
				ID#
				<?php echo $post->ID; ?>
			</span>

		</div>
	</section>


	<section class="nav_grid_container">
		<div class="container">
			<div class="d-flex flex-wrap nav_grid">
				<?php if ( $price ):
					$price = number_format( $price, 0, '.', ',' );
					?>
					<div class="nav_grid--elem price_block">
						$<span><?php echo $price; ?></span>/<?php _e( 'month', '_it_start' ); ?>
					</div>
				<?php endif; ?>
				<?php if ( $beds ): ?>
					<div class="nav_grid--elem elem_beds">
						<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<use xlink:href="#beds"></use>
						</svg>
						<?php echo $beds; ?>
						<?php _e( 'Beds', '_it_start' ); ?>
					</div>
				<?php endif; ?>
				<?php if ( $bath ): ?>
					<div class="nav_grid--elem elem_bath">
						<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<use xlink:href="#bath"></use>
						</svg>
						<?php echo $bath; ?><?php _e( 'Bath', '_it_start' ); ?>
					</div>
				<?php endif; ?>
				<?php if ( $squares ): ?>
					<div class="nav_grid--elem elem_sq">
						<span><?php echo $squares; ?></span>
						<?php _e( 'Sq. ft', '_it_start' ); ?>
					</div>
				<?php endif; ?>
				<?php if ( $move_in ):
					$newDate = date( "M d", strtotime( $move_in ) );
					?>
					<div class="nav_grid--elem elem_date">
						<svg width="25" height="24" viewBox="0 0 25 24" fill="none">
							<use xlink:href="#calendar"></use>
						</svg>
						<span class="visible-md-up">
							<?php _e( 'Move in', '_it_start' ); ?>
							<?php echo $newDate; ?>
						</span>
						<span class="hidden-md-up">
						<?php echo $newDate; // output: Sep 30
						?>
						</span>

					</div>
				<?php endif; ?>

				<div class="nav_grid__tabs visible-md-up">
					<?php if ( $overview_content || $new_to_market || $first_month_free ): ?>
						<a href="#description"><?php _e( 'Description', '_it_start' ); ?></a>
					<?php endif; ?>
					<?php if ( $building_terms || $apartment_terms || $collections_terms ): ?>
						<a href="#amenities"><?php _e( 'Amenities', '_it_start' ); ?></a>
					<?php endif; ?>
					<?php if ( $gallery_ids || has_post_thumbnail() ) : ?>
						<a href="#images"><?php _e( 'Images', '_it_start' ); ?></a>
					<?php endif; ?>
					<?php if ( have_rows( 'neighborhood' ) ) : ?>
						<a href="#neighborhood"><?php _e( 'Neighborhood', '_it_start' ); ?></a>
					<?php endif; ?>
					<a href="#nearby"><?php _e( 'Nearby', '_it_start' ); ?></a>
				</div>
			</div>


			<div class="nav_grid__tabs hidden-md-up">
				<?php if ( $overview_content || $new_to_market || $first_month_free ): ?>
					<a href="#description"><?php _e( 'Description', '_it_start' ); ?></a>
				<?php endif; ?>
				<?php if ( $building_terms || $apartment_terms || $collections_terms ): ?>
					<a href="#amenities"><?php _e( 'Amenities', '_it_start' ); ?></a>
				<?php endif; ?>
				<?php if ( $gallery_ids || has_post_thumbnail() ) : ?>
					<a href="#images"><?php _e( 'Images', '_it_start' ); ?></a>
				<?php endif; ?>
				<?php if ( have_rows( 'neighborhood' ) ) : ?>
					<a href="#neighborhood"><?php _e( 'Neighborhood', '_it_start' ); ?></a>
				<?php endif; ?>
				<a href="#nearby"><?php _e( 'Nearby', '_it_start' ); ?></a>
			</div>
		</div>
	</section>


	<div class="anchor" id="amenities"></div>
	<section class="apartments_info_section">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-md-6">
					<?php if ( $building_terms || $apartment_terms || $collections_terms ): ?>
						<h4 class="apartments_info_section--title"><?php _e( 'Amenities', '_it_start' ); ?></h4>
					<?php endif; ?>
					<div class="row">
						<?php if ( $building_terms ): ?>
							<div class="col-6">
								<div class="building_block">
									<span class="subtitle"><?php _e( 'Building', '_it_start' ); ?></span>
									<ul>
										<?php foreach ( $building_terms as $term ) {
											$term_id          = $term->term_id;
											$term_id_prefixed = 'building_amenities' . '_' . $term_id;
											$icon             = get_field( 'icon', $term_id_prefixed );
											?>
											<li class="d-flex flex-wrap align-items-center">
												<?php if ( $icon ) : ?>
													<div class="icon_block">
														<?php echo wp_get_attachment_image( $icon, 'full' ); ?>
													</div>
												<?php endif; ?>
												<span>
												<?php echo $term->name; ?>
											</span>
											</li>
										<?php } ?>
									</ul>
								</div>
							</div>
						<?php endif; ?>
						<?php if ( $apartment_terms ): ?>
							<div class="col-6">
								<div class="apartment_block">
									<span class="subtitle"><?php _e( 'Apartment', '_it_start' ); ?></span>
									<ul>
										<?php foreach ( $apartment_terms as $term ) {
											$term_id          = $term->term_id;
											$term_id_prefixed = 'building_amenities' . '_' . $term_id;
											$icon             = get_field( 'icon', $term_id_prefixed );
											?>
											<li class="d-flex flex-wrap align-items-center">
												<?php if ( $icon ) : ?>
													<div class="icon_block">
														<?php echo wp_get_attachment_image( $icon, 'full' ); ?>
													</div>
												<?php endif; ?>
												<span>
												<?php echo $term->name; ?>
											</span>
											</li>
										<?php } ?>
									</ul>
								</div>
							</div>
						<?php endif; ?>
					</div>

					<?php if ( $collections_terms ): ?>
						<div class="collections_container">
							<span class="subtitle"><?php _e( 'Collections', '_it_start' ); ?></span>
							<div class="collections_list d-flex flex-row flex-wrap">
								<?php
								// displaying the category name of custom post type inside the loop
								foreach ( $collections_terms as $term ) {
									$term_id          = $term->term_id;
									$term_id_prefixed = 'collections' . '_' . $term_id;
									$icon             = get_field( 'icon', $term_id_prefixed );
									$image            = get_field( 'image', $term_id_prefixed );
									?>

									<h6>
										<a href="<?php echo get_term_link( $term ) ?>">
											<?php if ( $icon ) : ?>
												<span class="icon_block">
											<?php echo wp_get_attachment_image( $icon, 'full' ); ?>
										</span>
											<?php endif; ?>
											<span class="d-block">
									<?php echo $term->name; ?>
									</span>
										</a>
									</h6>
								<?php } ?>
							</div>
						</div>
					<?php endif; ?>


				</div>

				<div class="col-md-6 col-xl-5 d-flex flex-wrap flex-md-column overview_container mt-4 mt-md-0">

					<?php get_template_part( 'template-parts/builder/components/small_agent_block', null, [
						'class'            => 'visible-md-up',
						'preview_agent_id' => $user_agent
					] ); ?>

					<?php if ( $overview_content || $new_to_market || $first_month_free ): ?>
						<div class="overview">
							<div class="anchor" id="description"></div>
							<h4>
								<?php _e( 'Description', '_it_start' ); ?>
							</h4>
							<?php if ( $first_month_free || $new_to_market ): ?>
								<div class="labels_block">
									<?php if ( $first_month_free ): ?>
										<span><?php _e( 'FIRST MONTH FREE!', '_it_start' ); ?></span>
									<?php endif; ?>
									<?php if ( $new_to_market ): ?>
										<span><?php _e( 'NEW TO MARKET', '_it_start' ); ?></span>
									<?php endif; ?>
								</div>
							<?php endif; ?>
							<?php if ( $overview_content ): ?>
								<div class="text-md">
									<?php echo $overview_content; ?>
								</div>
							<?php endif; ?>

							<div class="btn-group">
								<?php the_favorites_button( get_the_id() ); ?>


								<span class="share-btn btn btn-outline d-inline-block">
									<svg width="23" height="23" viewBox="0 0 23 23" fill="none"
										 xmlns="http://www.w3.org/2000/svg">
										<use xlink:href="#share"></use>
									</svg>
									<?php _e( 'Share', '_it_start' ); ?>
									<span class="share_group">
										<a href="<?php echo $facebook_link; ?>" target="_blank" rel="nofollow">
											<svg width="23" height="23" viewBox="0 0 23 23" class="facebook_icon"
												 fill="none" xmlns="http://www.w3.org/2000/svg">
												<use xlink:href="#facebook"></use>
											</svg>
										</a>
										<a href="<?php echo $linkedin_link; ?>" target="_blank" rel="nofollow">
											<svg width="23" height="23" viewBox="0 0 23 23"
												 xmlns="http://www.w3.org/2000/svg">
												<use xlink:href="#linkedin"></use>
											</svg>
										</a>
										<a href="<?php echo $twitter_link; ?>" target="_blank" rel="nofollow">
											<svg width="23" height="23" viewBox="0 0 23 23"
												 xmlns="http://www.w3.org/2000/svg">
												<use xlink:href="#twitter"></use>
											</svg>
										</a>
									</span>
								</span>
							</div>
						</div>
					<?php endif; ?>

				</div>

			</div>
		</div>
	</section>


<?php if ( $gallery_ids == false && has_post_thumbnail() ) : ?>
	<div class="anchor" id="images"></div>
	<section class="appartament_gallery">
		<svg class="svg_12" width="420" height="414" viewBox="0 0 420 414" fill="none"
			 xmlns="http://www.w3.org/2000/svg">
			<use xlink:href="#svg_elem_12"></use>
		</svg>
		<div class="container">
			<h4 class="appartament_gallery--title">
				<?php _e( 'Images', '_it_start' ); ?>
			</h4>
			<div class="appartament_gallery__thumb">
				<div>
					<?php the_post_thumbnail(); ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if ( $gallery_ids ) : ?>
	<div class="anchor" id="images"></div>
	<section class="appartament_gallery">
		<svg class="svg_12" width="420" height="414" viewBox="0 0 420 414" fill="none"
			 xmlns="http://www.w3.org/2000/svg">
			<use xlink:href="#svg_elem_12"></use>
		</svg>
		<div class="container">
			<h4 class="appartament_gallery--title">
				<?php _e( 'Images', '_it_start' ); ?>
			</h4>
			<div class="swiper appartament_gallery__slider">
				<div class="swiper-wrapper">
					<?php if ( has_post_thumbnail() ): ?>
						<div class="swiper-slide">
							<div>
								<?php the_post_thumbnail(); ?>
							</div>
						</div>
					<?php endif; ?>
					<?php foreach ( $gallery_ids as $gallery_id ): ?>
						<div class="swiper-slide">
							<div>
								<?php echo wp_get_attachment_image( $gallery_id, 'full' ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="swiper-button-prev">
					<svg width="31" height="26" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd"
							  d="M4.8281 14.25L13.8352 24.1592L11.9852 25.8407L0.313477 13L11.9852 0.15918L13.8352 1.84073L4.8281 11.75L30.0899 11.75V14.25L4.8281 14.25Z"
							  fill="#2A2F38"/>
					</svg>
				</div>
				<div class="swiper-button-next">
					<svg width="31" height="26" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd"
							  d="M19.0227 0.15918L30.6944 13L19.0227 25.8407L17.1727 24.1592L26.1798 14.25L0.917969 14.25V11.75L26.1798 11.75L17.1727 1.84073L19.0227 0.15918Z"
							  fill="#2A2F38"/>
					</svg>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>


<?php if ( $user_agent ): ?>
	<?php get_template_part( 'template-parts/builder/components/big_agent_block', null, [ 'preview_agent_id' => $user_agent ] ); ?>
<?php endif; ?>


<?php if ( have_rows( 'neighborhood' ) ) : ?>
	<div class="anchor" id="neighborhood"></div>
	<?php while ( have_rows( 'neighborhood' ) ) : the_row();
		$neighborhood_title = get_sub_field( 'title' );
		$subtitle           = get_sub_field( 'subtitle' );
		$content            = get_sub_field( 'content' );
		$image              = get_sub_field( 'image' );
		?>
		<section class="module_blog_post">

			<svg class="svg svg_13 visible-md-up" width="374" height="318" viewBox="0 0 374 318" fill="none"
				 xmlns="http://www.w3.org/2000/svg">
				<use xlink:href="#svg_elem_13"></use>
			</svg>

			<div class="container">
				<div class="row align-items-center flex-md-row-reverse">
					<?php if ( $image ) : ?>
						<div class="col-lg-7 col-md-6 text-center text-md-right">
							<?php echo wp_get_attachment_image( $image, 'full' ); ?>
						</div>
					<?php endif; ?>
					<div class="col-lg-5 col-md-6">
						<div class="module_blog_post--content text-center text-md-left text-grey">
							<?php if ( $neighborhood_title ): ?>
								<h4>
									<?php echo $neighborhood_title; ?>
								</h4>
							<?php endif; ?>
							<?php if ( $subtitle ): ?>
								<span class="subtitle">
									<?php echo $subtitle; ?>
							</span>
							<?php endif; ?>
							<?php if ( $content ): ?>
								<?php echo $content; ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>

		</section>

	<?php endwhile; ?>
<?php endif; ?>

	<div class="anchor" id="nearby"></div>
	<div class="nearby_section">
		<div class="container">
			<h4 class="text-center mb-5">
				<?php _e( 'See What’s Nearby', '_it_start' ); ?>
			</h4>
			<div class="row flex-md-row-reverse">
				<div class="col-md-6">
					<div class="nearby_section--right_col">
						<?php if ( have_rows( 'subway_lines' ) ) : ?>
							<div>
								<span class="subtitle"><?php _e( 'subway lines', '_it_start' ); ?></span>
								<ul class="subway_lines">
									<?php while ( have_rows( 'subway_lines' ) ) : the_row();
										$path  = IT_IMG . 'trains/' . get_sub_field( 'type' ) . '.svg';
										$title = get_sub_field( 'title' );
										$value = get_sub_field( 'value' );
										?>
										<?php if ( $title || $value ): ?>
											<li>
											<span>
												<img src="<?php echo $path; ?>" alt="">
												<?php the_sub_field( 'title' ); ?>
											</span>
												<span>
												<?php the_sub_field( 'value' ); ?>
											</span>
											</li>
										<?php endif; ?>
									<?php endwhile; ?>
								</ul>
							</div>
						<?php endif; ?>

						<?php if ( have_rows( 'nearby_group' ) ) : ?>
							<?php while ( have_rows( 'nearby_group' ) ) : the_row(); ?>
								<?php if ( have_rows( 'supermarket' ) ) : ?>
									<div>
										<span class="subtitle"><?php _e( 'supermarket', '_it_start' ); ?></span>
										<ul class="supermarket">
											<?php while ( have_rows( 'supermarket' ) ) : the_row(); ?>
												<li>
													<span>
													<?php the_sub_field( 'title' ); ?>
													</span>
													<span>
													<?php the_sub_field( 'value' ); ?>
													</span>
												</li>
											<?php endwhile; ?>
										</ul>
									</div>
								<?php endif; ?>

								<?php if ( have_rows( 'restaurants_&_bars' ) ) : ?>
									<div>
										<span class="subtitle"><?php _e( 'Restaurants & Bars', '_it_start' ); ?></span>
										<ul class="restaurants_and_bars">
											<?php while ( have_rows( 'restaurants_&_bars' ) ) : the_row(); ?>
												<li>
													<span>
													<?php the_sub_field( 'title' ); ?>
													</span>
													<span>
													<?php the_sub_field( 'value' ); ?>
													</span>
												</li>
											<?php endwhile; ?>
										</ul>
									</div>
								<?php endif; ?>

							<?php endwhile; ?>
						<?php endif; ?>
					</div>
				</div>
				<div class="col-md editor mt-4 mt-md-0">
					<?php $title = str_replace( [ '#', ' ' ], [ '', '%20' ], get_the_title() );
					$location    = str_replace( ' ', '%20', $location );
					$city        = str_replace( ' ', '%20', $city );
					$state       = str_replace( ' ', '%20', $state );
					$zip         = str_replace( ' ', '%20', $zip );
					?>

					<!--					<iframe width="100%" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=280%20--><?php //echo $title; ?><!--,%20--><?php //echo $location; ?><!--&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>-->
					<iframe width="100%" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=280%20<?php echo implode(',%20', array_filter([$title, $location, $city, $state, $zip])); ?>&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
				</div>
			</div>
		</div>
	</div>


<?php
$args = array(
//	'post_type'      => 'apartment',
	'posts_per_page' => 3,
	'post__not_in'   => [ get_the_ID() ]
);
if ( is_singular( 'apartment' ) ) {
	$args['post_type'] = 'apartment';
} else {
	$args['post_type'] = 'building';
}
$query = new WP_Query( $args ); ?>
<?php if ( $query->have_posts() ): ?>
	<section class="recent_apartments">
		<div class="container">
			<h4 class="mb-5 text-center">
				<?php _e( 'Apartments You might like', '_it_start' ); ?>
			</h4>
			<div class="row appartaments__grid">
				<?php while ( $query->have_posts() ): $query->the_post(); ?>
					<div class="col-lg-4 col-md-6">
						<?php get_template_part( 'template-parts/builder/components/appartament_item' ); ?>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</section>
<?php endif;
wp_reset_postdata(); ?>


<?php
get_footer();
