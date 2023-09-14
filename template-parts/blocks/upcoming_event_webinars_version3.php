<?php

/**
 * Upcoming Events and Webinars Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'upcoming_event_webinars-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'upcoming_event_webinars';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

if (is_tax()) {
    $term = $args['term'];
    $prefix_field = $args['prefix_field'];
    $title = get_field($prefix_field . '_title', $term);
    $load_more = get_field($prefix_field . '_load_more', $term);
    if ($load_more == true) {
        $number_of_post = get_field($prefix_field . '_number_of_post', $term);
        $category = get_field($prefix_field . '_select_category', $term);
        $selection_type = get_field($prefix_field . '_selection_type', $term);
        $select_content_type = get_field($prefix_field . '_select_content_type', $term);
        $paged = 1;
        $new_args = array(
            'posts_per_page'      => $number_of_post,
            'post_type'        => 'post',
            'post_status'    => 'publish',
            'paged' => $paged,
            'fields' => 'ids',
        );

        if ($selection_type == "category" && !empty($category)) {
            $new_args['cat'] = $category;
        } else if ($selection_type == "type" && !empty($select_content_type)) {
            $new_args['meta_query'] = array(
                array(
                    'key'     => 'content_type',
                    'value'   => $select_content_type,
                    'compare' => 'LIKE',
                ),
            );
        }

        $postQuery = new WP_Query($new_args);
        $featured_posts = $postQuery->posts;
        $maxPages = $postQuery->max_num_pages;
    } else {
        $featured_posts = get_field($prefix_field . '_select_event', $term);
        $button = get_field($prefix_field . '_button', $term);
    }
} else {
    $title = get_field('title');
    $subtitle = get_field('subtitle');
    $title_color = get_field('title_color');
    $subtitle_color = get_field('subtitle_color');
    $load_more = get_field('load_more');
    if ($load_more == true) {
        $number_of_post = get_field('number_of_post');
        $category = get_field('select_category');
        $selection_type = get_field('selection_type');
        $select_content_type = get_field('select_content_type');
        $paged = 1;

        $args_new = array(
            'posts_per_page'      => $number_of_post,
            'post_type'        => 'post',
            'post_status'    => 'publish',
            'paged' => $paged,
            'fields' => 'ids'
        );

        if ($selection_type == "category" && !empty($category)) {
            $args_new['cat'] = $category;
        } else if ($selection_type == "type" && !empty($select_content_type)) {
            $args_new['meta_query'] = array(
                array(
                    'key'     => 'content_type',
                    'value'   => $select_content_type,
                    'compare' => 'LIKE',
                ),
            );
        }

        $postQuery = new WP_Query($args_new);
        $featured_posts = $postQuery->posts;
        $maxPages = $postQuery->max_num_pages;
        // echo "<pre>";
        // print_r($postQuery);
        // echo "</pre>";
    } else {
        $featured_posts = get_field('select_event');
        $button = get_field('button');
    }
}



?>
<div style="background-color:<?php the_field('color'); ?>" id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="upcoming_event_webinars__inner">
        <div class="container">
            <div class="upcoming_event_webinars__wrapper">
            <?php if ($title) : ?><h2 class="heading h1" style="color:<?php echo $title_color ?> !important;"><?php echo $title; ?></h2><?php endif; ?>
                    <?php if ($subtitle) : ?><h4 class="heading h4" style="color:<?php echo $subtitle_color ?> !important;"><?php echo $subtitle; ?></h4><?php endif; ?> 

                    <?php if( get_field('button_switch') ): ?>
                        <?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>                  
                        <?php else: ?>
                    <?php endif; ?>

                    
                <?php if ($featured_posts) : ?>
                    <div class="upcoming_event_webinars_list">
                        <?php foreach ($featured_posts as $featured_post_id) :

                            set_query_var('postId', $featured_post_id);
                            get_template_part('template-parts/content-upcoming_event_webinars_item_version3');

                        endforeach; ?>
                        <?php if ($load_more == true && $maxPages > 1 && $paged != $maxPages) : ?>
                            <div class="upcoming_event_webinars_list_item updated_upcoming loadMore text-center w-100 mt-5">
                                <a 
style="background-color:<?php the_field('bg-color'); ?>;border-color:<?php the_field('border-color'); ?>;color:<?php the_field('text-color'); ?>" href="javascript:void(0)" class="upcoming_event_webinars_loadMore btn" data-paged="<?php echo ($paged + 1); ?>">Load More</a>
                                <input type="hidden" value="<?php echo $category; ?>" id="selected_term" class="selected_term" />
                                <input type="hidden" value="<?php echo $selection_type; ?>" id="selection_type" class="selection_type" />
                                <input type="hidden" value="<?php echo $select_content_type; ?>" id="select_content_type" class="select_content_type" />
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if ($load_more == false && $button && $button['title']) : ?>
                    <div class="btn_box">
                        <a href="<?php echo $button['url']; ?>" class="btn" <?php echo ($button['target']) ? 'target="_blank"' : ''; ?>>
                            <?php echo $button['title']; ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if ($load_more == true && $maxPages > 1 && $paged != $maxPages) : ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {

                $("body").on("click", ".upcoming_event_webinars_list a.upcoming_event_webinars_loadMore", function(event) {
                    event.preventDefault();
                    var paged = $(this).attr('data-paged');
                    filter_post(paged, $(this));
                });

            });

            function filter_post(paged = 1, self = '') {
                var term_id = jQuery(".upcoming_event_webinars_list_item.loadMore .selected_term").val();
                var stype = jQuery(".upcoming_event_webinars_list_item.loadMore .selection_type").val();
                var ctype = jQuery(".upcoming_event_webinars_list_item.loadMore .select_content_type").val();
                jQuery(self).closest('.upcoming_event_webinars').addClass('loading');
                jsonObj = {
                    "action": "filter_upcoming_event_webinarsa",
                    "post_count": "<?php echo $number_of_post; ?>",
                    "paged": paged,
                    "cat": term_id,
                    "sType": stype,
                    "cType": ctype
                };
                var self = self;
                jQuery.ajax({
                    url: ajax_call_url,
                    data: jsonObj, // form data
                    type: "POST", // POST
                    // async: true,
                    beforeSend: function(xhr) {
                        // console.log("ajax start"); // changing the button label
                    },
                    success: function(xhr) {
                        jQuery(self).closest('.upcoming_event_webinars').removeClass('loading');
                        if (xhr.success === true) {
                            jQuery('.upcoming_event_webinars_list > .loadMore').remove();
                            jQuery('.upcoming_event_webinars_list > .upcoming_event_webinars_list_item:last-child').after(xhr.data);
                        }

                    },
                    error: function(xhr) {
                        console.log(xhr);
                        jQuery(self).closest('.upcoming_event_webinars').removeClass('loading');
                    }
                });

            }
        </script>
    <?php endif; ?>
</div>