 <?php $photos = $recipe->photos()->get(); ?>



<form id="upd_f" role="form" enctype="multipart/form-data" method="POST" action="">
    <input id="photo" name="photo" type="text" class="form-control" name="name" value="" hidden >

    <div class="card-columns-photos">

         @foreach ($photos as $photo)

            <!-- photos -->
            <div class="card m-1" style="width:150px;">

                <img class="card-img-top" name="{{$photo->id}}" src="{{asset($photo->link_sm())}}">

                <!--div class="card-body text-center p-1"-->
                <div class="card-img-overlay p-0 text-center">
                    <div style="display:block; background-color: rgba(255,255,255,0.5); padding:3px;">
                    <button name="cover_{{$photo->id}}" type="button" 
                        @if ($photo->cover == 1) 
                            class="btn btn-primary btn-circle"
                        @else
                            class="btn btn-default btn-circle"
                        @endif 
                        onClick="cover('{{ route('recipes.updcover',['id' => $recipe->id]) }}','{{$photo->id}}');"><i class="fa fa-check"></i></button>
                    <button name="destroy_{{$photo->id}}" type="button" class="btn btn-danger btn-circle" onClick="destroy('{{ route('recipes.destroyphoto',['id' => $recipe->id]) }}','{{$photo->id}}');"><i class="fa fa-times"></i></button>   
                    </div> 
                </div>
            </div>

        @endforeach

    </div>

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

