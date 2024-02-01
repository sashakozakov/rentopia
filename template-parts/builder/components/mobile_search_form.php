<?php
$neighborhoods = $_GET['neighborhood'] ? $_GET['neighborhood'] : 'null';
$mobile = $_GET['mobile'] ? 'mobile_version' : 'null';
?>
<div class="mobile_search__form_btn hidden-sm-up">
	<svg width="37" height="37" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
		<g clip-path="url(#clip0_283_2284)">
			<path
				d="M21.5833 12.3333C23.2862 12.3333 24.6667 10.9528 24.6667 9.24996C24.6667 7.54708 23.2862 6.16663 21.5833 6.16663C19.8805 6.16663 18.5 7.54708 18.5 9.24996C18.5 10.9528 19.8805 12.3333 21.5833 12.3333Z"
				stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M6.16602 9.25H18.4993" stroke="white" stroke-width="1.5" stroke-linecap="round"
				  stroke-linejoin="round"/>
			<path d="M24.666 9.25H30.8327" stroke="white" stroke-width="1.5" stroke-linecap="round"
				  stroke-linejoin="round"/>
			<path
				d="M12.3333 21.5833C14.0362 21.5833 15.4167 20.2028 15.4167 18.5C15.4167 16.7971 14.0362 15.4166 12.3333 15.4166C10.6305 15.4166 9.25 16.7971 9.25 18.5C9.25 20.2028 10.6305 21.5833 12.3333 21.5833Z"
				stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M6.16602 18.5H9.24935" stroke="white" stroke-width="1.5" stroke-linecap="round"
				  stroke-linejoin="round"/>
			<path d="M15.416 18.5H30.8327" stroke="white" stroke-width="1.5" stroke-linecap="round"
				  stroke-linejoin="round"/>
			<path
				d="M26.2083 30.8333C27.9112 30.8333 29.2917 29.4528 29.2917 27.75C29.2917 26.0471 27.9112 24.6666 26.2083 24.6666C24.5055 24.6666 23.125 26.0471 23.125 27.75C23.125 29.4528 24.5055 30.8333 26.2083 30.8333Z"
				stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M6.16602 27.75H23.1243" stroke="white" stroke-width="1.5" stroke-linecap="round"
				  stroke-linejoin="round"/>
			<path d="M29.291 27.75H30.8327" stroke="white" stroke-width="1.5" stroke-linecap="round"
				  stroke-linejoin="round"/>
		</g>
		<defs>
			<clipPath id="clip0_283_2284">
				<rect width="37" height="37" fill="white"/>
			</clipPath>
		</defs>
	</svg>
</div>

<div class="mobile_search__form hidden-sm-up">
	<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>"
		  class="">
		<input class="d-none" id="s" name="s" type="text" placeholder="">
		<div>
			<?php
			$terms = get_terms(array(
				'taxonomy' => 'neighborhood',
				'orderby' => 'term_id',
				'order' => 'ASC',
			));
			?>
			<select id="mobile_neighborhood" name="mobile_neighborhood[]" multiple="multiple">
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
			<select id="mobile_bedrooms" name="mobile_bedrooms[]" multiple="">
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
			<select id="mobile_price" name="mobile_price">
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


</div>
