@php $photo = $recipe->cover()->get(); @endphp

<!-- Modal edit photos -->
<div id="m_cover" class="modal fade">
  <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit cover</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                   
                <div id="cover_holder" class="">
                        <img id="cover_photo" name="cover" src="{{asset($photo[0]->link())}}" alt="{{$recipe->name}}">
                </div>

                {{ csrf_field() }}
                <div class="form-group">

                    <!--input type="file" id="photo_upload" name="photos[]" multiple / -->
                     
                </div>


            </div>
            <div class="modal-footer">
                <button id="btn_save" data-dismiss="modal" type="button" name="btn_save" class="btn btn-md btn-info">Save</button>
                <button id="btn_close" data-dismiss="modal" type="button" name="btn_close" class="btn btn-md btn-secondary">Close</button>
            </div>
        </div>
  </div>  
</div>


<!-- File upload -->
<script type="text/javascript">

     // On close modal recipe_cover
        $("#m_cover").on('hidden.bs.modal', function () {
            loadDivData('{{ route("recipes.loadphotos",["id" => $recipe->id]) }}',"photos");
        })


    $(document).ready(function(){

        // Croppie settings
        $('#cover_photo').croppie({
            enableExif: true,
            viewport: {
                width: 320,     // Sirina srednjeg thumbnaila
                height: 320,    // Visina srednjeg thumbnaila
                
            },
            boundary: {
                width: 600,
                height: 600
            }
        });


        // Crop and upload
        $('#btn_save').on('click', function (ev) {     

            $('#cover_photo').croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                $.ajax({
                    headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
                    url: "{{route('recipes.cover.crop',['id' => $recipe->id])}}",
                    type: "POST",
                    data: {"image":resp},
                    success: function (response) {

                        // Force to reload the photo.
                        var d = new Date();

                        html = ' <div class="card-img p-2"> <img style="position:relative;  #888888 solid; border-radius:1%;" width="100%" src="' + response.photo + '?' + d.getTime() +'"></div>'

                        $("#recipe_cover").html(html);

                    },
                    errors: function(response){
                        console.log(response)
                    }
                });
            });
        });  

    });


</script>
