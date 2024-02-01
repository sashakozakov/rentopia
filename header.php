<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _it_start
 */
$logo          = get_field( 'logo', 'option' );
$header_button = get_field( 'header_button', 'option' );
$has_hero      = false;
if ( have_rows( 'builder' ) ) {
	while ( have_rows( 'builder' ) ) {
		the_row();
		if ( get_row_layout() == 'hero' ) {
			$has_hero = true;
		}
	}
}
$extra_classes = $has_hero ? 'has-hero' : ''; // page with Hero requires extra header's styling
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class( $extra_classes ); ?> id="top">
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', '_it_start' ); ?></a>

<header class="header">
	<div class="container">
		<?php if ( $logo ) : ?>
			<a href="<?php echo home_url(); ?>" class="header__logo" rel="home">
				<?php echo wp_get_attachment_image( $logo, 'medium' ); ?>
			</a>
		<?php endif; ?>

		<nav class="main-nav">
			<?php
			wp_nav_menu( [
				'theme_location'  => 'main',
				'container_class' => 'main-menu__container',
				'menu_class'      => 'main-menu',
				'depth'           => 2,
				'walker'          => new Custom_Walker_Nav_Menu(),
				'fallback_cb'     => false
			] );
			?>

			<form class="header__search visible-lg-up" id="searchform" role="search"
				  action="<?php echo esc_url( home_url() ); ?>">
				<button class="header__search--submit" type="submit">
					<svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_1_3485)">
							<path
								d="M10.8333 18.4167C15.0215 18.4167 18.4167 15.0215 18.4167 10.8333C18.4167 6.64517 15.0215 3.25 10.8333 3.25C6.64517 3.25 3.25 6.64517 3.25 10.8333C3.25 15.0215 6.64517 18.4167 10.8333 18.4167Z"
								stroke="#2A2F38" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M22.75 22.75L16.25 16.25" stroke="#2A2F38" stroke-width="1.5"
								  stroke-linecap="round" stroke-linejoin="round"/>
						</g>
						<defs>
							<clipPath id="clip0_1_3485">
								<rect width="26" height="26" fill="white"/>
							</clipPath>
						</defs>
					</svg>
				</button>
				<input type="hidden" name="post_type" value="post"/>
				<input class="header__search--input" id="s" name="s" type="text" placeholder="" required/>
			</form>

			<?php if ( is_user_logged_in() ) : ?>
				<a href="<?php echo esc_url( wp_logout_url() ) ?>"
				   class="btn btn-outline mt-auto ml-1"><?php _e( 'Log Out', '_it_start' ); ?></a>
			<?php else: ?>
				<a href="<?php echo esc_url( wp_login_url() ) ?>"
				   class="btn btn-outline mt-auto mr-3"><?php _e( 'Log In', '_it_start' ); ?></a>
			<?php endif; ?>

			<?php if ( $header_button ) : ?>
				<a href="<?php echo esc_url( $header_button['url'] ); ?>" class="btn"
				   target="<?php echo esc_attr( $header_button['target'] ); ?>"><?php echo esc_html( $header_button['title'] ); ?></a>
			<?php endif; ?>

		</nav>
		<span class="icon-burger hidden-lg-up"
			  aria-label="<?php esc_html_e( 'Toggle navigation', '_it_start' ); ?>"><i></i></span>
	</div>
</header>


<?php get_template_part( 'template-parts/builder/components/mobile_search_form', null, [ 'mobile' => true ] ); ?>

<main class="site-content" id="content">
