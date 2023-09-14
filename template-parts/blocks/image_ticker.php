<?php 

$slider_text_color = get_field('slider_text_color');
$button_main_url = get_field('button_main_url');
$button_main_label = get_field('button_main_label');

?>

<section id="mainsponsors_single">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 py-5" style="background-color:<?php the_field('color'); ?>;background-image:url('<?php the_field('bg_image'); ?>');background-size:cover;background-position:center;">

                    <div class="col-md-8 m-auto">
                    <div class="text-left"><h2 style="color:<?php echo $slider_text_color; ?>;"><?php the_field('main_title') ?></h2></div>

                    <?php  //add me in

                    //Fields

                    //slider_portfolio = Gallery Field

                    $images = get_field('gallery');

                    if( $images ): ?>
                        <div id="mainslide_single" class="slider-for">
                                
                                    <?php foreach( $images as $image ): ?>
                                        <div class="slick-container">
                                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                                            
                                        </div>
                                    <?php endforeach; ?>
                            </div>
                        <div class="slider-nav">
                            
                        

                            </div>
                    <?php endif; ?>
                    
                    <div style="display: flex;justify-content: center;margin-top: 40px;">
                    <?php if ( get_field('button_main_label') ): ?><a href="<?php echo $button_main_url ?>" class="btn bg-green track_main_btn"><?php echo $button_main_label ?></a><?php endif; ?>

                    </div>

                </div>


            </div>
            </div>
        </div>
    </section>