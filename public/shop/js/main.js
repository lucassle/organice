/*  ---------------------------------------------------
    Template Name: Ogani
    Description:  Ogani eCommerce  HTML Template
    Author: Colorlib
    Author URI: https://colorlib.com
    Version: 1.0
    Created: Colorlib
---------------------------------------------------------  */

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        /*------------------
            Gallery filter
        --------------------*/
        $('.featured__controls li').on('click', function () {
            $('.featured__controls li').removeClass('active');
            $(this).addClass('active');
        });
        if ($('.featured__filter').length > 0) {
            var containerEl = document.querySelector('.featured__filter');
            var mixer = mixitup(containerEl);
        }
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    //Humberger Menu
    $(".humberger__open").on('click', function () {
        $(".humberger__menu__wrapper").addClass("show__humberger__menu__wrapper");
        $(".humberger__menu__overlay").addClass("active");
        $("body").addClass("over_hid");
    });

    $(".humberger__menu__overlay").on('click', function () {
        $(".humberger__menu__wrapper").removeClass("show__humberger__menu__wrapper");
        $(".humberger__menu__overlay").removeClass("active");
        $("body").removeClass("over_hid");
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*-----------------------
        Categories Slider
    ------------------------*/
    $(".categories__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 4,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {

            0: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 3,
            },

            992: {
                items: 4,
            }
        }
    });


    $('.hero__categories__all').on('click', function(){
        $('.hero__categories ul').slideToggle(400);
    });

    /*--------------------------
        Latest Product Slider
    ----------------------------*/
    $(".latest-product__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true
    });

    /*-----------------------------
        Product Discount Slider
    -------------------------------*/
    $(".product__discount__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 3,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {

            320: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 2,
            },

            992: {
                items: 3,
            }
        }
    });

    /*---------------------------------
        Product Details Pic Slider
    ----------------------------------*/
    $(".product__details__pic__slider").owlCarousel({
        loop: true,
        margin: 20,
        items: 4,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true
    });

    /*-----------------------
		Price Range Slider
	------------------------ */
    var rangeSlider = $(".price-range"),
        minamount = $("#minamount"),
        maxamount = $("#maxamount"),
        minPrice = rangeSlider.data('min'),
        maxPrice = rangeSlider.data('max');
    rangeSlider.slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        slide: function (event, ui) {
            minamount.val('$' + ui.values[0]);
            maxamount.val('$' + ui.values[1]);
        }
    });
    minamount.val('$' + rangeSlider.slider("values", 0));
    maxamount.val('$' + rangeSlider.slider("values", 1));

    /*--------------------------
        Select
    ----------------------------*/
    $("select").niceSelect();

    /*------------------
		Single Product
	--------------------*/
    $('.product__details__pic__slider img').on('click', function () {

        var imgurl = $(this).data('imgbigurl');
        var bigImg = $('.product__details__pic__item--large').attr('src');
        if (imgurl != bigImg) {
            $('.product__details__pic__item--large').attr({
                src: imgurl
            });
        }
    });

    /*-------------------
		Quantity change
	--------------------- */
    var proQty = $('.pro-qty');
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');
    proQty.on('click', '.qtybtn', function () {
        var $button = $(this);
        var oldValue = $button.parent().find('input').val();
        if ($button.hasClass('inc')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find('input').val(newVal);
    });

    window.onload = setShareLinks;

    function setShareLinks() {
        var pageUrl = encodeURIComponent(document.URL);
        var pageTitle = encodeURIComponent(document.title);

        document.addEventListener('click', function (event) {  
            let url = null;
            
            if (event.target.classList.contains('share__link--facebook')) {
                url = "https://www.facebook.com/sharer.php?u=" + pageUrl;
                socialWindow(url, 570, 570);
            }

            if (event.target.classList.contains('share__link--twitter')) {
                url = "https://twitter.com/intent/tweet?url=" + pageUrl + "&text=" + pageTitle;
                socialWindow(url, 570, 300);
            }

            if (event.target.classList.contains('share__link--linkedin')) {
                url = "https://www.linkedin.com/shareArticle?mini=true&url=" + pageUrl;
                socialWindow(url, 570, 570);
            }

            if (event.target.classList.contains('share__link--pinterest')) {
                url = "https://www.linkedin.com/shareArticle?mini=true&url=" + pageUrl;
                socialWindow(url, 570, 570);
            }

            // if (event.target.classList.contains('share__link--mail')) {
            // url = "mailto:?subject=%22" + pageTitle + "%22&body=Read%20the%20article%20%22" + pageTitle + "%22%20on%20" + pageUrl;
            // socialWindow(url, 570, 450);
            // }

            }, false);
    }

    function socialWindow(url, width, height) {
        var left = (screen.width - width) / 2;
        var top = (screen.height - height) / 2;
        var params = "menubar=no,toolbar=no,status=no,width=" + width + ",height=" + height + ",top=" + top + ",left=" + left;
        window.open(url,"",params);
    }

    $("#coupon-btn").on('click', function() {
        var coupon_id   = $("#coupon-id").val();
        $.ajax({
            url: '{{ url("/cart/discount") }}',
            data: "code=" + coupon_id,
            success: function (response) {
                $('#cart-total').html(response);
            }
        });
    });

    // Recall
    $(document).on('click', function () {
        $(".zvn-submit-phone").click(function () {
            var $elm_input  = $("input[name='phone_customer']");
            var $elm_alert  = $(".modal-body .alert");
            var $elm_this   = $(this);
            var phone       = $elm_input.val();
            var route 	    = $(".zvn-submit-phone").attr('action');
            $('<div class="loader"></div>').insertBefore($elm_input);
            $elm_alert.remove();
            $.ajax({
                url: route,
                method:"POST",
                data:{phone:phone},
                dataType:"json",
                error:function(a,b){
                    var arr_errors= a.responseJSON.errors.phone;
                    $('.loader').remove();
                    if(arr_errors.length > 0){
                        var xhtml = `<div class="alert alert-danger alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                    </button>`;
                                    for (var i=0;i<arr_errors.length;i++){
                                        xhtml += `<strong>${arr_errors[i]}</strong>`;
                                    }
                        xhtml += `</div>`;
                        $(xhtml).insertBefore($elm_input);

                    }
                },
                success:function (response) {
                    $elm_this.addClass('btn-is-disabled');
                    if (response.code === 1){
                        $('.loader').remove();
                        var xhtml = `<div class="alert alert-info alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>${response.msg}</strong>
                                </div>`;
                        $(xhtml).insertBefore($elm_input);
                        window.location.href='http://organice.test/notify.html';
                    }
                }

            });
        });
    });

    // Ajax Change Value Quantity
	// $('.quantity-input').on('change', function() {
    //     var cartItemId = $(this).data('cart-item-id');
    //     var newQuantity = $(this).val();

    //     $.ajax({
    //         type: 'PATCH',
    //         url: '/update-cart-item',
    //         data: {
    //             cart_item_id: cartItemId,
    //             quantity: newQuantity,
    //         },
    //         success: function(response) {
    //             if (response.success) {
    //                 console.log('Quantity updated successfully');
    //                 // You can update the UI here if needed
    //             } else {
    //                 console.log('Failed to update quantity');
    //             }
    //         },
    //         error: function(error) {
    //             console.log('Error updating quantity', error);
    //         }
    //     });
    // });
    
})(jQuery);

// Ajax Add to Cart
function addItemToCart(productId, quantity) {
    $.ajax({
        type: 'POST',
        url: '/cart/addItem',
        data: {
            product_id: productId ,
            quantity: quantity,
            _token: '{{ csrf_token() }}' // Include CSRF token
        },
        success: function (response) {
            // Update the UI or perform any necessary actions
            console.log('Item added to cart successfully');
            alert('Item added to cart successfully!');
        },
        error: function (error) {
            alert('Error adding item to cart!');
            console.error('Error adding item to cart', error);
        }
    });
}