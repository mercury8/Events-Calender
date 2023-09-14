<?php
$date_now = $args['date_now'];
$date_end = $args['date_end'];
// $date_end = date_create( date("Y-m-d 23:59:59") )->format("Y-m-d H:i:s"); // For Live
// $date_end = date_create( '2021-09-11 23:59:59' )->format("Y-m-d H:i:s"); // For Dev
$postQuery = new WP_Query(array(
	'post_type' => 'stream', 'post_status' => 'publish', 'posts_per_page' => -1, 'fields' => 'ids',
	'meta_key'			=> 'agenda_date',
	'orderby'			=> 'meta_value',
	'order'				=> 'ASC',
	'meta_query' => array(
		array(
			'key'           => 'agenda_date',
			'compare'       => '<=',
			'value'         => $date_end,
			'type'          => 'DATETIME',
		),
		array(
			'key'           => 'agenda_date',
			'compare'       => '>=',
			'value'         => $date_now,
			'type'          => 'DATETIME',
		)
	),
));
$postList = $postQuery->posts;
$maxPages = $postQuery->max_num_pages;
// echo '<pre>'; print_r($postList); echo '</pre>';	

/*

	$startTime = date_create( $date_now )->format("Y-m-d 00:30:00");
	$timeArray = array( );
	$timeKey = date_create( $startTime )->format("H.i");
	
	 for ($mp0=1; $mp0 <= 24; $mp0++) {
		$startTime = date_create( $startTime )->modify("+1 hours")->format("Y-m-d H:i:s");
		$startTime2 = $startTime;
		$timeArray[$timeKey] = $startTime2;
		$timeKey = date_create( $startTime )->format("H.i");
	} 
	
	*/

$slot_minutes = 15;
$countMint = (1440 / $slot_minutes);
$startTime = date_create($date_now)->format("Y-m-d 00:00:00");
$timeArray = array();
$timeKey = date_create($startTime)->format("H.i");
for ($mp0 = 1; $mp0 <= $countMint; $mp0++) {
	$startTime = date_create($startTime)->modify("+{$slot_minutes} minutes")->format("Y-m-d H:i:s");
	$startTime2 = $startTime;
	$timeKey = date_create($startTime)->format("H.i");
	$timeArray[$timeKey] = $startTime2;
}

// echo '<pre>'; print_r( $timeArray ); echo '</pre>';

$event_time_id = array();
$post_id_added = array();
foreach ($postList as $key => $postId) {
	$startTime0 = date_create($date_now)->format("Y-m-d 00:00:00");
	// $startTime0 = '2021-09-11 00:00:00'; // For Dev
	$agenda_date = get_field('agenda_date', $postId);
	// $agenda_duration = get_field('agenda_duration_num', $postId) ? get_field('agenda_duration_num', $postId) : 0;
	// $agenda_date_duration = date_create($agenda_date)->modify("+{$agenda_duration} minutes")->format("Y-m-d H:i:s");

	foreach ($timeArray as $key => $time) {
		if (strtotime($agenda_date) >= strtotime($startTime0) &&  strtotime($agenda_date) <= strtotime($time) && !in_array($postId, $post_id_added)) { //(!in_array($postId, $post_id_added) || (strtotime($agenda_date_duration) < strtotime($time)))
			array_push($post_id_added, $postId);
			$event_time_id[$key][] = $postId;
		}
		$startTime0 = $time;
	}
}
//  echo '<pre>'; print_r( $event_time_id ); echo '</pre>';
if ((count($postList) > 0) && (count($event_time_id) > 0)) :
?>
	<?php foreach ($event_time_id as $time => $event_ids) { ?>
		<div class="conferences_events__eventRow">
			<div class="conferences_events__eventRow__time">
				<h4 class="time"><?php echo $time; ?></h4>
			</div>
			<div class="conferences_events__eventRow__eventboxs">
				<?php foreach ($event_ids as $key => $post_id) {
					$terms = wp_get_post_terms($post_id, 'stream_category', array('fields' => 'ids'));
					$color = get_field('color', 'term_' . $terms[0]);
					$title = get_the_title($post_id);
					
					/* $agenda_heading = get_field('agenda_heading', $post_id );
			if( ! $agenda_heading ){

			} */
					if ($show_short_description_on_grid_box == true) {
						$short_description = get_field('short_description', $post_id);
					} else {
						$short_description = '';
					}
					$duration = get_field('agenda_duration', $post_id);
				?>
					<div class="conferences_events__eventRow__box_outer" id='event_<?php echo $post_id; ?>'>
					<?php if (!empty($link)) { ?>
							<a href="<?php echo $link ?>" class="permalink"></a>
						<?php } ?>
						<div class="conferences_events__eventRow__box" style=" border-color: <?php echo $color; ?>; ">
							<div class="conferences_events__eventRow__box__inner" style=" background-color: <?php echo hex2rgba($color, 0.1); ?>; border-bottom-color: <?php echo $color; ?>; ">
								<?php /* <span class="top_color" style=" background-color: <?php echo $color; ?>; "></span> */ ?>
								<h6 class="title"><?php echo $title; ?></h6>
								<?php if ($short_description) : ?><div class="description"><?php echo $short_description; ?></div><?php endif; ?>
								<?php if ($duration) : ?><span class="duration"><?php echo $duration; ?></span><?php endif; ?>
								<?php if ($speakers) : ?>
									<div class="speakers_images">
										<?php foreach ($speakers as $key => $post_id) {
											$name = get_the_title($post_id);
											$link = get_post_permalink($post_id);
											$img_url = get_the_post_thumbnail_url($post_id, 'full');
											$position = get_field('position', $post_id);
											// $position = 'CEO at Pfizer';
										?>
											<div class="speakers__img" data-position="<?php echo $position; ?>" data-name="<?php echo $name; ?>"><img src="<?php echo $img_url; ?>" alt="<?php echo $name; ?>" />
												<div class="speakers_tooltip" style="display: none;">
													<a href="<?php echo $link; ?>" class="tooltip_img" style="background-image: url('<?php echo $img_url; ?>');"></a>
													<div class="tooltip_detail">
														<h5 class="name"><?php echo $name; ?></h5>
														<?php if ($position) : ?><span class="post"><?php echo $position; ?></span><?php endif; ?>
													</div>
												</div>
											</div>
										<?php } ?>
									</div>
									<div class="speakers_names">
										<?php foreach ($speakers as $key => $post_id) {
											$name = get_the_title($post_id);
										?>
											<div class="speakers__name"><?php echo $name; ?></div>
										<?php } ?>
									</div>
								<?php endif; ?>
							</div>

							<?php if ($sponsors) : ?>
								<div class="sponsors_images" style="border-top-color: <?php echo $color; ?>; ">
									<?php foreach ($sponsors as $key => $post_id) {
										$name = get_the_title($post_id); // 
										$img_url = get_the_post_thumbnail_url($post_id, 'full');
									?>
										<div class="sponsors__img"><img src="<?php echo $img_url; ?>" alt="<?php echo $name; ?>" /></div>
									<?php } ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
<?php else : ?>
	<div class="conferences_events__eventRow not_found">
		<p>Event Data Not found.</p>
	</div>
<?php endif; ?>