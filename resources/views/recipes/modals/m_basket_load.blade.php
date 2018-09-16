
<?php $recipe = $data['recipe']; ?>
<?php $insgroceries = $data['insgroceries']; ?>
<?php $location = $data['location']; ?>
<?php $total_price = 0; ?>

@if(!empty($insgroceries))
    @foreach($insgroceries as $ins_grocery)
        
    <tr>
        <td width="20%">
            <img class="icon_object" src="<?php 

            // Vraca collection of object
            $icon = $ins_grocery->getGroceryCategoryIcon();

            // Ovo srediti
            $path = 'storage/icons/groceries/' . $icon;

            echo asset($path);

            ?>"" >
        </td>


        <td width="20%" style="vertical-align: center">{{$ins_grocery->getGroceryName()}}</td>
        <td width="20%" style="vertical-align: center">{{$ins_grocery->getGroceryCategory()}}</td>
        <td width="10%" style="vertical-align: center">{{$ins_grocery->quantity}}</td>
        <td width="10%" style="vertical-align: center">{{$ins_grocery->getGroceryUnite()}}</td>

        @if ($location !== null)  
                    <td width="10%" style="vertical-align: center">{{ number_format((float)$ins_grocery->calculateGroceryPrice(), 2, '.', '')}}</td>
        @endif
        
        <td width="10%" style="vertical-align: center"><button type="button" id="del_{{$ins_grocery->grocery_id}}" onClick="delGrocery('{{ route('recipes.delgrocery',['id' => $ins_grocery->id]) }}'); " class="btn btn-default btn-circle"><i class="fa fa-times"></i>
        </td>
    </tr>
        
    @endforeach
@endif

<tr>
    <!--td colspan="50%" align="right">&nbsp;Total price:</td-->
    <td colspan="6" align="right">
        @if($location !== null)
        <p> 
            <b>&nbsp;Total price: {{ number_format((float)$recipe->getTotalPrice(), 2, '.', '')}}  
                <small class='text-danger'>{{$location->currency}}</small>
            </b>
        </p>
        @endif
    </td>
    <td>&nbsp;</td>
</tr>





<!-- Remove groceries from the recipe -->
<script type="text/javascript">


     function delGrocery(url) {

        // Brise prethodne greske
        $('#errors' + '> span').remove();

        $.ajax({
        headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
        type: 'post',
        url: url,
        dataType: 'json',
        

            success: function(response) {

                // Load groceries
                loadTableData('{{ route("recipes.modalgroceriesload",["id" => $recipe->id]) }}','groceries');

                // Load basket.
                loadTableData('{{ route("recipes.modalbasketload",["id" => $recipe->id]) }}','basket');

                console.log(response);
            },

            error: function(response) {

            }

        });
    }

</script>   