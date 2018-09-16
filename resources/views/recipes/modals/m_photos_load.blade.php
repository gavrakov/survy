 <?php $photos = $recipe->photos()->get(); ?>

<form id="upd_f" role="form" enctype="multipart/form-data" method="POST" action="">
    <input id="photo" name="photo" type="text" class="form-control" name="name" value="" hidden >

 @foreach ($photos as $photo)
    <!-- photos -->
    
    <div class="img_holder">
        <img class="img_object" 

            name="{{$photo->id}}" src="

            <?php
                        $path = 'storage/photos/recipes/' . $photo->dir .  '/thumbs/300_' . $photo->name;
                        echo asset($path);
            ?>"
        >
        <div class="overlay">
       
            <button name="cover_{{$photo->id}}" type="button" class="btn btn-default btn-circle btn-lg" onClick="cover('{{ route('recipes.updcover',['id' => $recipe->id]) }}','{{$photo->id}}');" style="margin-top:50px; margin-left:30px"><i class="fa fa-check"></i></button>
            <button name="destroy_{{$photo->id}}" type="button" class="btn btn-danger btn-circle" onClick="destroy('{{ route('recipes.destroyphoto',['id' => $recipe->id]) }}','{{$photo->id}}');" align="center" style="margin-top:50px; margin-left:5px;""><i class="fa fa-times"></i></button>

        </div>


        @if ($photo->cover == 1)
                
             <span type="button" class="btn btn-primary btn-circle btn-sm" style="
                        margin: 0;
                        position: absolute;
                        bottom: -6px;
                        right: -6px;
                        opacity: 1;
                        z-index: 10;

             "><i class="fa fa-check"></i></span>
                       
        @endif
    </div>
@endforeach

</form>


<script type="text/javascript">
    

    // Update cover photo
    function cover(a_url,id) {

        var form = $('#upd_f');

        // Dodavanje url-a
        form.attr('action',a_url);

       $("input[name=photo]").val(id);


        $.ajax({
            headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
            type: 'put',
            url: form.attr("action"),
            dataType: 'json',
            data: form.serialize(),

            success: function(response) {

                // Load all photos.
                loadDivData('{{ route("recipes.modalphotosload",["id" => $recipe->id]) }}',"photos_list");

                form[0].reset();

                console.log(response);
            },

            error: function(response) {

                // Prikaz notifikacije
                //showNotification('danger', 'The grocery could not be deleted');

                console.log(response);
            }

        });

    }


    // Update cover photo
    function destroy(a_url,id) {

        var form = $('#upd_f');

        // Dodavanje url-a
        form.attr('action',a_url);

       $("input[name=photo]").val(id);


        $.ajax({
            headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
            type: 'put',
            url: form.attr("action"),
            dataType: 'json',
            data: form.serialize(),

            success: function(response) {

                // Load all photos.
                loadDivData('{{ route("recipes.modalphotosload",["id" => $recipe->id]) }}',"photos_list");

                form[0].reset();

                console.log(response);
            },

            error: function(response) {

                console.log(response);
            }

        });

    }


</script>

