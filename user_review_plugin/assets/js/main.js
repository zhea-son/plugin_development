jQuery(document).ready(function ($){

    $('#filter_form').on('submit', function(e){

        e.preventDefault();
        var rating = $('#rating_filter').val();
        var checked = $('#latest_filter').is(':checked')? 'checked' : 'unchecked' ;

        $.ajax({
            url : ajaxObj.ajaxurl,
            type: 'POST',
            beforeSend: function(xhr){
                $("#btnFilter").text("Processing");
            },
            data: {
                action: 'process_filter_user_reviews',
                rating: rating,
                checked: checked,
            },
            success: function(response) {
                // console.log(response.filters);
                $("#btnFilter").text("Apply");
                $('#review_body').html(response.template);

                for(i=1;i<=response.total_pages;i++){
                    if( i <= response.pages ){
                        $('#page_no_'+i).css("color", "").css("text-decoration", "underline");
                        if(i == response.active_page){
                            $('#page_no_'+i).css("color", "red").css("text-decoration", "none");
                        }
                    }else{
                        $('#page_no_'+i).hide();
                    }
                }

                
            },
           
            
        });
    
    });


    $('.pagination-link').on('click', function(e){
        e.preventDefault();
        var d = $(this).data('page');
        var rating = $('#rating_filter').val();
        var checked = $('#latest_filter').is(':checked') ? 'checked' : 'unchecked' ;

        $.ajax({
            url: ajaxObj.ajaxurl,
            type: 'POST',
            data: {
                action: 'process_pagination',
                page: d,
                rating: rating,
                checked: checked,
            },
            beforeSend: function(xhr){
                $("#btnFilter").text("Processing");
            },
            success: function(response){
                $("#btnFilter").text("Apply");
                $('#review_body').html(response.template);
                
                for(i=1;i<=response.total_pages;i++){
                    if( i <= response.pages ){
                        $('#page_no_'+i).css("color", "").css("text-decoration", "underline");
                        if(i == response.active_page){
                            $('#page_no_'+i).css("color", "red").css("text-decoration", "none");
                        }
                    }else{
                        $('#page_no_'+i).hide();
                    }
                }
                
            }
        });
    });

    

});
