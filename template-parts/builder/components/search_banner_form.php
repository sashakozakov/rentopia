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
		<?php _e('find', 'rentopia'); ?>
	</button>
	<input type="hidden" name="filtersearch" value="1">
	<input type="hidden" name="s" value="">
</form>
