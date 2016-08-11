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
                $j('.count').html(data.count);
                if ($j('.header-minicart')) {
                    $j('.header-minicart').html( data.minicart );
                }
                if($j('.block-cart')){
                    $j('.block-cart').replaceWith(data.sidebar);
                }

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
