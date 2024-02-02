<?php
/**
 * Template Name: Custom RSS Template - Feedname
 */

$get_amenities = $_GET['amenities']; 

global $wpdb;
header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';

?>
<PhysicalProperty>
<?php
	$postCount = 50; // The number of posts to show in the feed
	$argss = array(
					'post_type'=> 'apartment' , 
					'posts_per_page' => $postCount , 
					'orderby' => 'date' ,
					'order' => 'DESC' 
				);

//$posts = query_posts('post_type=apartment , showposts=' . $postCount);

$list_counter = 0;	
$posts = query_posts($argss);
while(have_posts()) : the_post(); 
	
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
	
	$anm_full_name .= 
    $anm_name_starttt_with_arrow."1".$anm_name_endddd_with_arrow;
    //$anm_name_starttt_with_arrow.$name_t.$anm_name_endddd_with_arrow;
	
}
$typesz = rtrim($types, ' , ');
	
	$user_agent = get_field('user_agent');
	$author_obj = get_user_by('id', $user_agent);
	
	$agrent_usernamee = $author_obj->display_name;
	$agent_email = $author_obj->user_email;
	$phoner = esc_attr(get_the_author_meta('phone', $user_agent));
	
	$iddd = get_the_id();
	
	$propertytypee = get_field('propertytype',$post->ID);
	$cityy = get_field('city',$post->ID);
	$statee = get_field('state',$post->ID);
	$zipp = get_field('zip',$post->ID);
	
	$logoo = get_field('logo','option');
	$logoo_src =  wp_get_attachment_image_src( $logoo, 'full' );
	if ( $logoo_src ){
		$logoo_srcc = $logoo_src[0];	
	}
	
	$pricee = get_field('price',$post->ID);
	
	$moveinn_date = get_field('move_in',$post->ID);
	//$moveinn_date1 = date("F j, Y", strtotime($moveinn_date)); 
    $moveinn_date1 = date("m-d-Y", strtotime($moveinn_date));
    
	$apartment_number = get_field('apartment_number',$post->ID);
	
	 $overview_content = strip_tags(get_field('overview_content',$post->ID));
	//$overview_content = html_entity_decode(get_field('overview_content',$post->ID));
	//echo "<br/>";
	 $overview_content1 = str_replace('</p>', ' ', $overview_content);
	 $overview_content2 = str_replace('<p>', ' ', $overview_content1);
	$overview_content3 = str_replace('&', 'and', $overview_content2);
	//echo "<br/>";
	 $overview_contentt = preg_replace("/^(.*)<br.*\/?>/m", '<p>$1</p>', $overview_content3);
	
	//$string=str_replace('<p>','',$overview_contentt,$temp=1);
  //  $string=str_replace('<\p>','',$overview_contentt,$temp=1);
	
	
if(empty($get_amenities)){	?>

<Property>
<ActiveListing>1</ActiveListing>
<Premium>1</Premium>
<AgentID><?php echo $user_agent;  echo " "; ?></AgentID>
<AgentName><?php echo $agrent_usernamee;  echo " "; ?></AgentName>	
<AgentEmail><?php echo $agent_email;  echo " "; ?></AgentEmail>
<AgentPhone><?php echo $phoner;  echo " "; ?></AgentPhone>
<CompanyName>RentopiaGroup</CompanyName>	
<CompanyWebsite>https://rentopiagroup.com</CompanyWebsite>
<ListingID><?php echo get_the_id();  echo " "; ?></ListingID>
<ListingURL><?php echo get_permalink();  echo " "; ?></ListingURL>
<Headline>Private <?php the_field( 'bedrooms',$post->ID); ?> Bed/<?php the_field( 'bathrooms',$post->ID); ?> Bath Condo</Headline>
<Specials><?php  echo " "; ?></Specials>
<Description><?php echo $overview_content;  echo " "; ?></Description>
<PropertyType><?php echo $propertytypee." "; ?></PropertyType>
<AddressLine1><?php echo get_the_title( $connected_building);  echo " "; ?></AddressLine1>
<UnitNbr><?php echo $apartment_number." "; ?></UnitNbr>
<City><?php echo $cityy." "; ?></City>
<StateCode><?php echo $statee." "; ?></StateCode>
<ZipCode><?php echo $zipp." "; ?></ZipCode>
<Latitude><?php echo " "; ?></Latitude>
<Longitude><?php echo " "; ?></Longitude>
<AvailableOnDate><?php echo $moveinn_date1; ?></AvailableOnDate>
<CompanyLogo><?php echo $logoo_srcc." "; ?></CompanyLogo>
<Bathrooms><?php the_field( 'bedrooms',$post->ID); ?></Bathrooms>
<Bedrooms><?php the_field( 'bathrooms',$post->ID); ?></Bedrooms>
<SqFeet><?php $squares_ft = get_field( 'squares_ft',$iddd); if(!empty($squares_ft)){ echo $squares_ft; }  echo " "; ?></SqFeet>
<Rent><?php echo $pricee." "; ?></Rent>
<VirtualTourURL><?php echo " "; ?></VirtualTourURL>
	
		<?php echo $anm_full_name; ?>
					<Amenities>	
					<?php echo $typesz; ?></Amenities>
					<studio>
					<?php if ( get_field( 'studio' ) == 1 ) : ?>
	<?php  echo 'true'; ?>
<?php else : ?>
	<?php  echo 'false'; ?>
<?php endif; ?>		</studio>
					<bedroom><?php the_field( 'bedrooms',$post->ID); ?></bedroom>
					<bathroom><?php the_field( 'bathrooms',$post->ID); ?></bathroom>
					
					<price><?php the_field( 'price',$post->ID); ?></price>
					<move_in><?php echo $moveinn_date1; ?></move_in>
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
<?php rss_enclosure(); ?>
<?php do_action('rss2_item'); ?>
</Property>
<?php	}	?>
<?php endwhile; ?>
</PhysicalProperty>