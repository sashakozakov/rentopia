<?php
/**
 * Template Name: Custom RSS Template - Feedname
 */

$get_amenities = $_GET['amenities']; 

global $wpdb;
header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';

?>

<rss version="2.0"
        xmlns:content="http://purl.org/rss/1.0/modules/content/"
        xmlns:wfw="http://wellformedweb.org/CommentAPI/"
        xmlns:dc="http://purl.org/dc/elements/1.1/"
        xmlns:atom="http://www.w3.org/2005/Atom"
        xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
        xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
        <?php do_action('rss2_ns'); ?>>
<channel>
        <title><?php bloginfo_rss('name'); ?> - Feed</title>
        <atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
        <link><?php bloginfo_rss('url') ?> </link>
        <description><?php bloginfo_rss('description') ?></description>
        <lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
        <language><?php echo get_option('rss_language'); ?></language>
        <sy:updatePeriod><?php echo apply_filters( 'rss_update_period', 'hourly' ); ?></sy:updatePeriod>
        <sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', '1' ); ?></sy:updateFrequency>

		<?php do_action('rss2_head'); ?>
	
        <?php
	$postCount = 100; // The number of posts to show in the feed

	$argss = array(
					'post_type'=> 'apartment' , 
					'posts_per_page' => $postCount , 
					'orderby' => 'date' ,
					'order' => 'DESC' 
				);

//$posts = query_posts('post_type=apartment , showposts=' . $postCount);

$list_counter = 0;	
$posts = query_posts($argss);
	
	while(have_posts()) : the_post(); ?>
	
	<?php
	
	/* $capartment_id = get_the_id();
	 $connected_building = get_field( 'connected_building',$capartment_id); ?>
<?php if ( $connected_building ) : ?>
<?php  get_permalink( $connected_building); ?>
	<?php  get_the_title( $connected_building,$capartment_id); ?>
<?php endif; */ ?>
	

					<?php 
	
	$term_list = get_the_terms($post->ID, 'apartment_amenities');
$types =' ';
foreach($term_list as $term_single) {
	$name_t = $term_single->name; 
	$anm_name_start = $name_t;
	$anm_name_startt = str_replace(" ","_", $name_t);
	$anm_name_starttt =  str_replace('/','',$anm_name_startt);
	$anm_name_starttt_with_arrow =  '<'.$anm_name_starttt.'>';
	$anm_name_endddd_with_arrow =  '</'.$anm_name_starttt.'>';
	
    $types = ucfirst($term_single->slug);

	
	//$anm_name_endd = str_replace(' ','_', $name_t);
	//$anm_name_enddd =  '</'.str_replace('/',' ',$anm_name_endd).'>';
	
	
	$anm_full_name .=  $anm_name_starttt_with_arrow.$name_t.$anm_name_endddd_with_arrow;
	
}
$typesz = rtrim($types, ' , ');
	
	
	$user_agent = get_field('user_agent');
	$author_obj = get_user_by('id', $user_agent);
	
	$agrent_usernamee = $author_obj->display_name;
	$agent_email = $author_obj->user_email;
	

	$phoner = esc_attr(get_the_author_meta('phone', $user_agent));
	
