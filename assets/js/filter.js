jQuery(document).ready(function ($) {
  jQuery("#checkAll").click(function () {
    $("input:checkbox").not(this).prop("checked", this.checked);
  });

  jQuery(".reset").click(function () {
    //$('input:checkbox').removeAttr('checked');

    jQuery("input:checkbox").prop("checked", false);

    // jQuery('.reset').toggleClass("activeBtn", boxes.is(":checked"));
  });
  jQuery(".my_chckbx:checked").prop(function (e) {
    jQuery("resetWrapper").toggleClass("activeBtn", boxes.is(":checked"));
    e.preventDefault();
  });

  var boxes = jQuery("input.my_chckbx");
  jQuery("input:checkbox").change(function () {
    var ul = ".conferences_events__term ";

    if ($(this).prop("checked")) {
      jQuery(".resetWrapper").addClass("activeReset");
    } else if (
      jQuery(".conferences_events__term").find('input[type="checkbox"]:checked')
        .length == 0
    ) {
      jQuery(".resetWrapper").removeClass("activeReset");
    } else {
    }
  });

  //      var boxes = jQuery('input.my_chckbx');
  //      boxes.on('change', function () {
  //   jQuery('resetWrapper').toggleClass("activeReset", boxes.is(":checked"));
  // });

  jQuery("#conferences_form, #date_nw").on("change", function (e) {
    e.preventDefault();

    jQuery(".conferences_events").addClass("loading");
    var conferences_form = $("#conferences_form");
    jQuery.ajax({
      url: event_ajax_object.ajaxurl,
      type: "post",
      data: conferences_form.serialize(), // form data
      success: function (xhr) {
        // if(xhr == "all"){
        //     location.reload();
        // }

        // const myJSON = JSON.stringify(xhr.data);

        //alert(myJSON);

        //  alert(xhr.data.date_now);

        //jQuery('.appenddates').text(xhr.date_now);

        //jQuery('.appenddates').text('dsadsa');

        // jQuery('#reset_button').val('shariq');

        jQuery(
          ".conferences_events .conferences_events__eventList__inner"
        ).html(xhr.data);
        jQuery(".conferences_events.loading").removeClass("loading");
      },
    });
  });
  return false;
});

// 	 $('.resetButton').click(function(e) {
//     $('input:checkbox').not(this).prop('checked', this.checked);
//      $('button.resetButton').toggleClass("activeBtn", boxes.is(":checked"));
//     e.preventDefault();
//  });

jQuery("#speakerscara").slick({
  infinite: true,
  autoplay: true,
  slidesToShow: 4,
  slidesToScroll: 1,
  dots: false,
  arrows: true,
  prevArrow:
    "<button type='button' class='slick-prev pull-left'><?xml version='1.0'?><svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' version='1.1' id='Capa_1' x='0px' y='0px' viewBox='0 0 59.414 59.414' style='enable-background:new 0 0 59.414 59.414;' xml:space='preserve'><polygon points='45.268,1.414 43.854,0 14.146,29.707 43.854,59.414 45.268,58 16.975,29.707 '/></svg></button>",
  nextArrow:
    "<button type='button' class='slick-next pull-right'><svg version='1.1' id='Capa_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' viewBox='0 0 47.255 47.255' style='enable-background:new 0 0 47.255 47.255;' xml:space='preserve'> <g> <path d='M12.314,47.255c-0.256,0-0.512-0.098-0.707-0.293c-0.391-0.391-0.391-1.023,0-1.414l21.92-21.92l-21.92-21.92 c-0.391-0.391-0.391-1.023,0-1.414s1.023-0.391,1.414,0L35.648,22.92c0.391,0.391,0.391,1.023,0,1.414L13.021,46.962 C12.825,47.157,12.57,47.255,12.314,47.255z'/> </svg></button>",
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
      },
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
      },
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
      },
    },
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ],
});

jQuery("#mainslide").slick({
  infinite: true,
  autoplay: true,
  slidesToShow: 5,
  slidesToScroll: 1,
  dots: false,
  arrows: true,
  prevArrow:
    "<button type='button' class='slick-prev pull-left'><?xml version='1.0'?><svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' version='1.1' id='Capa_1' x='0px' y='0px' viewBox='0 0 59.414 59.414' style='enable-background:new 0 0 59.414 59.414;' xml:space='preserve'><polygon points='45.268,1.414 43.854,0 14.146,29.707 43.854,59.414 45.268,58 16.975,29.707 '/></svg></button>",
  nextArrow:
    "<button type='button' class='slick-next pull-right'><svg version='1.1' id='Capa_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' viewBox='0 0 47.255 47.255' style='enable-background:new 0 0 47.255 47.255;' xml:space='preserve'> <g> <path d='M12.314,47.255c-0.256,0-0.512-0.098-0.707-0.293c-0.391-0.391-0.391-1.023,0-1.414l21.92-21.92l-21.92-21.92 c-0.391-0.391-0.391-1.023,0-1.414s1.023-0.391,1.414,0L35.648,22.92c0.391,0.391,0.391,1.023,0,1.414L13.021,46.962 C12.825,47.157,12.57,47.255,12.314,47.255z'/> </svg></button>",
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
      },
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
      },
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
      },
    },
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ],
});
