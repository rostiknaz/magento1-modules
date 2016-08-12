/**
 * Created by naro on 11.08.16.
 */


function addToCart(url, product_id){
    var url_array = url.split('/');
    var product_index = url_array.indexOf('product');
    var formkey_index = url_array.indexOf('form_key');
    //console.log(url_array);
    var data = '';
    data = '&form_key='+url_array[formkey_index+1];
    if(product_index){
        data += '&product='+url_array[product_index+1];
    }
    data += '&isAjax=1';
    $j('#catalog_addtocart_'+ product_id).hide();
    $j('#ajax_loader_'+ product_id).show();
    try {
        $j.ajax({
            url: url,
            dataType: 'json',
            type : 'post',
            data: data,
            success: function(data){
                $j('html, body').animate({scrollTop: 0},500);
                $j('#ajax_loader_'+ product_id).hide();
                $j('#catalog_addtocart_'+ product_id).show();
                $j('.header-minicart').html(data.minicart);
                $j('#header-account').html(data.toplink);



                $j('<ul class="messages">' +
                    '<li class="'+data.status+'-msg">' +
                        '<ul>' +
                            '<li><span>'+data.message+'</span></li>' +
                        '</ul>' +
                    '</li>' +
                '</ul>')
                    .insertAfter('.category-title');
                setTimeout(function(){$j('.messages').fadeOut('fast')},3000);
            }
        });
    } catch (e) {
        console.log(e);
    }
}

var skipContents = $j('.skip-content');
var skipLinks = $j('.header-minicart a.skip-link');

$j(document).on('click','.header-minicart a.skip-link', function (e) {
    e.preventDefault();

    var self = $j(this);
    // Use the data-target-element attribute, if it exists. Fall back to href.
    var target = self.attr('data-target-element') ? self.attr('data-target-element') : self.attr('href');
    console.log(target);

    // Get target element
    var elem = $j(target);

    // Check if stub is open
    var isSkipContentOpen = elem.hasClass('skip-active') ? 1 : 0;

    // Hide all stubs
    skipLinks.removeClass('skip-active');
    skipContents.removeClass('skip-active');

    // Toggle stubs
    if (isSkipContentOpen) {
        self.removeClass('skip-active');
    } else {
        self.addClass('skip-active');
        elem.addClass('skip-active');
    }
});

$j(document).on('click', '.skip-link-close', function(e) {
    var parent = $j(this).parents('.skip-content');
    var link = parent.siblings('.skip-link');

    parent.removeClass('skip-active');
    link.removeClass('skip-active');

    e.preventDefault();
});
