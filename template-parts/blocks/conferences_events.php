<?php

/**
 * Conferences and Events Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

global $wp;

$date_now = current_time('Y-m-d H:i:s', false); // For Live
// $date_now = date_create( '2021-09-11 00:00:00' )->format("Y-m-d H:i:s"); // For Dev
$date_end = current_time('Y-m-d 23:59:59', false); // For Live
// $date_end = date_create( '2021-09-11 23:59:59' )->format("Y-m-d H:i:s"); // For Dev

// Create id attribute allowing for custom "anchor" value.
$id = 'conferences_events-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'conferences_events';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

if ((count($_GET) > 0) && (array_key_exists('ev_s', $_GET)) && ($_GET['ev_s'])) {
    $ev_s = $_GET['ev_s'];
} else {
    $ev_s = '';
}

$heading = get_field('heading');
$terms = get_terms('stream_category', array(
    'hide_empty' => false,
));
$first_date_value = current_time('Y-m-d H:i:s', false);
$first_date_value_end = current_time('Y-m-d 23:59:59', false);
?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="conferences_events__inner <?php echo ($ev_s == '') ? '' : 'event_search'; ?>">
        <div class="conferences_events__header">
            <div class="container">
                <div class="conferences_events__header__inner">
                    
                    
                    <?php if ($ev_s == '' && $heading) : ?> 
                        <h1 class="heading"><?php echo $heading;
                        
                            if( have_rows('date_list') ):
                               // echo get_sub_field('days_drop_down_options');
                            else :
                                // no rows found
                            endif;
                        ?>
                        <span class="appenddates"></span>
                        <span class="appenddates1"></span>
                        </h1> 
                    <?php endif; ?>
                    
                    <div class="conferences_events__search">
                        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url($wp->request)); ?>">
                            <input type="search" class="search-field" placeholder="<?php echo esc_attr_x('Keyword, Speaker, Company', 'placeholder', 'twentytwenty'); ?>" value="<?php echo $ev_s; ?>" name="ev_s" />
                            
                            <button type="submit" class="search-submit"><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.33333 7.33333H7.80667L7.62 7.15333C8.27333 6.39333 8.66667 5.40667 8.66667 4.33333C8.66667 1.94 6.72667 0 4.33333 0C1.94 0 0 1.94 0 4.33333C0 6.72667 1.94 8.66667 4.33333 8.66667C5.40667 8.66667 6.39333 8.27333 7.15333 7.62L7.33333 7.80667V8.33333L10.6667 11.66L11.66 10.6667L8.33333 7.33333ZM4.33333 7.33333C2.67333 7.33333 1.33333 5.99333 1.33333 4.33333C1.33333 2.67333 2.67333 1.33333 4.33333 1.33333C5.99333 1.33333 7.33333 2.67333 7.33333 4.33333C7.33333 5.99333 5.99333 7.33333 4.33333 7.33333Z" fill="#8C8C8C" />
                                </svg></button>
                        </form>
                    </div>
                    <?php if ($terms) : ?>
                        <div class="conferences_events__terms_list_outer open">
                            <?php if ($ev_s != '') : ?>
                                <div class="conferences_events__terms_list__heading ">
                                    <h6 class="title">Advanced Therapies Week Streams</h6>
                                    <span class="icon"><svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.41 7.41016L6 2.83016L10.59 7.41016L12 6.00016L6 0.000156927L-1.23266e-07 6.00016L1.41 7.41016Z" fill="black" />
                                        </svg></span>
                                </div>
                            <?php endif; ?>
                            <div class="conferences_events__terms_list">
                                <div class="mobileView filterWarpper">
                                    <button class="btn btn-primary mobileBtn " type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Filter Your Search</button>
                                    <div class="collapse mobileView" id="collapseExample">
                                        <div class="card card-body">
                                            <form method="POST" id="conferences_form" class="">
                                        <!-- hamza -->
                                        <select class="conferences_events__dates" id="date_nw" name="date_now" >
    									<?php
    									  
    									if (have_rows('date_list')) :
    										$index = 0;
    										while (have_rows('date_list')) : the_row();
    											$mp = get_row_index();
    											$date_now = get_sub_field('date');
    											$index++;
    											$valueDate = date_create($date_now . ' 00:00:00')->format("Y-m-d H:i:s");
    											$valueDate_end = date_create($date_now . ' 23:59:59')->format("Y-m-d H:i:s");
    											if ($mp == 1) {
    												$first_date_value = $valueDate;
    												$first_date_value_end = $valueDate_end;
    											}
    											$labelDate = date_create($date_now)->format("d F Y");
    									?>
    											<option value="<?php echo $labelDate; ?>" class="conferences_events__dateItem <?php echo ($mp == 1) ? 'active' : ''; ?>">
    												<!--<a href="javascript:void(0);" ><?php // echo 'Day '.$index; ?></a>-->
    												<a href="javascript:void(0);" ><?php echo get_sub_field('days_drop_down_options') ?></a>
    											</option>
    										<?php // } 
    										endwhile;
    										
    
    									else :
    										?>
    										<?php for ($mp = 0; $mp < 4; $mp++) {
    											if ($mp == 0) {
    												$valueDate = date_create($date_now)->modify("+{$mp} day")->format("Y-m-d H:i:s");
    											} else {
    												$date_now = date_create($date_now)->format("Y-m-d");
    												$valueDate = date_create($date_now . ' 00:00:00')->modify("+{$mp} day")->format("Y-m-d H:i:s");
    											}
    											$labelDate = date_create($date_now)->modify("+{$mp} day")->format("l d F");
    										?>
    											<option class="conferences_events__dateItem <?php echo ($mp == 0) ? 'active' : ''; ?>">
    												<a href="javascript:void(0);" data-date="<?php echo $valueDate; ?>"><?php echo $labelDate; ?></a>
    											</option>
    										<?php } ?>
    
    									<?php endif; ?>
    								</select>
    								
    								  <div class="conferences_events__term resetWrapper">
                                            <label class="checkbox style-c">
                                                <input type="checkbox" type="checkbox" class="reset"  name="event_term[]" value="all" >
                                                <div class="checkbox__checkmark" style="background-color: #000"></div>
                                                <div class="checkbox__body">Reset</div>
                                              </label>
                                       </div>   
                                        
                                        
                                        
                                    <?php foreach ($terms as $key => $term) {
                                        $color = get_field('color', $term);
                                        if ($ev_s == '') :
                                            $postCount = get_posts(array(
                                                'post_type' => 'stream', 'post_status' => 'publish', 'numberposts' => -1, 'fields' => 'ids',
                                                'tax_query'      => array(
                                                    array(
                                                        'taxonomy' => $term->taxonomy,
                                                        'field'    => 'term_id',
                                                        'terms'    => $term->term_id,
                                                    )
                                                ),
                                                /* 'meta_query' => array(
                                        array(
                                            'key'           => 'agenda_date',
                                            'compare'       => '>=',
                                            'value'         => $date_now,
                                            'type'          => 'DATETIME',
                                        )
                                    ), */
                                            ));
                                        endif;
                                    ?>
                                        <div class="conferences_events__term">
                                           
                                            <?php /* ?>
                                            <a href="<?php echo get_term_link($term, $term->taxonomy); ?>" class="term">
                                                <?php echo $term->name; ?> <?php if ($ev_s == '') : ?>
                                                <span class="count">
                                                    (<?php echo count($postCount); ?>)
                                                </span>
                                                <?php endif; ?>
                                            </a>
                                            <?php */ ?>
                                            
                                            
                                            
                                            <label class="checkbox style-c">
                                                
                                                <!--<style>-->
                                                <!--    .checkbox.style-c input:checked ~ .checkbox__checkmark {  background-color: <?php echo $color; ?> }-->
    
                                                <!--</style>-->
                                            <input type="checkbox" class="my_chckbx" type="checkbox"  name="event_term[]" value="<?php echo $term->term_id; ?>" style=" accent-color: <?php echo $color; ?>">
                                            <div class="checkbox__checkmark" style="background-color: <?php echo hex2rgba($color, 0.8) ; ?>"></div>
                                            <div class="checkbox__body"> <?php echo $term->name; ?> <?php if ($ev_s == '') : ?> (<?php echo count($postCount); ?>)</div>
                                             <?php endif; ?>
                                          </label>
                                          </div>
                                    <?php } ?>
                                    
                                     <div class="conferences_events__term">
                                            <label class="checkbox style-c">
                                                <input type="checkbox" type="checkbox"  id="checkAll" name="event_term[]" value="all" >
                                                <div class="checkbox__checkmark" style="background-color: #000"></div>
                                                <div class="checkbox__body">Check All</div>
                                              </label>
                                       </div>   
                                     
                                          
                                    <input type="hidden" name="action" value="event_action" >
                                    
                                    <input type="hidden" name="paged" value="paged" >
                                    
                                    <input type="hidden" name="ev_s" value="<?php echo $ev_s; ?>" >
    								
    								
    								
                                    
                                    </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($ev_s == '' || have_rows('date_list')) :

                    ?>
                        
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="conferences_events__eventList">
			<div class="conferences_events__dates_outer" style="">
				<div class="mainHeader">
    				<p class="date_text">
    					
    					</p>
    				<a href="/advanced-therapies-week-agenda-2/"><?php the_field('back_agend_button_text') ?></a>
				</div>
                        </div>
            <?php if ($ev_s == '') : ?>
                <div class="container">
                <?php endif; ?>
                <div class="conferences_events__eventList__inner">
                    <?php if ($ev_s == '') : ?>
                        <?php get_template_part('template-parts/eventList', 'none', array('date_now' => $first_date_value, 'date_end' => $first_date_value_end)); ?>
                    <?php else : ?>
                        <?php get_template_part('template-parts/search', 'eventList', array('date_now' => $date_now, 'ev_s' => $ev_s, 'paged' => 1)); ?>
                    <?php endif; ?>
                </div>

                <?php if ($ev_s == '') : ?>
                </div>
            <?php endif; ?>
        </div>
        

        <script type="text/javascript">
            jQuery(document).ready(function($) {
				var date_now = $('.conferences_events__dates').find(":selected").val();
				//console.log
				$('.date_text').text(date_now);
						$('.conferences_events__dates').on('change', function() {
						 date_now = $('.conferences_events__dates').find(":selected").val();
					//console.log(date_now);
							$('.date_text').text(date_now);
                   // filter_post(date_now);
						});
						
				// Star here overview append text days		
				// var date_now = $('.conferences_events__dates').find(":selected").text();
				//$('.appenddates').text(date_now); // upar
				$('.conferences_events__dates').on('change', function() {
				const date_text = $('.conferences_events__dates').find(":selected")[0].text;
				console.log(date_text);
				    
				    
				    $('.appenddates').text(date_text); // nechay    
				});	
				
				
				 
				
				
				
				
                // reset button star
                // var checker = document.getElementsByClassName('my_chckbx');
                // var sendbtn = document.getElementsByClassName('resetButton');
                // 	console.log(sendbtn);
                // checker.onchange = function() {
                //       $("resetButton").addClass("active");
                // };
						
// 					$('.my_chckbx').change(function(){
//     if($(this).is(":checked")) {
//         $('.resetButton').addClass("activeBtn");
//     } else if($(this).not(":checked")) {
//         $('.resetButton').removeClass("activeBtn");
//     }
// });
// 	 $('.resetButton').click(function(e) {
//     $('.my_chckbx:checked').removeAttr('checked');
//      $('button.resetButton').toggleClass("activeBtn", boxes.is(":checked"));
//     e.preventDefault();
//  });
// var boxes = $('input.my_chckbx');

// boxes.on('change', function () {
//   $('button.resetButton').toggleClass("activeBtn", boxes.is(":checked"));
// });
	


						
//                 $("body").on("click", ".conferences_events .conferences_events__dateItem", function(event) {
					
//                     event.preventDefault();
				
//                     $(this).parent().siblings().removeClass('active');
//                     $(this).parent().addClass('active');
//                     var date_now = $('#conferences_events__dates').find(":selected").attr('data-date');
// 					console.log(date_now);
//                     filter_post(date_now);
//                 });

                $("body").on("click", ".conferences_events .pagination li:not(.disable) > a.pbtn", function(event) {
                    event.preventDefault();
                    var paged = $(this).attr('data-paged');
                    //filter_post('<?php echo $date_now; ?>', paged);
                });

                if ($(window).width() < 768) {
                    $("body").on("click", ".conferences_events .conferences_events__eventRow__time", function(event) {
                        event.preventDefault();
                        // $(this).parent().siblings().removeClass('active');
                        $(this).parent().addClass('active');
                        $(this).closest('.conferences_events__eventList__inner').find(':not(.active) .conferences_events__eventRow__eventboxs').slideUp();
                        $(this).next().slideDown();
                    });
                    $('.conferences_events__eventRow:first-child > .conferences_events__eventRow__time').click();
                    <?php if ($ev_s) : ?>
                        $('body').addClass('open_search_terms');
                    <?php endif; ?>
                    $("body").on("click", ".conferences_events .conferences_events__terms_list__heading", function(event) {
                        event.preventDefault();
                        $(this).next().slideToggle().parent().toggleClass('open');
                        $('body').toggleClass('open_search_terms');
                    });
                    $('.conferences_events .conferences_events__terms_list__heading').click();
                }

                /*  $( "body" ).on( "click", ".conferences_events__eventRow__box .speakers__img", function(event) {
                     event.preventDefault();
                     $(this).find('.speakers_tooltip').css();
                 }); */

                if ($(window).width() > 1200) {
                    $("body").on("hover", ".conferences_events__eventRow__box .speakers__img", function(event) {
                        // function() {
                        $(this).find('.speakers_tooltip').css('display', 'flex');
                    }, function() {
                        $(this).find('.speakers_tooltip').css('display', 'none');
                    });
                }

            });

            function filter_post(date_now = '', paged = 1) {
			
			
				
                
               
               
                jQuery('input[name="event_term[]"]').each(function() { 
        			this.checked = false; 
        		});
                       
                
                jQuery('.conferences_events').addClass('loading');
                jsonObj = {
                    "action": "filter_event_post",
                    "date_now": date_now,
                    // "date_end": '<?php echo $date_end; ?>',
                    "paged": paged,
                    "ev_s": '<?php echo $ev_s; ?>',
                };

                jQuery.ajax({
                    url: ajax_call_url,
                    data: jsonObj, // form data
                    type: "POST", // POST
                    // async: true,
                    beforeSend: function(xhr) {
                        // console.log("ajax start"); // changing the button label
                    },
                    success: function(xhr) {
                        // alert(date_now);
                        
                         //jQuery('.my_chckbx').find('input[type=checkbox]:checked').remove();
                         
                       	//$('.appenddates').text('hamza');  
                        
                        setTimeout(function() {
                    console.log(data);
                            if (xhr.success === true) {
                                jQuery('.conferences_events .conferences_events__eventList__inner').html(xhr.data);
                            }
                            jQuery('.conferences_events.loading').removeClass('loading');
                        }, 1000);
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        setTimeout(function() {
                            jQuery('.conferences_events.loading').removeClass('loading');
                        }, 1000);
                    }
                });

            }
        </script>
    </div>
</div>
