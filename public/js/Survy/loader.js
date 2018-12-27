/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
* Loader - funkcije za ucitavanje podataka
* Author: Gavra Kovacev
* Datum: 13.12.2018.
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */


// ShowMore function - infinite scroll - OVO SADA RADI
(function( $ ) {
    $.fn.showmore = function(container, page_url) {

        window.page = 1;
        window.page_url = page_url;
        window.container = container;
        window.btn_show_more = this;


        this.on('click',function(){

            window.page++;

            $.ajax(
            {
                url: window.page_url + '?page=' + window.page,
                type: "get",
            })
            .done(function(data)
            {
                console.log(window.container);
                if(data == 0){
                    window.btn_show_more.hide();
                    window.page = 1;
                    return false;
                }

                $(window.container).append(data);
                $(window.container).fadeIn("fast");
                
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                alert('server not responding...');
            });
            

        });

    };


}( jQuery ));



/*
* Page loader function
* Load data depends of the catogery or some other values
* @param data_holder - div, span or table holder for loading content
*/ 

(function( $ ) {

    $.fn.pageLoader = function(url,data_holder) {

        // Active page url
        window.page_url = url;

        // Div holder for loading data
        var holder = data_holder;

        $(this.children()).each(function(){

            $(this).on('click',function(e){

                // Prevent default operation 
                e.preventDefault();

                // Li object
                var li = this;

                // select <a> 
                a_link = $(li).find('a');

                // Page url
                window.page_url = a_link.attr('href'); 


                // Fade out div holder
                $(holder).fadeOut("fast");

                // Add active class
                $(li).parent().children().each(function(index,value) {
                    $(value).removeClass('nav-item-active');
                    $(value).addClass('nav-item');

                    // Select current
                    if ($(value).attr('id') == $(li).attr('id')) {
                        $(value).toggleClass('nav-item-active');
                    }    
                });

                // Load data
                $(holder).dataLoader(window.page_url);

            });
        });
    };


}( jQuery ));



/*
* Data Loader
* Load data
* @param url - url of the loading data
*/ 
(function( $ ) {
    $.fn.dataLoader = function(url) {

        // Url request for data
        var load_url = url;

        // Div holder
        var holder = this;

        //$(holder).parent().html("<div style='position: relative; left:50%; top:50%;'><img class='center-block' src='storage/icons/loading.gif'></img></div>");

        // Load data
        $.ajax({
            headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
            type: 'get',
            url: load_url,
            dataType: 'html', 

            success: function(response) {

                // Ako vrati nesto
                if (response != 0) {
                    window.page = 1;
                   // $('#show_more').show();
                    $(holder).html(response);
                    $(holder).fadeIn("fast");
                }
            },

            error: function(response) {
                $(holder).html('<i>The data could not be found</i>');
            }
        });

        
    };

}( jQuery ));




/*
* Search Loader
* Live search and load data
* @param url - url to search and return data
*/ 
(function( $ ) {
    $.fn.searchLoader = function(data_holder) {

        // Div data holder
        var holder = data_holder;

        $(this).on('keyup',function(){

            // Default page url
            var search_url = window.page_url;

            window.console.log(search_url);

            //$("#recipes").html('<img class="center-block" src="{{asset('storage/icons/loading.gif')}}"></img>');
             
            $.ajax({
             
                type : 'get',
                url : search_url,
                dataType: 'html',
                data:{'search': $(this).val()},

                success:function(response){

                    //console.log(response);
                    $(holder).html(response);  

                }
            });
         
        });


    };

}( jQuery ));




/*
* Load More function
* Load more data depends of the pagination value
* @param data_holder - div, span or table holder for loading content
*/ 

(function( $ ) {

    $.fn.loadMore = function(data_holder,loading) {

        window.page = 1;

        // Div holder for loading data
        var holder = data_holder;

        // Div holds loading animation
        var loading = loading;

        //window.console.log(loading);

        // Object
        var btn = $(this);

        btn.on('click',function(){

            // Page number
            window.page++;
            var page = window.page;

            // Default page url
            var page_url = window.page_url + '?page=' + page;

            window.console.log(page_url);

            $.ajax(
            {
                url: page_url,
                type: "get",
                beforeSend: function() {

                window.console.log(loading);

                // setting a timeout
                 $(loading).show();
                }
            })
            .done(function(data)
            {
                
                //window.console.log(page_url);

                if(data == 'nomore'){
          
                    btn.hide();
                    window.page = 1;
                    //return false;
                    //$(holder).fadeIn("fast");
                } else {
                    $(holder).append(data);
                    $(holder).fadeIn("fast");
                }

                $(loading).hide();

               
                
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                $(holder).html('<i>The data could not be found</i>');
            });
             
            
         
        });
    };


}( jQuery ));

