	<?php 

global $wp;

	$date_now = $args['date_now'];
	$ev_s = $args['ev_s'];
	$paged = $args['paged'];

	/* 
	$speakerList = get_posts( array(
		'post_type' => 'speaker', 'post_status' => 'publish', 'posts_per_page' => -1, 'fields' => 'ids',
		's' => $ev_s,
	) );

	echo '<pre>'; print_r($speakerList); echo '</pre>';
	 */

	$postQuery = new WP_Query(array(
		'post_type' => 'stream', 'post_status' => 'publish', 'posts_per_page' => 6, 'fields' => 'ids',
		'meta_key'			=> 'agenda_date',
		'orderby'			=> 'meta_value',
		'order'				=> 'ASC',
		'paged' => ($paged)?:1,
		'meta_query' => array(
			array(
				'key'           => 'agenda_date',
				'compare'       => '>=',
				'value'         => $date_now,
				'type'          => 'DATETIME',
			),
			/* array(
				'key' => 'speakers',
				// 'value' => $speakerList,
				// 'compare' => 'IN',
				'value' => '"'.$speakerList.'"',
  				'compare' => 'LIKE'
			) */
		),
		's' => $ev_s,
	));
	$postList = $postQuery->posts; 
	$maxPages = $postQuery->max_num_pages;
	$found_posts = $postQuery->found_posts;
	// echo '<pre>'; print_r($postQuery); echo '</pre>'; die;

	if( (count(  $postList ) > 0) ):
?>
		<div class="small-container">
		<div class="conferences_events__eventRow event_search_text">
			<a href="<?php echo esc_url( home_url( $wp->request ) ); ?>" class="back_btn"><svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="28" height="28" rx="14" fill="#E5E5E5" fill-opacity="0.5"/><path d="M22 13H9.83L15.42 7.41L14 6L6 14L14 22L15.41 20.59L9.83 15H22V13Z" fill="#14111B"/></svg> Back to Overview</a>
			<p class="search_text"><?php echo $found_posts; ?> results found for '<?php echo $ev_s; ?>'</p>
		</div>
		<div class="conferences_events__eventRow">
		<?php foreach ($postList as $key => $post_id) {
			$terms = wp_get_post_terms( $post_id, 'stream_category', array( 'fields' => 'ids' ) );                                
			$color = get_field('color', 'term_'. $terms[0] );
			$title = get_the_title( $post_id );
			
			$sponsors = get_field('sponsors', $post_id );
			$speakers = get_field('speakers', $post_id );			
			$short_description = get_field('short_description', $post_id );						
			$duration = get_field('agenda_duration', $post_id );                                
		?>
			<div class="conferences_events__eventRow__box_outer" id='event_<?php echo $post_id; ?>'>
			<div class="conferences_events__eventRow__box" style=" border-color: <?php echo $color; ?>; ">
				<div class="conferences_events__eventRow__box__inner" style=" background-color: <?php echo hex2rgba($color, 0.1); ?>; border-bottom-color: <?php echo $color; ?>; ">					
					<h6 class="title"><?php echo $title; ?></h6>
					<?php if( $short_description ): ?><div class="description"><?php echo $short_description; ?></div><?php endif; ?>
					<?php if( $duration ): ?><span class="duration"><?php echo $duration; ?></span><?php endif; ?>
					<?php if( $speakers ): ?>
					<div class="speakers_images">
						<?php foreach ($speakers as $key => $post_id) { 
							$name = get_the_title( $post_id ); // 
							$img_url = get_the_post_thumbnail_url( $post_id, 'full' );
							$position = get_field('position', $post_id );
							$position = 'CEO at Pfizer';
						?>
							<div class="speakers__img" data-position="<?php echo $position; ?>" data-name="<?php echo $name; ?>"><img src="<?php echo $img_url; ?>" alt="<?php echo $name; ?>"/></div>
						<?php } ?>                                            
					</div>
					<div class="speakers_names">
						<?php foreach ($speakers as $key => $post_id) { 
							$name = get_the_title( $post_id );
						?>
							<div class="speakers__name"><?php echo $name; ?></div>
						<?php } ?>
					</div>
					<?php endif; ?>
				</div>

				<?php if( $sponsors ): ?>
				<div class="sponsors_images" style="border-top-color: <?php echo $color; ?>; " >
					<?php foreach ($sponsors as $key => $post_id) { 
						$name = get_the_title( $post_id ); // 
						$img_url = get_the_post_thumbnail_url( $post_id, 'full' );                                            
					?>
						<div class="sponsors__img"><img src="<?php echo $img_url; ?>" alt="<?php echo $name; ?>"/></div>
					<?php } ?>                                            
				</div>   
				<?php endif; ?>                              
			</div>
			</div>
		<?php } ?>
		</div>
		</div>
		<div class="container">
		<div class="pagination_outer">
		<?php if( $maxPages > 1 ): ?>
			<ul class="pagination">
			<li class="<?php echo ( 1 == $paged )?'disable':''; ?>"><a class="prev pbtn" data-paged="<?php echo ($paged - 1); ?>" href="javascript:void(0);"><svg width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.66688 16L10.5469 14.12L4.44021 8L10.5469 1.88L8.66688 -1.64355e-07L0.666877 8L8.66688 16Z" fill="currentColor" fill-opacity="<?php echo ( 1 == $paged )?'0.1':'0.6'; ?>"/></svg></a></li>
			<li class="text"><span><?php echo $paged; ?></span> of <?php echo $maxPages; ?></li>
			<li class="<?php echo ( $maxPages == $paged )?'disable':''; ?>"><a class="next pbtn" data-paged="<?php echo ($paged + 1); ?>" href="javascript:void(0);"><svg width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.33312 0L0.453125 1.88L6.55979 8L0.453125 14.12L2.33312 16L10.3331 8L2.33312 0Z" fill="currentColor" fill-opacity="<?php echo ( $maxPages == $paged )?'0.1':'0.6'; ?>"/></svg></a></li>
			</ul>
		<?php endif; ?>
		</div>
		</div>
<?php else: ?>
	<div class="small-container">
		<div class="conferences_events__eventRow not_found">
			<p>Event Data Not found.</p>
		</div>
	</div>
<?php endif; ?>