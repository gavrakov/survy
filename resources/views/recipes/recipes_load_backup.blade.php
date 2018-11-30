    @if (isset($recipes))
    	@foreach ($recipes as $recipe)

    		<tr>
                
                <td class="align-middle" width="20%"> <a href="<?php echo route("recipes.show",['id' => $recipe->id]); ?>">

                    <img style="position:relative; width:60px;  border-radius:100%; padding: 2px; border:1px #888888 solid"

                    src="{{asset($recipe->cover_link_sm())}}"
                    
                    style="position:relative; border-radius:3%; border:1px"></a>

               
                </td>
                <td class="align-middle" width="20%"><h6>{{$recipe->name}}</h6></td>
                <td class="align-middle" width="20%">
           
            
                    @foreach($recipe->categories()->get() as $category)

                        @if($category['name'] == 'Breakfast')
                            <span class="badge badge-success p-1">
                        @elseif($category['name'] == 'Lounch')
                            <span class="badge badge-info p-1">
                        @elseif($category['name'] == 'Dinner')
                             <span class="badge badge-warning p-1">
                        @elseif($category['name'] == 'Soup')
                             <span class="badge badge-light p-1">
                        @elseif($category['name'] == 'Salad')
                             <span class="badge badge-default p-1">
                        @elseif($category['name'] == 'Dessert')
                             <span class="badge badge-danger p-1">
                        @endif
                        {{$category['name']}}
                        </span>    
                    @endforeach
                  
                </td>

                <!-- Recipe price -->
                @if (session()->has('location'))
                    <td class="align-middle" width="20%">{{number_format((float)$recipe->getTotalPrice(), 2, '.', '')}}</td>
                @endif

                <!-- Ovo srediti -->
                <td class="align-middle" width="10%">
                    <button class="btn btn-light btn-sm"><i class="fa fa-edit fa-fw"  onClick="window.location.replace('{{route('recipes.show',['id' => $recipe->id])}}');"></i>&nbsp;Edit</button>
                </td>
                <td class="align-middle" width="10%">
                    <span class="btn btn-default btn-sm" id="del_{{$recipe->id}}" onClick="deleteRecipe('{{ route('recipes.destroy',['id' => $recipe->id]) }}');" ><i class="fas fa-trash"></i>&nbsp;</span>
                </td>
                <!--td><i class="fa fa-edit fa-fw"></i></td-->
            </tr>
    	@endforeach
            <tr class="align-middle"><td colspan="100%" align="center">{{ $recipes->links() }}</td></tr>         
    @endif

