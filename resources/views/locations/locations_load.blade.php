    @if (isset($locations))
    	@foreach ($locations as $location)

    		<tr> 
                <td>{{$location->country()->first()->country_name}}</td>
                <td>{{$location->country()->first()->currency}}</td>
                <td><input type="radio" name="f_activ" id="f_activ" value="{{$location->id}}" onClick="setActive('{{route('locations.update',['id' =>$location->id])}}');" 
                    <?php if ($location->active == 1)  {
                        echo "checked disabled";

                    } 
                    ?>
                >
                </td>
                <td align="center"><span id="del_{{$location->id}}" onClick="deleteLocation('{{ route('locations.destroy',['id' => $location->id]) }}');" class="btn btn-default btn-sm" ><i class="fas fa-trash"></i></span></td>
            </tr>
    	@endforeach

        @if($locations->links() != '')
            <tr><td colspan="100%" align="center">{{ $locations->links() }}</td></tr>    
        @endif     
    @endif
