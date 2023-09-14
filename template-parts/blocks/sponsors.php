<?php

/**
 * Testimonial Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'sponsors-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'sponsors';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

$heading = get_field('heading');
$add_bottom_border = get_field('add_bottom_border');
$add_more_space_in_bottom = get_field('add_more_space_in_bottom');

$select_sponser = get_field('select_sponser');

?>

<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> <?php if($overflow_content == 1): ?>overflow_content<?php endif; ?>">
    <div class="sponsors_main">
        <div class="container">
            <div class="sponsors_inner<?php if($add_bottom_border == 0){?> no_bottom_border<?php } ?><?php if($add_more_space_in_bottom == 1){?> add_bottom_more_space<?php } ?>">
                <?php if ($heading) { ?>
                    <div class="heading_section">
                        <div class="heading_text h4">
                            <?php echo $heading ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if( $select_sponser ){ ?>
                    <div class="sponser_list">
                        <?php foreach( $select_sponser as $post ): 
                            setup_postdata($post); 
                            $post_id = $post->ID;
                            $title = get_the_title($post_id);
                            $sponsor_image = get_field('sponsor_image', $post_id);
                            $sponsor_subtitle = get_field('sponsor_subtitle', $post_id);
                            $select_sponsor_link_type = get_field('select_sponsor_link_type', $post_id) ? get_field('select_sponsor_link_type', $post_id) : "inner_page"; // inner_page external_link
                            $link = get_permalink($post_id);
                            $sponsor_link = get_field('sponsor_link', $post_id);
                        ?>
                            <div class="item">
                                <div class="item_inner">

                                    <?php if($select_sponsor_link_type == 'external_link'){ ?>
                                        <?php if($sponsor_link){ 
                                            $link_url = $sponsor_link['url']; 
                                            $link_title = $sponsor_link['title'];
                                            $link_target = ($sponsor_link['target'] ? 'target=_blank' : '');    
                                        ?>
                                            <a class="hover_link" href="<?php echo $link_url; ?>" <?php echo $link_target; ?>></a>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if($select_sponsor_link_type == 'inner_page'){ ?>
                                        <a class="hover_link" href="<?php echo $link; ?>" ></a>
                                    <?php } ?>

                                    <div class="logo_section">
                                        <img src="<?php echo $sponsor_image; ?>" alt="image" />
                                    </div>
                                    <div class="content_section">
                                        <div class="title">
                                            <?php echo $title; ?>
                                        </div>
                                        <?php if($sponsor_subtitle){ ?>
                                            <div class="sub_title">
                                                <?php echo $sponsor_subtitle; ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php wp_reset_postdata(); ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>