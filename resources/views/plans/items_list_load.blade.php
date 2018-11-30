@if (isset($list))

    	@foreach ($list as $l)

        <tr>
          
            <td class="align-middle">
                {{$l->grocery()->first()->name}}
            </td>
            <td class="align-middle">
                {{$l->quantity}}
            </td>
            <td class="align-middle">
                {{$l->price}}
            </td>
        </tr>


        @endforeach     
@endif
