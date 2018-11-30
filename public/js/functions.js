/*
* Fajl sadrzi sve globalne funkcije koje se koriste u aplikaciji
* Author: Gavra Kovacev
* Datum: 02.05.2018.
*/



// Show modal
function showModal(a_url,modal_id) {

    $.ajax({

        headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
        type: 'get',
        url: a_url,
        dataType: 'html',

        success: function(response) {
            $("#"+modal_id).remove();
            $('#page-content').append(response);
            $("#page-content > #"+modal_id).modal('show');
            //console.log($("#"+modal_id)); 
        },

        error: function(response) {
            console.log(response);
        }
    });
}


/*
* Vraca podatke sa prosledjenog urla u obliku tabelarnog reda i smesta ih u tbody deo.
*/
function loadTableData(url,id=null) {

    if (id !== null) {
        var table = '#' + id;
    } else {
        var table = 'table';
    }

    $(table + ' > tbody').empty();

    $.ajax({
        type: 'get',
        url : url ,
        dataType: 'html' 
      
    }).done(function (data) {
         $(table + ' > tbody').html(data);  
    }).fail(function (data) {
         $(table + ' > tbody').html('<tr><td colspan="100%" align="center">The data could not be found</tr>');
    });

}


/*
* Vraca podatke sa prosledjenog urla i smesta ih u div ciji je id prosledjen kao parametar.
*/
function loadDivData(url,id) {

    $('#'+ id).html('');

    $.ajax({
        type: 'get',
        url : url ,
        dataType: 'html' 
      
    }).done(function (data) {
        
        $('#'+id).html(data); 

        // Fade in 
        $("#"+id).fadeIn("fast");

    }).fail(function (data) {
        //console.log(data);
        $('#'+id).html('<i>The data could not be found</i>');
    });

}


// OVO NE RADI - TREBA SREDITI
// Funkcija za setovanje lokacije (drzave) koja je oznacena kao aktivna    
function setActiveLocation() {

    $.ajax({
     
            type : 'get',
            url : $('#location_box').attr('url'), //'locations/country',
            dataType: 'json',

            success:function(response){
                console.log(response);
               
                //$('#location_box').contents(':not("#img_loc")').remove();
                $('#location_box > #loc_name').html('');

                if(response.country_name != undefined) {
                    $('#location_box > #loc_name').html('&nbsp;'+response.country_name);
                    //$('#img_loc').after('&nbsp;' + response.country_name);  
                } else {
                     $('#location_box > #loc_name').html('&nbsp;No location selected');
                    //$('#img_loc').after('&nbsp;' + 'No location selected'); 
                }
        
            },

            error: function(response){
                console.log(response);
            },
        });
} 



/*
*  Anonimus funkcija, omogucava funkcionisanje pagination layera za ajax
*/
 $(function() {
        $('tbody').on('click', '.pagination a', function(e) {
            e.preventDefault();
            //$('tbody').append('<img style="position: width="15px" absolute; left: 50%; top: 50%; z-index: -100000;" src="<?php  echo asset('images/proccessing.gif'); ?>" />');

            var url = $(this).attr('href');  
            loadTableData(url);
            window.history.pushState("", "", url);
        });

});


/*
*  Prikazuje notifikaciju u zavisnosti od prosledjenog argumenata tipa notifikacije i poruke koju je potrebno da prikaze 
*/
function showNotification(a_type, a_message) {

 	$.notify({
        // options
        message: a_message 
    },
    {
        // settings
        type: a_type,
        offset: 20,
        spacing: 10,
        z_index: 1031,
        delay: 1000,
        timer: 1000,
        url_target: '_blank',
        mouse_over: null,
        placement: {
            from: "top",
            align: "center"
        },
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
    });
}


    // Funkcija za pripremu i prikaz gresaka prilikom validacije forme
    function showValidationErrors(response) {

        var data = response.responseJSON;
        
        $.each(data.errors, function(index,val){

            // Dodajem crveni okvir
            $('#'+index).addClass('is-invalid');
            $('#f_'+index + '> .invalid-feedback').remove();
            $('#f_'+index).append('<div class="invalid-feedback">'+val+'</div>');
        });
    }


    // Funkcija za pronalazenje i prikaz trazenog podatka

    function liveSearch(a_val,a_url) {

	    $.ajax({
	     
	        type : 'get',
	        url : a_url,
	        dataType: 'html',
	        data:{'search':a_val},

	        success:function(data){
	            $('tbody').html(data);  
	    
	        }
 
    });


    // Funckcija za setovanje stavke menija aktivnim    
    /*function setActiveMenu(menu_id, li_id, class_rem, class_add){

        $("#"+menu_id +  "> li").each(function( index ) {
            $(this).addClass(class_rem);
        });

        $("#"+li_id).addClass(class_add);
    }*/


}