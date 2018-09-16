    @if (isset($recipes))
    	@foreach ($recipes as $recipe)

    		<tr>
                
                <td> <a href="<?php echo route("recipes.show",['id' => $recipe->id]); ?>">

                    <img width="60px" src="<?php 

                    // Vraca collection of object
                    $photo = $recipe->cover()->first();

                    $path = 'storage/photos/recipes/' . $photo['dir'] .  '/thumbs/150_' . $photo['name'];
                    
                    echo asset($path);
                    
                    ?>" style="position:relative; border-radius:3%; border:1px"></a>

               
                </td>
                <td>{{$recipe->name}}</td>
                <td>
                    <!-- Ovo srediti -->
                    <?php $counter = 0; ?>
                    @foreach($recipe->categories()->get() as $category)
                        <?php if($counter != 0) {echo ",";} ?>
                        {{$category['name']}}

                        <?php $counter++ ?>
                    @endforeach
                </td>

                <!-- Recipe price -->
                @if (session()->has('location'))
                    <td>{{number_format((float)$recipe->getTotalPrice(), 2, '.', '')}}</td>
                @endif

                <!-- Ovo srediti -->
                <td><span class="btn btn-default btn-sm"><i class="fa fa-edit fa-fw"  onClick="window.location.replace('{{route('recipes.show',['id' => $recipe->id])}}');"></i>&nbsp;Edit recipe</span></td>
                <td><span class="btn btn-danger btn-sm" id="del_{{$recipe->id}}" onClick="deleteRecipe('{{ route('recipes.destroy',['id' => $recipe->id]) }}');" ><i class="glyphicon glyphicon-remove"></i>&nbsp;Delete</span></td>
                <!--td><i class="fa fa-edit fa-fw"></i></td-->
            </tr>
    	@endforeach
            <tr><td colspan="100%" align="center">{{ $recipes->links() }}</td></tr>         
    @endif
