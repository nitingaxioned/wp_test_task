$(document).ready(function () {
    pg = 1;
    id = "all";
    jQuery('.load_more').hide();
    jQuery('.show_less').hide();        
    jQuery('.cat').on('change',function() {
        pg = 1;
        id = this.value;
        callAjax( id );
    });

    jQuery('.load_more').on('click',function() {
        pg++;
        callAjax( id );
    });
    
    jQuery('.show_less').on('click',function() {
        if( ajax_off ) {
            pg = 1;
            n = jQuery('.filter-box li').length + jQuery('.filter-box script').length;
            if(n > 6) {
                jQuery('.load_more').show();
            }
            n = n - 6;
            for (let i = 0; i < n; i++) {
                jQuery('.filter-box').children().last().remove();
            }
            jQuery('.show_less').hide();
            if(n > 6) {
                jQuery('.load_more').show();
            }
        }
    });
    
    callAjax("all");
});

function callAjax(id) {
    ajax_off = false;
    jQuery('.load_more').hide();
    jQuery('.show_less').hide();
    (pg == 1) && jQuery('.filter-box').html("<li><p>Loading....</p></li>");
    (pg != 1) && jQuery('.filter-box').append("<li><p>Loading...</p></li>");
    let filter_data = new FormData;
    filter_data.append('action', 'filter');
    filter_data.append('id',id);
    filter_data.append('pg',pg);
    jQuery.ajax({
        url : ajax_object.ajax_url,
        data : filter_data,
        processData : false,
		contentType : false,
        type : 'post',
        success : function(data) {
            if (pg == 1) {
                jQuery('.filter-box').html(data);
            } else {
                jQuery('.filter-box').children().last().remove();
                jQuery('.filter-box').append(data);
                jQuery('.show_less').show();
            }
            ajax_off = true;
        },
        error : function(errorThrown){
            alert('Something went wrong !!! ');
        }
    });
}