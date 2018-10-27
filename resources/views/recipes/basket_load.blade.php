
<?php $recipe = $data['recipe']; ?>
<?php $insgroceries = $data['insgroceries']; ?>
<?php $location = $data['location']; ?>
<?php $total_price = 0; ?>

@if(!empty($insgroceries) && count($insgroceries)!==0)
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

        <td width="40%" style="vertical-align: center">{{$ins_grocery->getGroceryName()}}</td>
        <td width="20%" style="vertical-align: center">{{$ins_grocery->quantity}}&nbsp;{{$ins_grocery->getGroceryUnite()}}</td>

        @if ($location !== null)  
                 <td width="20%" style="vertical-align: center">{{ number_format((float)$ins_grocery->calculateGroceryPrice(), 2, '.', '')}}</td>
        @endif
        
    </tr>
        
    @endforeach

    <tr>
        <td colspan="3" align="right">
            Total price:
        </td>
        <td>
            @if($location !== null)
                <strong>{{ number_format((float)$recipe->getTotalPrice(), 2, '.', '')}}</strong> 
                <small class='text-danger'>{{$location->currency}}</small>
            @else
                0.00
            @endif
        </td>

    </tr>


@else
    <tr>
        <td colspan="4" style="border:none;"><i>No groceries found, please add some groceries to the recipe...</i></td>
    </tr>
@endif


