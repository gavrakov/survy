    @if (isset($groceries))
    	@foreach ($groceries as $grocery)

    		<tr>
                <td class="align-middle">
                    <!--div style="position:relative; width:55px; height:55px; border-radius:100%; padding: 10px; border:1px #888888 solid"-->
                        <img class="ml-2" src="<?php 

                        // Vraca collection of object
                        $icon = $grocery->category()->first()->icon;

                        // Ovo srediti
                        $path = 'storage/icons/groceries/' . $icon;
                        
                        echo asset($path);
                        
                        ?>"" >
                    <!--/div-->
                  
                </td>   
                <td class="align-middle">{{$grocery->name}}</td>
                <td class="align-middle">{{$grocery->category()->first()->name}}</td>
                <td class="align-middle">{{$grocery->unite()->first()->unite}}</td>
                <td class="align-middle">{{$grocery->quantity}}</td>

                @if (session()->has('location'))  
                    <td>{{$grocery->GroceriesPrices()->first()['price']}}</td>
                @endif

                <td class="align-middle text-center">
                    <button id="edt_{{$grocery->id}}" onClick="showModal('{{ route('groceries.edit',['id' => $grocery->id]) }}','edit');" class="btn btn-light btn-sm"><i class="fa fa-edit fa-fw"></i>&nbsp; Edit</button>
                </td>
                <td class="align-middle text-center">
                    <span id="del_{{$grocery->id}}" onClick="delGrocery('{{ route('groceries.destroy',['id' => $grocery->id]) }}');"  class="btn btn-default btn-sm"><i class="fas fa-trash"></i></span>
                </td>
            </tr>
    	@endforeach

            <tr><td colspan="100%" align="center">{{ $groceries->links() }}</td></tr>         
    @endif

