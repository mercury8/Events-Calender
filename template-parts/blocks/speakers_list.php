<?php

global $wp;

/**
 * Speakers List Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'speakers_list_main-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'speakers_list_main';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

if( (count($_GET) > 0) && (array_key_exists('sk_s', $_GET)) && ($_GET['sk_s']) ){
    $sk_s = $_GET['sk_s'];
}else{
    $sk_s = '';
}

$title = get_field('title');
$page_content = get_field('page_content');
$speaker_info = get_field('speaker_info');
$show_search = get_field('show_search');
$number_of_post = get_field('number_of_post');
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;	

$next_args = array(
    'post_type' => 'speaker',
    'post_status' => 'publish',
    'posts_per_page'=> $number_of_post,
    'order'=>'ASC',
    'orderby'=>'title',
    'paged' => $paged,
    's' => $sk_s,
);
$next_the_query = new WP_Query( $next_args );
$found_posts = $next_the_query->found_posts;
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">    
    <div class="speakers_list__inner">
        <div class="container">
            <div class="speakers_list__wrapper">
                <?php if($title): ?>
                    <h2 class="heading h2"><?php echo $title; ?></h2>
                <?php endif; ?>
                <?php if ($page_content) : ?>
                    <div class="content"><?php echo $page_content; ?></div>
                <?php endif; ?>
                <form id="searchform" method="get" action="<?php echo $actual_link; //echo esc_url( home_url( 'speakers' ) ); ?>">
                    <input type="text" class="search-field" name="sk_s" placeholder="Speaker, Company" value="<?php echo $sk_s; ?>">
                    <?php /* <input type="hidden" name="post_type" value="speaker" /> */ ?>
                    <input type="submit" value="Search" class="searchform-btn">
                </form>
                <?php if ($speaker_info) : ?>
                    <div class="content speaker_info"><?php echo $speaker_info; ?></div>
                <?php endif; ?>
                <?php if( $sk_s != '' ): ?>
                <div class="speaker_search_text">
                    <a href="<?php echo esc_url( home_url( $wp->request ) ); ?>" class="back_btn"><svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="28" height="28" rx="14" fill="#E5E5E5" fill-opacity="0.5"/><path d="M22 13H9.83L15.42 7.41L14 6L6 14L14 22L15.41 20.59L9.83 15H22V13Z" fill="#14111B"/></svg> Back</a>
                    <p class="search_text"><?php echo $found_posts; ?> results found for '<?php echo $sk_s; ?>'</p>
                </div>
                <?php endif; ?>
                <?php if ( $next_the_query->have_posts() ) { ?>
                    <div class="speakers_list">
                        <?php while ( $next_the_query->have_posts() ) {
                            $next_the_query->the_post(); 
                            $id = get_the_ID();
                            $title = get_the_title($id);
                            $link = get_permalink($id);
                            $ceo = get_field('ceo',$id);
                            $sponser_posts  = get_field('select_sponser',$id);
                            $position  = get_field('position',$id);
                            $image = get_the_post_thumbnail_url($id,'full');
                            ?>
                                <div class="speakers_list__item">
                                    <div class="speakers_list__item__inner">
                                        <div class="speakers_list__image">
                                            <div class="image" style="background-image: url(<?php echo $image; ?>);">
                                                <a href="<?php echo $link; ?>"><img src="<?php echo get_template_directory_uri(); ?>/dist/images/110-110.png" alt="Speakers" /></a>
                                            </div>
                                        </div>
                                        <div class="speakers_list__details">
                                            <h3 class="speakers_list__heading"><a href="<?php echo $link; ?>"><?php echo $title; ?></a></h3>
                                            <?php if( $sponser_posts ){ ?>
                                                <div class="speakers_list__ceo">
                                                    <?php foreach( $sponser_posts as $sponser_posts_post ){ 
                                                        setup_postdata($sponser_posts_post); 
                                                        $sponser_posts_post_id = $sponser_posts_post->ID;
                                                        $sponsor_title = get_the_title($sponser_posts_post_id);
                                                    ?>
                                                        <div class="speakers_list__ceo"><?php echo $position; ?><?php echo "&nbsp;•&nbsp;"; ?><?php echo $sponsor_title; ?></div>
                                                    <?php } ?>
                                                </div>
                                                <?php wp_reset_postdata(); ?>
                                            <?php } ?>
                                            <?php if( $sponser_posts ){ ?>
                                                <div class="speakers_list__logo">
                                                    <?php foreach( $sponser_posts as $sponser_posts_post ){ 
                                                        setup_postdata($sponser_posts_post); 
                                                        $sponser_posts_post_id = $sponser_posts_post->ID;
                                                        $sponsor_title = get_the_title($sponser_posts_post_id);
                                                        $sponser_feature_image = get_the_post_thumbnail_url($sponser_posts_post_id);
                                                        $link = get_permalink($sponser_posts_post_id);
                                                    ?>
                                                        <div class="item">
                                                            <a href="<?php echo $link; ?>">
                                                                <img src="<?php echo $sponser_feature_image; ?>" alt="<?php echo $sponsor_title; ?>" />
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <?php wp_reset_postdata(); ?>
                                            <?php } ?>
                                        </div>                
                                    </div>
                                </div>
                        <?php } ?>
                    </div>
                    <?php if ($next_the_query->max_num_pages > 1) { ?>
                        <div class="custom-pagination">
                            <div class="custom-pagination-inner">
                                <?php   
                                    $big = 999999999; // need an unlikely integer
            
                                    echo paginate_links( array(
                                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                        'format' => '?paged=%#%',
                                        'current' => max( 1, get_query_var('paged') ),
                                        'total' => $next_the_query->max_num_pages
                                    ) );
                                ?>
                            </div>
                            <div class="page-numbering">
                                <span><?php echo $paged; ?></span><?php echo "&nbsp;of&nbsp;"; ?><?php echo $next_the_query->max_num_pages; ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php 
                } else { ?>
                    <div class="no-result-component">
                        <p>Speaker data not found.</p>
                        <?php // get_template_part('template-parts/content', 'none'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>