if(empty($get_amenities)){	?>

<item>		

	<Premium>1</Premium>
	<CompanyID><?php echo $user_agent; ?></CompanyID>
	<CompanyName><?php echo $agrent_usernamee; ?></CompanyName>		
	<CompanyEmail><?php echo $agent_email; ?></CompanyEmail>
	<CompanyPhone><?php echo $phoner; ?></CompanyPhone>
	<ListingID><?php echo get_the_id(); ?></ListingID>
	<title><?php the_title(); ?></title>
	<url><?php get_permalink(); ?></url>
	<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
	<dc:creator><?php the_author(); ?></dc:creator>
	<description><![CDATA[<?php the_excerpt() ?>]]></description>
	<content:encoded><![CDATA[<?php the_content() ?>]]></content:encoded>
	<url><?php echo get_permalink( $connected_building); ?></url>
	<buidings><?php echo get_the_title( $connected_building); ?></buidings>
	<location><?php echo the_field( 'buildings_subtitle' ); ?></location>
		<?php echo $anm_full_name; ?>
					<Amenities>	
					<?php echo $typesz; ?></Amenities>
					<studio>
					<?php if ( get_field( 'studio' ) == 1 ) : ?>
	<?php  echo 'true'; ?>
<?php else : ?>
	<?php  echo 'false'; ?>
<?php endif; ?>		</studio>
					<bedroom><?php the_field( 'bedrooms' ); ?></bedroom>
					<bathroom><?php the_field( 'bathrooms' ); ?></bathroom>
					<squarefeet><?php $squares_ft = get_field( 'squares_ft' ); if(!empty($squares_ft)){ echo $squares_ft; } ?></squarefeet>
					<price><?php the_field( 'price' ); ?></price>
					<move_in><?php the_field( 'move_in' ); ?></move_in>
					<first_month_free><?php if ( get_field( 'first_month_free' ) == 1 ) : ?><?php  echo 'true'; ?><?php else : ?><?php  echo 'false'; ?><?php endif; ?></first_month_free>
					<near_to_market><?php if ( get_field( 'new_to_market' ) == 1 ) : ?><?php echo 'true'; ?><?php else : ?><?php echo 'false'; ?><?php endif; ?></near_to_market>
					<overview_content><?php //the_field( 'overview_content' ); ?></overview_content>
					<gallery><?php $gallery_ids = get_field( 'gallery' ); ?>
<?php $size = 'full'; ?>
<?php $image_counter = 0; if ( $gallery_ids ) :  ?>
	<?php foreach ( $gallery_ids as $gallery_id ): ?>
						
		<File Active="true">
<Src><?php echo wp_get_attachment_image_url( $gallery_id, $size ); ?></Src>
<Rank><?php echo $image_counter = $image_counter + 1; ?></Rank>
</File>
						
	<?php endforeach; ?>
<?php endif; ?></gallery>
					<contact_agent>
					<?php $user_agent = get_field( 'user_agent' ); ?>
<?php if ( $user_agent ) : ?>
	<?php $user_data = get_userdata( $user_agent ); ?>
	<?php if ( $user_data ) : ?>
		<a href="<?php echo get_author_posts_url( $user_agent ); ?>"><?php echo esc_html( $user_data->display_name ); ?></a>
	<?php endif; ?>
<?php endif; ?>
					</contact_agent>
					<neigbhourhood>
					<?php if ( have_rows( 'neighborhood' ) ) : ?>
	<?php while ( have_rows( 'neighborhood' ) ) : the_row(); ?>
		<?php the_sub_field( 'title' ); ?>
		<?php the_sub_field( 'subtitle' ); ?>
		<?php the_sub_field( 'content' ); ?>
		<?php $image = get_sub_field( 'image' ); ?>
		<?php $size = 'full'; ?>
		<?php if ( $image ) : ?>
			<?php echo wp_get_attachment_image( $image, $size ); ?>
		<?php endif; ?>
	<?php endwhile; ?>
<?php endif; ?>

					</neigbhourhood>
					<subway>
					<?php if ( have_rows( 'subway_lines' ) ) : ?>
	<?php while ( have_rows( 'subway_lines' ) ) : the_row(); ?>
		<?php the_sub_field( 'type' ); ?>
		<?php the_sub_field( 'title' ); ?>
		<?php the_sub_field( 'value' ); ?>
	<?php endwhile; ?>
<?php else : ?>
	<?php echo "Nothing"; ?>
<?php endif; ?>
					</subway>
					<nearby>
					
						<?php if ( have_rows( 'nearby_group' ) ) : ?>
	<?php while ( have_rows( 'nearby_group' ) ) : the_row(); ?>
		<?php if ( have_rows( 'supermarket' ) ) : ?>
			<?php while ( have_rows( 'supermarket' ) ) : the_row(); ?>
				<?php the_sub_field( 'title' ); ?>
				<?php the_sub_field( 'value' ); ?>
			<?php endwhile; ?>
		<?php else : ?>
			<?php // No rows found ?>
		<?php endif; ?>
		<?php if ( have_rows( 'restaurants_&_bars' ) ) : ?>
			<?php while ( have_rows( 'restaurants_&_bars' ) ) : the_row(); ?>
				<?php the_sub_field( 'title' ); ?>
				<?php the_sub_field( 'value' ); ?>
			<?php endwhile; ?>
		<?php else : ?>
			<?php // No rows found ?>
		<?php endif; ?>
	<?php endwhile; ?>
<?php endif; ?>

						
					</nearby>
                        <?php rss_enclosure(); ?>
                        <?php do_action('rss2_item'); ?>
                </item>
	
	<?php
}
	
?>
	
