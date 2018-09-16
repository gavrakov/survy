<?php $recipe = $data['recipe']; ?>
<?php $groceries = $data['groceries']; ?>

<!-- Modal edit photos -->
<div id="m_groceries" class="modal fade">
  <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit recipes groceries</h3>
            </div>
            <div class="modal-body">
               
                <!-- Checking for errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div id="search_row" class="row">

                    <!-- Search -->
                    <div class="input-group custom-search-form pull-left" style="width:15%;">
                                <input width="150px" type="text" id="search" name="search" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                                </span>
                    </div>

                </div>

               
                   
                <!--- List of all groceries -->
                <div id="groceries_row" class="row">
                    <div id="groceries_list" class="pre-scrollable" url="" style="height:300px">
                         
                        @if(!empty($groceries))
                            @foreach($groceries as $grocery)

                            <!-- OVO MORAM DA SREDIM -->
                            <div class="grocery_holder">

                                 <img class="icon_object" src="<?php 

                                    // Vraca collection of object
                                    $icon = $grocery->category()->first()->icon;

                                    // Ovo srediti
                                    $path = 'storage/icons/groceries/' . $icon;
                    
                                    echo asset($path);
                    
                                    ?>"" >
                  
                                    
                                    <p><i>{{$grocery->name}}</i></p>


                                    <!--span type="button" class="btn btn-default btn-circle btn-xs" style="
                                    margin: 0;
                                
                                    left:35px;
                                    position: absolute;
                                    bottom:-12px;
                                    opacity: 1;
                                    z-index: 10;
                                    width: 30px;
                                    height: 30px;

                                    "><i class="fa fa-plus"></i></span-->
                                    <div class="input-group custom-search-form btn-xs">
                                        <input type="text" class="form-control" >
                                        <span class="input-group-btn">
                                            <button class="btn btn-outline btn-primary" type="button">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </span>
                                    </div>
                               
                            </div>

                                <!--div class="col-md-2" style="padding:5px">
                                <div class="card" style="border:1px solid #efefef">
                                      <img class="card-img-top" alt="Card image cap"
                                        src="<?php 

                                        // Vraca collection of object
                                        $icon = $grocery->category()->first()->icon;

                                        // Ovo srediti
                                        $path = 'storage/icons/groceries/' . $icon;
                        
                                        echo asset($path);
                        
                                        ?>"
                                      >
                                      <div class="card-body">
                                        <h5 class="card-title">{{$grocery->name}}</h5>
                                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        <a href="#" class="btn btn-default btn-circle btn-xs"><i class="fa fa-plus"></i></a>
                                        
                                      </div>
                                </div>
                            </div-->
                                
                            @endforeach
                        @endif 

                    </div>
                </div>

              


                <!-- List of all groceries that are in the recipe -->   
                <div id="recipe_groceries_list" class="pre-scrollable" url="" style="height:200px">
                    &nbsp;
                </div>


            </div>

            
            <div class="modal-footer">
                 
            </div>
        </div>
  </div>  
</div>


<!-- File upload -->
<script type="text/javascript">


    $(document).ready(function(){
     
        // Load all photos
        loadDivData('{{ route("recipes.modalphotosload",["id" => $recipe->id]) }}',"photos_list");

        // Close modal edit photos event
        $('#m_photos').on('hide.bs.modal', function(){
            loadDivData('{{ route("recipes.loadphotos",["id" => $recipe->id]) }}',"photos");
        });

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
