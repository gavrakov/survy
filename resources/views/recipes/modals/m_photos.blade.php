<?php $photos = $recipe->photos()->get(); ?>

<!-- Modal edit photos -->
<div id="m_photos" class="modal fade">
  <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit photos</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
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
                   
                <div id="drop_zone" style="border: 2px dashed #eee; padding: 30px 160px; margin-bottom:10px;">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Drag & drop photos for your recipe</label>
                            
                            <input type="file" id="photo_upload" name="photos[]" multiple />
                             
                        </div>
                        <div id="progress"></div>
                        
                </div>

                <div id="poruka">
                    @foreach($photos as $key => $photo)
                        @if ($errors->has('photos_'. $key))
                            <span class="help-block">
                                {{ $errors->first('photos_'. $key) }}
                            </span>
                        @endif

                    @endforeach
                </div>



                <!-- List of all recipes photos -->   
                <div id="photos_list" class="pre-scrollable" url="">
                   
                </div>


            </div>
            <div class="modal-footer">
                 <button id="btn_close" data-dismiss="modal" type="button" name="btn_close" class="btn btn-md btn-secondary">Close</button>
            </div>
        </div>
  </div>  
</div>


<!-- File upload -->
<script type="text/javascript">


    $(document).ready(function(){
     
        // Load all photos
        loadDivData('{{ route("recipes.photos.load",["id" => $recipe->id]) }}',"photos_list");

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
            url: '{{ route('recipes.photos.upload',['id' => $recipe->id]) }}',
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
            } else if (fileSize > 8000000) {
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
                    loadDivData('{{ route("recipes.photos.load",["id" => $recipe->id]) }}',"photos_list");


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
