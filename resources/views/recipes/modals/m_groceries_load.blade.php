<?php $recipe = $data['recipe']; ?>
<?php $groceries = $data['groceries']; ?>

 @if(!empty($groceries))
    @foreach($groceries as $grocery)

    <tr id="{{$grocery->id}}_row">
    
        <td width="10%">
            <img class="icon_object" src="<?php 

            // Vraca collection of object
            $icon = $grocery->getCategoryIcon();

            // Ovo srediti
            $path = 'storage/icons/groceries/' . $icon;

            echo asset($path);

            ?>"" >
        </td>
        <td width="30%">{{$grocery->name}}</td>
        <td width="20%">{{$grocery->getCategoryName()}}</td>
        <td width="10%"><input name="f_{{$grocery->id}}_q" id="f_{{$grocery->id}}_q" type="text" class="form-control" value="" required autofocus></td>
        <td width="10%">{{$grocery->getUnite()}}</td>
        <td width="10%">{{$grocery->getPrice()}}</td>
        <td width="10%">
            <button type="button" class="btn btn-default btn-circle" id="add_{{$grocery->id}}"" onClick="addGrocery('{{ $grocery->id }}'); "><i class="fa fa-plus"></i> 
        </td>
   
    </tr>
        
    @endforeach

    <tr><td colspan="100%" align="center">{{ $groceries->links() }}</td></tr> 

@endif 


<!-- Groceries load -->
<script type="text/javascript">

    // Add grocery to a recipe
    function addGrocery(id) {
        
    
        // Setovanje forme
        var form = $("#f_add_groceries");

        // Setovanje kolicine
        $("#f_quantity").val($("#f_" + id + '_q').val());

        // Setovanje namirnice
        $("#f_grocery").val(id);

        // Brise prethodne greske
        $('#errors' + '> span').remove();


        // DODATI VREDNOSTI KOJE SE SALJU - KOLICINA, ID NAMIRNICE

        $.ajax({
        headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
        type: 'post',
        url: form.attr("action"),
        dataType: 'json',
        data: form.serialize(),

            success: function(response) {

                // Brise namirnicu iz korpe u koliko je dodata u recept
                $('#'+response.relation['grocery_id'] + '_row').remove();

                // Setovanje kolicine
                $("#f_quantity").val('');

                // Setovanje namirnice
                $("#f_grocery").val('');
                $("#f_" + id + '_q').val('');

                $('#errors').removeClass('has-error');
                $('#errors' + '> div').remove();


                // Load all groceries.
                loadTableData('{{ route("recipes.modalbasketload",["id" => $recipe->id]) }}','basket');

                console.log(response);
            },

            error: function(response) {

                // Prikaz gresaka
                var data = response.responseJSON;

                console.log(response);

                $.each(data.errors, function(index,val){

                    console.log(val);
                    // Dodajem crveni okvir
                    $('#errors').addClass('has-error');
                    // Brisem span ako postoji
                    $('#errors' + '> div').remove();
                    // Dodajem span kako bih prikazao gresku
                    $('#errors').append('<div class="invalid-feedback d-block">'+val+'</div>');
                });

                //console.log(response);
            }

        });
    }



</script>