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
		<svg class="svg submit_application_section_svg_1" width="437" height="387" viewBox="0 0 437 387" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path opacity="0.4" d="M-95.6142 84.6635L238.613 2.36512L431.16 7.53031L32.7719 382.713L-95.6142 84.6635Z" stroke="#b8c83f" stroke-width="4"/>
		</svg>
		<svg class="svg submit_application_section_svg_2" width="315" height="455" viewBox="0 0 315 455" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path opacity="0.4" d="M555.168 304.488L210.326 433.427L5.13412 451.853L381.762 3.80274L555.168 304.488Z" stroke="#2A2F38" stroke-width="4"/>
		</svg>
		<svg class="svg submit_application_section_svg_3" width="289" height="258" viewBox="0 0 289 258" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M61.1629 2.5485L254.899 266.834L285.806 422.333L-370.438 124.42L61.1629 2.5485Z" stroke="#F87B53" stroke-width="4"/>
		</svg>


		<div class="container">
			<div class="text-center submit_application_section--header text-lg">
				<h1 class="h2 mb-2">
					Submit An Application
				</h1>
				<p>
					Choose the most relevant option for you
				</p>
			</div>
		</div>

		<div class="container applications_blocks">
			<div class="row">
				<div class="col-md-6">
					<a href="/initial-deposit" class="application_block">
						<div class="application_block--inner">
							<div class="application_block--img">
								<img src="https://rentopiagroup.com/wp-content/uploads/2023/08/application1.svg" alt="">
							</div>
							<h2 class="application_block--title h4">
								Pay Initial Deposit
							</h2>
							<!-- p>
								Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
								incididunt ut
								labore et dolore magna aliqua.
							</p-->
						</div>
					</a>
				</div>
				<div class="col-md-6">
					<a href="/move-in-cost" class="application_block">
						<div class="application_block--inner">
							<div class="application_block--img">
								<img src="https://rentopiagroup.com/wp-content/uploads/2023/08/application2.svg" alt="">
							</div>
							<h2 class="application_block--title h4">
								Pay Move-In Cost
							</h2>
							<!-- p>
								Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
								incididunt ut labore et dolore magna aliqua.
							</p-->
						</div>
					</a>
				</div>
			</div>
		</div>
	</section>

<?php
get_footer('nofooter');
