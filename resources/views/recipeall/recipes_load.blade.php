@php 

    $recipes = $data['recipes'];
    $category = $data['category'];

@endphp   

    @if (isset($recipes))
    	@foreach ($recipes as $recipe)

            <!-- Recipe card -->
            <div class="card text-center mb-3" style="width:240px;">
                <a href="{{route('recipesall.show',['id' => $recipe->id])}}"><img class="card-img-top mb-2"  src="{{asset($recipe->cover_link_md())}}"></a>
                <div class="card-body p-2">

                    <h6 class="card-title mb-0">{{$recipe->name}}</h6>
                    <p class="card-text m-0">
                        <small><i>

                            @php $i=0; @endphp

                            @foreach($recipe->categories()->get() as $category)

                                @if ($i == 0)
                                    {{$category['name']}}
                                @else
                                ,&nbsp;{{$category['name']}}
                                @endif

                                @php $i++; @endphp

                            @endforeach

                            </i>
                        </small>
                    </p>
                    
                    <!-- Price -->
                    @if (session()->has('location'))
                        <p class="card-text m-0">
                            {{number_format((float)$recipe->getTotalPrice(), 2, '.', '')}}
                            <small class="text-danger">({{LocationManager::country()->currency}})</small>
                        </p>
                    @endif

                    <button class="btn btn-light btn-sm m-2"  onClick="window.location.replace('{{route("recipes.show",["id" => $recipe->id])}}')">
                        <i class="far fa-heart"></i>&nbsp;Yum, Yum</button>

                    <!--button class="btn btn-light btn-sm" id="del_{{$recipe->id}}" onClick="deleteRecipe('{{ route('recipes.destroy',['id' => $recipe->id]) }}');" ><i class="fas fa-trash"></i>&nbsp;Delete</button-->
                    
                </div> <!-- Card body - end -->  

                <!-- Card footer -->
                <div class="card-footer text-muted p-1">
                    <small>Recipe made by <i class="text-primary">{{ $recipe->user()->name }}</i></small>
                </div>

            </div>
            <!-- Recipe card - end -->

    	@endforeach
            <!--tr class="align-middle"><td colspan="100%" align="center">{{ $recipes->links("pagination::bootstrap-4") }}</td></tr-->   
           <!-- {{ $recipes->links("pagination::bootstrap-4") }}       -->
    @endif

