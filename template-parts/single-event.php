<?php
$post_id = $args['post_id'];
$heading = get_the_title($post_id);
$agenda_date = get_field('agenda_date', $post_id);
$location = get_field('location', $post_id);
$sponsors = get_field('sponsors', $post_id);
$sponsor_title  = get_field('sponsor_title', $post_id);
$description = get_field('description', $post_id);
$iframe_code_box = get_field('iframe_code_box', $post_id);
$speakers = get_field('speakers', $post_id);
$roomname = get_field('room_namenumber_field', $post_id);
$iframe_header = get_field('iframe_header', $post_id);
$carousel_code_box = get_field('carousel_code_box', $post_id);
$carousel_code_box_header = get_field('carousel_code_box_header', $post_id);

?>
<div class="sessions_details__detail">
    <div class="bannerWrapper">
        <?php if( get_field('banner_image') ): ?>
        <img src="<?= the_field('banner_image', $post_id);?>">
        <?php endif; ?>
    </div>
    
    <h3 class="heading"><?php echo $heading; ?></h3>
    <div class="date_location">
        <?php
        if ($agenda_date) :
            $date = date_create($agenda_date)->format("d M Y");
            $time = date_create($agenda_date)->format("H:i");
        ?>
            <div class="date"><span class="icon"><svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 2H17V0H15V2H5V0H3V2H2C0.9 2 0 2.9 0 4V20C0 21.1 0.9 22 2 22H18C19.1 22 20 21.1 20 20V4C20 2.9 19.1 2 18 2ZM18 20H2V9H18V20ZM18 7H2V4H18V7Z" fill="#FF8A65" />
                    </svg></span><?php echo $date; ?></div>
            <div class="time"><span class="icon"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.99 0C4.47 0 0 4.48 0 10C0 15.52 4.47 20 9.99 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 9.99 0ZM10 18C5.58 18 2 14.42 2 10C2 5.58 5.58 2 10 2C14.42 2 18 5.58 18 10C18 14.42 14.42 18 10 18Z" fill="#FF8A65" />
                        <path d="M10.5 5H9V11L14.25 14.15L15 12.92L10.5 10.25V5Z" fill="#FF8A65" />
                    </svg></span><?php echo $time; ?></div>
        <?php endif; ?>
        <?php if ($roomname) : ?>
        <div class="roomname">
            <span class="icon">
                <svg style="enable-background:new 0 0 24 24;" version="1.1" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><style type="text/css">
	.st0{opacity:0.2;fill:none;stroke:#000000;stroke-width:5.000000e-02;stroke-miterlimit:10;}
</style><g id="Layer_1"/><g id="Layer_2"><g><path d="M15,2H6c0,0,0,0,0,0C5.9,2,5.8,2,5.7,2.1c0,0,0,0,0,0c-0.1,0-0.1,0.1-0.2,0.1c0,0,0,0,0,0c0,0,0,0-0.1,0.1    C5.3,2.3,5.2,2.4,5.2,2.4c0,0,0,0,0,0.1C5.1,2.6,5,2.7,5,2.8c0,0,0,0,0,0c0,0,0,0,0,0C5,2.9,5,3,5,3v14.8c0,0.4,0.2,0.8,0.6,0.9    l6.6,2.7c0.2,0.1,0.5,0.1,0.8,0.1c0.4,0,0.8-0.1,1.1-0.3c0.6-0.4,0.9-1,0.9-1.7V19c1.7,0,3-1.3,3-3V5C18,3.3,16.7,2,15,2z M13,18    v1.6l-6-2.4V4.5l4.8,1.9c0.8,0.3,1.2,1,1.2,1.9V18z M16,16c0,0.6-0.4,1-1,1V8.3c0-1.6-1-3.1-2.5-3.7L11.1,4H15c0.6,0,1,0.4,1,1V16    z"/><circle cx="11" cy="13" r="1"/></g></g></svg>
            </span><?php  echo $roomname; ?>
        </div>
        <?php endif; ?>
        <?php if ($location) : ?>
        <div class="location"><span class="icon"><svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M8 10C6.9 10 6 9.1 6 8C6 6.9 6.9 6 8 6C9.1 6 10 6.9 10 8C10 9.1 9.1 10 8 10ZM14 8.2C14 4.57 11.35 2 8 2C4.65 2 2 4.57 2 8.2C2 10.54 3.95 13.64 8 17.34C12.05 13.64 14 10.54 14 8.2ZM8 0C12.2 0 16 3.22 16 8.2C16 11.52 13.33 15.45 8 20C2.67 15.45 0 11.52 0 8.2C0 3.22 3.8 0 8 0Z" fill="#FF8A65" />
        </svg></span><?php  echo $location; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php if ($sponsors) : ?>
        <div class="sponsors">
            <?php if ($sponsor_title) : ?>
                <h6 class="title"><?php echo $sponsor_title ?></h6>
            <?php else : ?>
                <h6 class="title">SPONSORED BY</h6>
            <?php endif; ?>
            <div class="sponsors_images ">
                <?php foreach ($sponsors as $key => $post_id) {
                    $name = get_the_title($post_id);
                    $img_url = get_the_post_thumbnail_url($post_id, 'full');
                    $permalink = get_the_permalink($post_id);
                ?>
                    <div class="sponsors__img"><a href="<?php echo $permalink; ?>"><img src="<?php echo $img_url; ?>" alt="<?php echo $name; ?>" /></a></div>
                <?php } ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($description) : ?><div class="description"> <?php echo $description; ?> </div> <?php endif; ?>
        <!-- carousel -->
        <?php if ($carousel_code_box_header) : ?><p class="meet-the-team"><?php echo $carousel_code_box_header; ?></p><?php endif; ?>
        <?php if ($carousel_code_box) : ?>
            <div class="carousel"> 
                    <?php if ( get_field('carousel_code_box') ) {
			            echo do_shortcode( get_field('carousel_code_box') );
		            }?>
            </div> 
        <?php endif; ?> 
        <!-- form -->
    <h3 class="heading_form"><?php echo $iframe_header; ?></h3>
    <?php if ($iframe_code_box) : ?><div class="iframe"> <?php echo $iframe_code_box; ?> </div> <?php endif; ?>
        

    <?php if ($speakers) : ?>
        <div class="speakers">
            <h3 class="heading">Speakers</h3>
            <div  id="speakerscara" class="speakers_images">
                <?php foreach ($speakers as $key => $post_id) {
                    $name = get_the_title($post_id);
                    $img_url = get_the_post_thumbnail_url($post_id, 'full');
                    $position = get_field('position', $post_id);
                    // $position = 'CEO at Pfizer';
                    $select_sponser = get_field('select_sponser', $post_id);
                    $permalink = get_the_permalink($post_id);
                ?>
                    <div class="speakers__list">
                        <div class="speakers__img" style=" background-image: url('<?php // echo $img_url; ?>'); ">
                            <a href="<?php echo $permalink; ?>"><img src="<?php echo $img_url; ?>" alt="<?php echo $name; ?>" />
                            </a>
                        </div>
                        <div class="speakers__detail">
                            <h5 class="name"><a href="<?php echo $permalink; ?>"><?php echo $name; ?></a></h5>
                            <?php if ($speakers) : ?><span class="position"><?php echo $position; ?></span><?php endif; ?>
                            <?php if ($select_sponser) : ?><div class="sponser">
                                    <?php foreach ($select_sponser as $key => $post) {
                                        $name = get_the_title($post);
                                        $img_url = get_the_post_thumbnail_url($post, 'full');
                                    ?>
                                        <div class="img"><img src="<?php echo $img_url; ?>" alt="<?php echo $name; ?>" /></div>
                                    <?php } ?>
                                </div><?php endif; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php endif; ?>
</div>