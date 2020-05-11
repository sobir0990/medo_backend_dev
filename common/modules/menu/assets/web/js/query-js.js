var query_handler = function(){
    $('[data-query]').each(function(){
        $(this).off('click');
        $(this).click(function(e){

            e.preventDefault();

            var data_query = $(e.currentTarget).attr('data-query');
            var data_query_method = $(e.currentTarget).attr('data-query-method');
            var data_query_url = $(e.currentTarget).attr('data-query-url');
            var data_query_params = $(e.currentTarget).attr('data-query-params');
            var data_query_confirm = $(e.currentTarget).attr('data-query-confirm');


            if(data_query_confirm.length > 1){

                var confirm_data = window.confirm(data_query_confirm,'asdasd','sadsad');
                if(!confirm_data){return;}
            }

            if(data_query == "delete"){
                var delete_dom_element = $(e.currentTarget).attr('data-query-delete-selector');
                $.ajax({
                    'url' : data_query_url,
                    'type' : data_query_method,
                    'data' : data_query_params,
                    'success' : function(data){
                        if(data == 'ok'){
                            $(delete_dom_element).css('background-color','#a94442');
                            $(delete_dom_element).css('color','white');
                            $(delete_dom_element).hide(1000);
                        }else{
                            alert('Error!');
                        }
                    },
                });
            }
        });
    });
}
$(document).ready(function(){
    query_handler();
});