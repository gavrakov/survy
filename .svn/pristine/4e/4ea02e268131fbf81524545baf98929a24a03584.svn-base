@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><p class="fa fa-book">&nbsp;Recipes</p></div>
            <div class="panel-body">
            	<div class="table-responsive">
                      
                        <span id="create_recipe" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-plus"></i>&nbsp; Create new</span>
                        
                        <div class="input-group custom-search-form pull-right" align="center" style="width:15%;">
                                <input width="150px" type="text" id="search" name="search" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <!--button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button-->
                                </span>
                        </div>
                        <hr>
                        <table id="recipes" class="table">
                            <thead>
                                <tr>
                                    
                                    <th width="30%">Photo</th>
                                    <th width="30%">Name</th>
                                    <th width="10%">Category</th>

                                    @if($location != null)
                                        <th width="10%">Price <small class='text-danger'>({{$location->currency}})</small></th>
                                    @endif

                                    <th width="10%">&nbsp;</th>
                                    <th width="10%">&nbsp;</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">


$(document).ready(function(){

    // Load all recipes
    loadTableData('{{URL::to('recipes/load')}}');

    // Modal Create/Edit
    $('#create_recipe').on('click',function(){
        showEditModal('{{ route('recipes.create') }}','create'); 
    });


});


 // Create and Edit grocery

function showEditModal(a_url,modal_id) {

    $.ajax({

        headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
        type: 'get',
        url: a_url,
        dataType: 'html',

        success: function(response) {
            
            $("#"+modal_id).remove();
            $('#page_content').append(response);
            $("#"+modal_id).modal('show');
            
        },

        error: function(response) {
            //console.log(response);
        }
    });
}


 // Delete recipe
function deleteRecipe(url) {
 
    $.ajax({
        headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
        type: 'get',
        url: url,
        dataType: 'html',

        success: function(response) {

            // Prikaz notifikacije
            showNotification('success', 'The recipe was succcessfully deleted');

            // Load all groceries.
            loadTableData('{{URL::to('recipes/load')}}');

            console.log(response);
        },

        error: function(response) {

            // Prikaz notifikacije
            showNotification('danger', 'The recipe could not be deleted');

            console.log(response);
        }

    });
   
}



/* 
* Save recipe  
*/
 function save(modal_id) {

    var name = $("#name");
    var category = $("#category");
    var persons = $("#persons");
    var form = $("#create_f");


    $.ajax({
        headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
        type: 'post',
        url: form.attr("action"),
        dataType: 'json',
        data: form.serialize(),

        success: function(response) {

            console.log(response[1]);

            // Form reset
            form[0].reset();

            //showNotification('success', 'The recipe succcessfully saved');

            $("#" + modal_id).modal('hide');

            var url_redirect = '{{URL::to('recipes/show')}}'; 

            window.location.replace(url_redirect + '/' + response[1]);

       },

        error: function(response) {
            //console.log(response);
            // Show errores
            showValidationErrors(response);
        }  

    });

}



// Pagination

$(function() {
    $('tbody').on('click', '.pagination a', function(e) {
        e.preventDefault();
        //$('tbody').append('<img style="position: width="15px" absolute; left: 50%; top: 50%; z-index: -100000;" src="<?php  echo asset('images/proccessing.gif'); ?>" />');

        var url = $(this).attr('href');  
        getRecipes(url);
        window.history.pushState("", "", url);
    });

    function getRecipes(url) {
        $.ajax({
            type: 'get',
            url : url ,
            dataType: 'html' 
        }).done(function (data) {
            $('tbody').html(data);  
        }).fail(function () {
            alert('Recipes could not be loaded.');
        });
    }
});



// Live search 
$('#search').on('keyup',function(){
  
    $value=$(this).val();
     
    $.ajax({
     
        type : 'get',
        url : '{{URL::to('recipes/search')}}',
        dataType: 'html',
        data:{'search':$value},
        success:function(data){

            console.log(data);
            $('tbody').html(data);  
            
        }
 
    });
 
})
 
</script>
 

<script type="text/javascript">
 
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
 
</script>

@endsection
