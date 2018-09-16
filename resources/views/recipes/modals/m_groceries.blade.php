<?php $recipe = $data['recipe']; ?>
<?php $groceries = $data['groceries']; ?>


<!-- Modal edit photos -->
<div id="m_groceries" class="modal fade">
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit recipes groceries</h3>
            </div>
            <div class="modal-body">
               
                    <div id='errors' name="errors">
                        <!--ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul-->
                    </div>
                    

                    <!-- Search -->
                    <div class="input-group custom-search-form pull-right" style="width:30%; margin-bottom: 20px;">
                                <input type="text" id="search" name="search" class="form-control" placeholder="Search..." style="width:100%;">
                                <!--span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                                </span-->

                    </div>


                    <!--- List of all groceries -->
                    <br>
                 
                    <div id="groceries_list" class="pre-scrollable" url="" style="width:100%; height:250px; border:1px solid #efefef;">

                        <form name="f_add_groceries" id="f_add_groceries" type="post" action="{{ route('recipes.addgrocery',['id' => $recipe->id]) }}">
                                <input name="f_grocery" id="f_grocery" type="text" class="form-control" value="" hidden>
                                <input name="f_quantity" id="f_quantity" type="text" class="form-control" value="" hidden>
                        </form>

                        <table id="groceries" class="table">
                            <tbody>
                                    <!-- Load groceries - Ajax -->
                            </tbody>
                        </table>
                    </div>
                    
                    <!--hr-->


                    <!--- List of recipes groceries -->
                
                    <div id="recipes_groceries_list" class="pre-scrollable" url="" style="height:250px; border:1px solid #efefef; margin-top: 20px;">
                        
                        <table id="basket" class="table">
                            <tbody>
                                <!-- Load basket - Ajax -->
                            </tbody>
                        </table>

                    </div>

                   

            </div> <!-- Modal body - end -->

        </div> <!-- Modal content - end -->

  </div>  <!-- Modal dialog - end --> 

</div> <!-- Modal - end -->


<!-- File upload -->
<script type="text/javascript">


    $(document).ready(function(){

        // Load groceries
        loadTableData('{{ route("recipes.groceriesload",["id" => $recipe->id]) }}','groceries');
     
        // Load inserted groceries
        loadTableData('{{ route("recipes.basketload",["id" => $recipe->id]) }}','basket');

        // Close modal edit photos event
       /* $('#m_photos').on('hide.bs.modal', function(){
            loadDivData('{{ route("recipes.loadphotos",["id" => $recipe->id]) }}',"photos");
        });*/

    });




    // Brise div sa greskama u koliko div postoji
    if($("#btn_edit_photos").length) {
            $("#btn_edit_photos").click(function(){
                $("#poruka").empty();
        
        });
    }


    $(function(){

        var photos = $('#photos_list'); 

        $("#photo_upload").fileupload({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
            type: 'post',
            url: '{{ route('recipes.upload',['id' => $recipe->id]) }}',
            dropZone: "#drop_zone",
            dataType: 'json',
            autoUpload: false

        }).on('fileuploadadd', function(e, data){

          
            var fileTypeAllowed = /.\.(gif|jpeg|jpg|png)$/i;
            var fileName = data.originalFiles[0]['name'];
            var fileSize = data.originalFiles[0]['size'];

             // Div za prikaz gresaka
            var poruka = $('#poruka');
            // Dodavanje klase za prikaz gresaka
            poruka.addClass('has-error');

            // Brisanje prethodnih gresaka
            poruka.empty();

            poruka.append('<span class="help-block"><p class="small"></p></span>');


            // Provera ekstenzije
            if (!fileTypeAllowed.test(fileName)){
                $('#poruka .help-block').append('File: ' + fileName);
                console.log('Only jpeg, jpg, png and gif images are allowed');
                $('#poruka .help-block').append(' - Only jpeg, jpg, png and gif images are allowed<br>');

            // Provera velicine    
            } else if (fileSize > 800000) {
                $('#poruka .help-block').append('File: ' + fileName);
                console.log('Maximum allowed size for an image is 8MB');
                $('#poruka .help-block').append(' - Maximum allowed size for an image is 2MB<br>');

            // Uploadovanje
            } else {
                data.submit();
            }

  
        // Upload is done    
        }).on('fileuploaddone', function(e,data) {

                // Success
                if(data.result.success == true) {

                    // Ucitava fotke u modalu fotografija
                    loadDivData('{{ route("recipes.modalphotosload",["id" => $recipe->id]) }}',"photos_list");

                    // Ucitava fotke na stranici recepta
                    //loadDivData('{{ route("recipes.loadphotos",["id" => $recipe->id]) }}',"photos");

                // Fail    
                } else {

                    // Ime fajla koji nije uploadovan
                    var file_name = data.files[0].name;
                    // Greske
                    var errors = data.result.errors;
                    
                    $('#poruka .help-block').append('File: ' + file_name);

                    for (var i in errors) {
                        //console.log(errors[i]);
                         $('#poruka .help-block').append(' - ' + errors[i] + '<br>');
                    }
                        
                }


        // Progress
        }).on('fileuploadprogressall', function(e,data) {

            var progress = parseInt(data.loaded / data.total * 100, 10);
            $("#progress").html("Progress: " + progress + "%");
            //console.log(data);
        });
    });


</script>
