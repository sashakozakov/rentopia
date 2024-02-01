<?php
/**
 * Demo page with code snippets and useful examples.
 *
 * @package _it_start
 */

get_header();
the_post();
?>

	<section class="submit_application_section">
		<svg class="svg submit_application_section_svg_1" width="437" height="387" viewBox="0 0 437 387" fill="none"
			 xmlns="http://www.w3.org/2000/svg">
			<path opacity="0.4" d="M-95.6142 84.6635L238.613 2.36512L431.16 7.53031L32.7719 382.713L-95.6142 84.6635Z"
				  stroke="#01CCAD" stroke-width="4"/>
		</svg>
		<svg class="svg submit_application_section_svg_2" width="315" height="455" viewBox="0 0 315 455" fill="none"
			 xmlns="http://www.w3.org/2000/svg">
			<path opacity="0.4" d="M555.168 304.488L210.326 433.427L5.13412 451.853L381.762 3.80274L555.168 304.488Z"
				  stroke="#2A2F38" stroke-width="4"/>
		</svg>
		<svg class="svg submit_application_section_svg_3" width="289" height="258" viewBox="0 0 289 258" fill="none"
			 xmlns="http://www.w3.org/2000/svg">
			<path d="M61.1629 2.5485L254.899 266.834L285.806 422.333L-370.438 124.42L61.1629 2.5485Z" stroke="#F87B53"
				  stroke-width="4"/>
		</svg>


		<div class="container">
			<div class="text-center submit_application_section--header text-lg">
				<h1 class="h2 mb-2">
					Pay initial deposit
				</h1>
				<p>
					Please fill in the your information to continue
				</p>
			</div>
		</div>

		<div class="container">
			<?php
			echo do_shortcode( '[simpay id="19033"]' );
			?>
			<form style="display:none;">
				<input type="text" placeholder="First Name...">
				<div class="row">
					<div class="col-8">
						<input type="text" placeholder="Building Name...">
					</div>
					<div class="col-4">
						<input type="text" placeholder="Unit...">
					</div>
				</div>
				<input type="text" placeholder="Agent Name...">
				<input type="number" placeholder="How much would you like to pay?">
				<button>Send</button>
				<label class="acceptance">
					<input type="checkbox" name="acceptance-7" value="1" aria-invalid="false">
					<span>
						By digitally signing this agreement, you represent that you have read, understand, and agree to the terms outlined in this agreement.
					</span>
				</label>
				<p>
					The Initial deposit of $1,000 is the first step in taking the apartment off the market. The deposit is refundable until the owner approves the file. Each $20 application fee is non-refundable. There is a one-time legal fee of $250 for drawing up the lease, which you pay before signing. Once your file is approved and you sign the lease (congrats!), the remainder of your initial deposit is credited toward the security deposit.
				</p>
			</form>
		</div>
	</section>

<?php
get_footer();