<?php 	if (str_contains($typesz, $get_amenities)) {	?>
	
                <item>
                        <title><?php the_title(); ?></title>
                        <url><?php get_permalink(); ?></url>
                        <pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
                        <dc:creator><?php the_author(); ?></dc:creator>
                        <description><![CDATA[<?php the_excerpt() ?>]]></description>
                        <content:encoded><![CDATA[<?php the_excerpt() ?>]]></content:encoded>
					<url><?php echo get_permalink( $connected_building); ?></url>
					<buidings><?php echo get_the_title( $connected_building); ?></buidings>
					<location><?php echo the_field( 'buildings_subtitle' ); ?></location>
					<Amenities>	
					<?php echo $typesz; ?></Amenities>
					<studio>
					<?php if ( get_field( 'studio' ) == 1 ) : ?>
	<?php  echo 'true'; ?>
<?php else : ?>
	<?php  echo 'false'; ?>
<?php endif; ?>		</studio>
					<bedroom><?php the_field( 'bedrooms' ); ?></bedroom>
					<bathroom><?php the_field( 'bathrooms' ); ?></bathroom>
					<squarefeet><?php $squares_ft = get_field( 'squares_ft' ); if(!empty($squares_ft)){ echo $squares_ft; } ?></squarefeet>
					<price><?php the_field( 'price' ); ?></price>
					<move_in><?php the_field( 'move_in' ); ?></move_in>
					<first_month_free><?php if ( get_field( 'first_month_free' ) == 1 ) : ?><?php  echo 'true'; ?><?php else : ?><?php  echo 'false'; ?><?php endif; ?></first_month_free>
					<near_to_market><?php if ( get_field( 'new_to_market' ) == 1 ) : ?><?php echo 'true'; ?><?php else : ?><?php echo 'false'; ?><?php endif; ?></near_to_market>
					<overview_content><?php //the_field( 'overview_content' ); ?></overview_content>
					<gallery><?php $gallery_ids = get_field( 'gallery' ); ?>
<?php $size = 'full'; ?>
<?php if ( $gallery_ids ) :  ?>
	<?php foreach ( $gallery_ids as $gallery_id ): ?>
						
		<?php echo wp_get_attachment_image_url( $gallery_id, $size ); ?>
	<?php endforeach; ?>
<?php endif; ?></gallery>
					<contact_agent>
					<?php $user_agent = get_field( 'user_agent' ); ?>
<?php if ( $user_agent ) : ?>
	<?php $user_data = get_userdata( $user_agent ); ?>
	<?php if ( $user_data ) : ?>
		<a href="<?php echo get_author_posts_url( $user_agent ); ?>"><?php echo esc_html( $user_data->display_name ); ?></a>
	<?php endif; ?>
<?php endif; ?>
					</contact_agent>
					<neigbhourhood>
					<?php if ( have_rows( 'neighborhood' ) ) : ?>
	<?php while ( have_rows( 'neighborhood' ) ) : the_row(); ?>
		<?php the_sub_field( 'title' ); ?>
		<?php the_sub_field( 'subtitle' ); ?>
		<?php the_sub_field( 'content' ); ?>
		<?php $image = get_sub_field( 'image' ); ?>
		<?php $size = 'full'; ?>
		<?php if ( $image ) : ?>
			<?php echo wp_get_attachment_image( $image, $size ); ?>
		<?php endif; ?>
	<?php endwhile; ?>
<?php endif; ?>

					</neigbhourhood>
					<subway>
					<?php if ( have_rows( 'subway_lines' ) ) : ?>
	<?php while ( have_rows( 'subway_lines' ) ) : the_row(); ?>
		<?php the_sub_field( 'type' ); ?>
		<?php the_sub_field( 'title' ); ?>
		<?php the_sub_field( 'value' ); ?>
	<?php endwhile; ?>
<?php else : ?>
	<?php echo "Nothing"; ?>
<?php endif; ?>
					</subway>
					<nearby>
					
						<?php if ( have_rows( 'nearby_group' ) ) : ?>
	<?php while ( have_rows( 'nearby_group' ) ) : the_row(); ?>
		<?php if ( have_rows( 'supermarket' ) ) : ?>
			<?php while ( have_rows( 'supermarket' ) ) : the_row(); ?>
				<?php the_sub_field( 'title' ); ?>
				<?php the_sub_field( 'value' ); ?>
			<?php endwhile; ?>
		<?php else : ?>
			<?php // No rows found ?>
		<?php endif; ?>
		<?php if ( have_rows( 'restaurants_&_bars' ) ) : ?>
			<?php while ( have_rows( 'restaurants_&_bars' ) ) : the_row(); ?>
				<?php the_sub_field( 'title' ); ?>
				<?php the_sub_field( 'value' ); ?>
			<?php endwhile; ?>
		<?php else : ?>
			<?php // No rows found ?>
		<?php endif; ?>
	<?php endwhile; ?>
<?php endif; ?>

						
					</nearby>
                        <?php rss_enclosure(); ?>
                        <?php do_action('rss2_item'); ?>
                </item>
<?php }  ?>
        <?php endwhile; ?>
</channel>
</rss>