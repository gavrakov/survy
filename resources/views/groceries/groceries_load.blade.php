    @if (isset($groceries))
    	@foreach ($groceries as $grocery)

    		<tr>
                <td>
                    <img src="<?php 

                    // Vraca collection of object
                    $icon = $grocery->category()->first()->icon;

                    // Ovo srediti
                    $path = 'storage/icons/groceries/' . $icon;
                    
                    echo asset($path);
                    
                    ?>"" >
                  
                </td>   
                <td>{{$grocery->name}}</td>
                <td>{{$grocery->category()->first()->name}}</td>
                <td>{{$grocery->unite()->first()->unite}}</td>
                <td>{{$grocery->quantity}}</td>

                @if (session()->has('location'))  
                    <td>{{$grocery->GroceriesPrices()->first()['price']}}</td>
                @endif

                <td><span id="edt_{{$grocery->id}}" onClick="showEditModal('{{ route('groceries.edit',['id' => $grocery->id]) }}','edit');" class="btn btn-default btn-sm"><i class="fa fa-edit fa-fw"></i>&nbsp;Edit</span></td>
                <td><span id="del_{{$grocery->id}}" onClick="delGrocery('{{ $grocery->id }}');"  class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i>&nbsp;Delete</span></td>
            </tr>
    	@endforeach
            <tr><td colspan="100%" align="center">{{ $groceries->links() }}</td></tr>         
    @endif
