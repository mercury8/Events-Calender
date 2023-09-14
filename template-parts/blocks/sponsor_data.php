<?php

/**
 * Speakers Data Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'sponsors_data-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'sponsors_data';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

global $post;
$show_data = get_field('show_data');
$url_facebook = get_field('url_facebook');
$url_twitter = get_field('url_twitter');
$url_instagram = get_field('url_instagram');
$url_linkedin = get_field('url_linkedin');
$enable_manual_speaker_selection = get_field('enable_manual_speaker_selection');
$show_speakers_list = get_field('show_speakers_list');
$speaker_selection = get_field('speaker_selection');
$current_post = $post->ID;
$title = get_the_title($current_post);
//$ceo = get_field('ceo',$current_post);
//$logo = get_field('logo',$current_post);
$image = get_the_post_thumbnail_url($current_post, 'full');
$sponsor_image = get_field('sponsor_image', $current_post);
$description = get_field('description', $current_post);
$link = get_field('sponsor_link', $current_post);
$single_page_sub_heading = get_field('single_page_sub_heading', $current_post);
$sponser_posts  = get_field('select_sponser', $current_post);

$site_theme = get_field("site_theme", "option");
$site_theme = $site_theme ? $site_theme : "";
$desktop_pattern_image = get_template_directory_uri() . "/assets/images/new_bg.png";
$desktop_pattern_image_field = get_field('shape_6_desktop_' . $site_theme, "option");

if (!empty($desktop_pattern_image_field)) {
    $desktop_pattern_image = $desktop_pattern_image_field;
}
?>
<?php if ($show_data == 1) : ?>
    <div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
        <div class="sponsors_data_inner" <?php if ($desktop_pattern_image) { ?> style="background-image: url(<?php echo $desktop_pattern_image; ?>);" <?php } ?>>
            <div class="small-container">
                <div class="sponsors_data_wrapper">
                    <div class="image-main">
                        <div class="image">
                            <div class="bg_image" style="background-image: url(<?php echo $sponsor_image; ?>);">
                                <img src="<?php echo get_template_directory_uri(); ?>/dist/images/110-110.png" alt="Speakers" />
                            </div>
                        </div>
                    </div>
                    <div class="details">
                        <h1 class="heading h2"><?php echo $title; ?></h1>
                        <?php if ($single_page_sub_heading) : ?>
                            <div class="ceo"><?php echo $single_page_sub_heading; ?></div>
                        <?php endif; ?>

                    </div>
                </div>
                <?php if ($description) : ?><div class="content"><?php echo $description; ?></div><?php endif; ?>

                <div class="share_section">
                    <?php // get_template_part('template-parts/content', 'sharepost'); 
                    ?>
                    <?php if ($url_twitter) : ?>
                        <div class="st-custom-button">
                            <a href="<?php echo $url_twitter; ?>" target="_blank">
                                <svg width="24" height="20" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21.533 5.11203C21.548 5.32484 21.548 5.53859 21.548 5.75141C21.548 12.2539 16.5989 19.7464 7.55344 19.7464C4.76672 19.7464 2.17781 18.9392 0 17.5386C0.396094 17.5841 0.776719 17.5995 1.18781 17.5995C3.48703 17.5995 5.60391 16.8223 7.29422 15.4977C6.26788 15.4788 5.27304 15.1399 4.44863 14.5283C3.62422 13.9167 3.01141 13.0629 2.69578 12.0861C3.00298 12.1346 3.31338 12.16 3.62437 12.162C4.06594 12.162 4.5075 12.1011 4.91859 11.9947C3.80492 11.7693 2.80361 11.1653 2.08473 10.2854C1.36586 9.40542 0.973746 8.30376 0.975 7.1675V7.10656C1.65656 7.48693 2.41835 7.70087 3.19828 7.73094C2.52322 7.28197 1.9697 6.673 1.58702 5.95827C1.20435 5.24354 1.0044 4.44526 1.005 3.63453C1.005 2.72094 1.24875 1.88328 1.67531 1.1525C2.91081 2.67312 4.45211 3.9171 6.19927 4.80376C7.94643 5.69042 9.86044 6.19997 11.8172 6.29937C11.7413 5.93375 11.6953 5.55359 11.6953 5.17297C11.6953 2.46219 13.8881 0.253906 16.6144 0.253906C18.03 0.253906 19.3097 0.847812 20.2083 1.80734C21.3098 1.59521 22.3662 1.19329 23.3302 0.619531C22.9633 1.75632 22.1943 2.72019 21.1673 3.33031C22.1573 3.22344 23.1169 2.94922 24 2.56859C23.3266 3.54914 22.4925 4.40902 21.533 5.11203Z" fill="#FF8A65" />
                                </svg>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if ($url_facebook) : ?>
                        <div class="st-custom-button">
                            <a href="<?php echo $url_facebook; ?>" target="_blank">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M23.9739 1.34761V22.6483C23.9739 23.3806 23.3806 23.9685 22.6536 23.9685H16.5494V14.6999H19.6603L20.1253 11.0866H16.544V8.77746C16.544 7.72979 16.8327 7.01888 18.3347 7.01888H20.2483V3.78503C19.9169 3.74227 18.7837 3.64071 17.4581 3.64071C14.7 3.64071 12.8077 5.32445 12.8077 8.41933V11.0866H9.68614V14.6999H12.8077V23.9739H1.34761C0.620662 23.9739 0.0273438 23.3806 0.0273438 22.6536V1.34761C0.0273438 0.620662 0.620662 0.0273438 1.34761 0.0273438H22.6483C23.3806 0.0273438 23.9739 0.620662 23.9739 1.34761Z" fill="#FF8A65" />
                                </svg>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if ($url_instagram) : ?>
                        <div class="st-custom-button">
                            <a href="<?php echo $url_instagram; ?>" target="_blank">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.9826 5.85907C8.58307 5.85907 5.84098 8.60117 5.84098 12.0007C5.84098 15.4003 8.58307 18.1424 11.9826 18.1424C15.3822 18.1424 18.1243 15.4003 18.1243 12.0007C18.1243 8.60117 15.3822 5.85907 11.9826 5.85907ZM11.9826 15.9936C9.78575 15.9936 7.98975 14.2029 7.98975 12.0007C7.98975 9.79849 9.7804 8.00785 11.9826 8.00785C14.1849 8.00785 15.9755 9.79849 15.9755 12.0007C15.9755 14.2029 14.1795 15.9936 11.9826 15.9936ZM19.808 5.60785C19.808 6.40428 19.1666 7.04036 18.3755 7.04036C18.0922 7.04036 17.8152 6.95635 17.5796 6.79894C17.3441 6.64153 17.1605 6.41781 17.052 6.15605C16.9436 5.89429 16.9152 5.60626 16.9705 5.32838C17.0258 5.0505 17.1622 4.79525 17.3626 4.5949C17.5629 4.39456 17.8181 4.25813 18.096 4.20286C18.3739 4.14758 18.6619 4.17595 18.9237 4.28437C19.1855 4.3928 19.4092 4.57641 19.5666 4.81198C19.724 5.04756 19.808 5.32452 19.808 5.60785ZM23.8757 7.06175C23.7849 5.14281 23.3465 3.44304 21.9408 2.04259C20.5403 0.642146 18.8405 0.203838 16.9216 0.107625C14.9439 -0.00462486 9.01604 -0.00462486 7.03831 0.107625C5.12472 0.198493 3.42494 0.6368 2.01915 2.03725C0.613363 3.43769 0.180401 5.13747 0.0841871 7.0564C-0.0280624 9.03413 -0.0280624 14.962 0.0841871 16.9397C0.175056 18.8586 0.613363 20.5584 2.01915 21.9588C3.42494 23.3593 5.11938 23.7976 7.03831 23.8938C9.01604 24.0061 14.9439 24.0061 16.9216 23.8938C18.8405 23.8029 20.5403 23.3646 21.9408 21.9588C23.3412 20.5584 23.7795 18.8586 23.8757 16.9397C23.988 14.962 23.988 9.03947 23.8757 7.06175ZM21.3207 19.0617C21.1174 19.5771 20.8104 20.0451 20.4187 20.4368C20.027 20.8285 19.559 21.1355 19.0437 21.3388C17.4668 21.9642 13.7252 21.8199 11.9826 21.8199C10.2401 21.8199 6.4931 21.9589 4.9216 21.3388C4.40629 21.1355 3.93826 20.8285 3.54656 20.4368C3.15485 20.0451 2.84783 19.5771 2.64454 19.0617C2.01915 17.4849 2.16347 13.7433 2.16347 12.0007C2.16347 10.2582 2.0245 6.51119 2.64454 4.9397C2.84783 4.42439 3.15485 3.95635 3.54656 3.56465C3.93826 3.17294 4.40629 2.86592 4.9216 2.66264C6.49844 2.03725 10.2401 2.18157 11.9826 2.18157C13.7252 2.18157 17.4722 2.04259 19.0437 2.66264C19.559 2.86592 20.027 3.17294 20.4187 3.56465C20.8104 3.95635 21.1174 4.42439 21.3207 4.9397C21.9461 6.51653 21.8018 10.2582 21.8018 12.0007C21.8018 13.7433 21.9461 17.4903 21.3207 19.0617Z" fill="#FF8A65" />
                                </svg>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if ($url_linkedin) : ?>
                        <div class="st-custom-button">
                            <a href="<?php echo $url_linkedin; ?>" target="_blank">
                                <svg width="25" height="23" viewBox="0 0 25 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M24.5 22.9912V14.1697C24.5 9.41968 22.0198 7.23315 18.6377 7.23315C15.932 7.23315 14.7294 8.7411 14.053 9.79666V7.61014H8.94225C9.0174 9.04269 8.94225 22.9912 8.94225 22.9912H14.053V14.3959C14.053 13.9435 14.053 13.4911 14.2033 13.1141C14.5791 12.2094 15.4059 11.2292 16.8339 11.2292C18.7128 11.2292 19.3892 12.6618 19.3892 14.6975V22.9158H24.5V22.9912ZM3.60601 5.49901C5.40981 5.49901 6.46203 4.29265 6.46203 2.8601C6.46203 1.35215 5.33465 0.221191 3.60601 0.221191C1.87737 0.221191 0.75 1.35215 0.75 2.8601C0.75 4.36805 1.80222 5.49901 3.60601 5.49901ZM6.16139 7.61014H1.05063V22.9912H6.16139V7.61014Z" fill="#FF8A65" />
                                </svg>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($link) :
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                    <div class="sponsors_link_section">
                        <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if (!empty($show_speakers_list)) { ?>
        <?php
        if ($enable_manual_speaker_selection && !empty($speaker_selection)) { ?>
            <div class="speaker_latest speaker_latest_speaking">
                <div class="small-container">
                    <div class="speaker_latest_title">
                        <h3><?php echo "Speakers"; ?></h3>
                    </div>
                    <div class="speaker_latest_list">
                        <?php foreach ($speaker_selection as $key => $value) {
                            $id = $value;
                            $title = get_the_title($id);
                            $link = get_permalink($id);
                            $excerpt = get_field('short_description', $id);
                            $image = get_the_post_thumbnail_url($id, 'full');
                            $date = get_the_date('j F Y', $id);
                        ?>
                            <div class="speaker_latest_list__item d-flex">
                                <div class="speaker_latest_list_image">
                                    <a href="<?php echo $link; ?>" class="image" style="background-image: url(<?php echo $image; ?>);">
                                        <img src="<?php echo get_template_directory_uri(); ?>/dist/images/140-140.png" alt="Image" />
                                    </a>
                                </div>
                                <div class="speaker_latest_list__details d-flex flex-column">
                                    <h4 class="speaker_latest_list_heading"><a href="<?php echo $link; ?>"><?php echo $title; ?></a></h4>
                                    <div class="excerpt"><?php echo $excerpt; ?></div>
                                    <div class="post_date"><?php echo $date; ?></div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } else {
            $next_args = array(
                'post_type' => 'speaker',
                'post_status' => 'publish',
                'posts_per_page' => 3,
                'order' => 'DESC',
                'orderby' => 'ID',
                'post__not_in' => array($post->ID)
            );
            $next_the_query = new WP_Query($next_args);
            if ($next_the_query->have_posts()) { ?>
                <div class="speaker_latest speaker_latest_speaking">
                    <div class="small-container">
                        <div class="speaker_latest_title">
                            <h3><?php echo "Speakers"; ?></h3>
                        </div>
                        <div class="speaker_latest_list">
                            <?php while ($next_the_query->have_posts()) {
                                $next_the_query->the_post();
                                $id = $post->ID;
                                $title = get_the_title($id);
                                $link = get_permalink($id);
                                $excerpt = get_field('short_description', $id);
                                $image = get_the_post_thumbnail_url($id, 'full');
                                $date = get_the_date('j F Y', $id);
                            ?>
                                <div class="speaker_latest_list__item d-flex">
                                    <div class="speaker_latest_list_image">
                                        <a href="<?php echo $link; ?>" class="image" style="background-image: url(<?php echo $image; ?>);">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/140-140.png" alt="Image" />
                                        </a>
                                    </div>
                                    <div class="speaker_latest_list__details d-flex flex-column">
                                        <h4 class="speaker_latest_list_heading"><a href="<?php echo $link; ?>"><?php echo $title; ?></a></h4>
                                        <div class="excerpt"><?php echo $excerpt; ?></div>
                                        <div class="post_date"><?php echo $date; ?></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
        <?php
            }
            wp_reset_postdata();
        }
        ?>
        <?php } ?>
    </div>
<?php endif; ?>