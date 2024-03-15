<?php
$neighborhoods = $_GET['neighborhood'] ? $_GET['neighborhood'] : '';
?>
<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>"
	  class="search_banner__form">
	<div class="search_banner__form--close hidden-sm-up"></div>
	<!--	<input class="d-none" id="s" name="s" type="text" placeholder="" >-->
	<div>
		<?php
		$terms = get_terms(array(
			'taxonomy' => 'neighborhood',
			'orderby' => 'term_id',
			'order' => 'ASC',
		));
		?>
		<select id="neighborhood" name="neighborhood[]" multiple="multiple">
			<?php
			// Loop through each term and display its name and description
			foreach ($terms as $term) {
				$term_name = $term->name;
				$term_slug = $term->slug; ?>
				<option value="<?php echo $term_slug; ?>"><?php echo $term_name; ?></option>
			<?php } ?>
		</select>
	</div>
	<div>
		<select id="bedrooms" name="bedrooms[]" multiple="multiple">
			<option value="1_bedroom"><?php _e('1 Bedroom', 'rentopia'); ?></option>
			<option value="2_bedroom"><?php _e('2 Bedroom', 'rentopia'); ?></option>
			<option value="3_bedroom"><?php _e('3 Bedroom', 'rentopia'); ?></option>
			<option value="4_bedroom"><?php _e('4 Bedroom', 'rentopia'); ?></option>
			<option value="5_bedroom"><?php _e('5 Bedroom', 'rentopia'); ?></option>
			<option value="6_bedroom"><?php _e('6 Bedroom', 'rentopia'); ?></option>
			<option value="7_bedroom"><?php _e('7 Bedroom', 'rentopia'); ?></option>
		</select>
	</div>
	<div>
		<select placeholder="Price" data-allow-clear="1" name="price" id="price">
			<option value="" class="d-none"></option>
			<option value="1000-1999">$1,000-$2,000</option>
			<option value="2000-2999">$2,000-$3,000</option>
			<option value="3000-999999"><?php _e('Over', '_it_start'); ?> $3,000</option>
		</select>
	</div>
	<button>
		<?php _e('Search', 'rentopia'); ?>
		<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M10.4212 9.0319H9.77591L9.5472 8.81136C10.3477 7.88019 10.8296 6.67129 10.8296 5.35621C10.8296 2.42382 8.45266 0.046875 5.52027 0.046875C2.58789 0.046875 0.210938 2.42382 0.210938 5.35621C0.210938 8.2886 2.58789 10.6655 5.52027 10.6655C6.83535 10.6655 8.04425 10.1836 8.97542 9.38314L9.19597 9.61185V10.2571L13.2801 14.3331L14.4971 13.116L10.4212 9.0319ZM5.52027 9.0319C3.48639 9.0319 1.84458 7.39009 1.84458 5.35621C1.84458 3.32233 3.48639 1.68052 5.52027 1.68052C7.55416 1.68052 9.19597 3.32233 9.19597 5.35621C9.19597 7.39009 7.55416 9.0319 5.52027 9.0319Z" fill="#181B08"/>
		</svg>
	</button>
	<input type="hidden" name="filtersearch" value="1">
	<input type="hidden" name="s" value="">
</form>
