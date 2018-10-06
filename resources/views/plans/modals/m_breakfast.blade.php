<?php $item = $data['item']; ?>
<?php $plan = $data['plan']; ?>
<?php $category = $data['category']; ?>



<!-- Modal edit photos -->
<div id="m_recipes" class="modal fade">
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add {{\App\RecipesCategory::find($category)->name}}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div name="data" class="col-md-12">
                        
                        <!-- Search -->
                        <div class="input-group custom-search-form mb-3">
                                    <input type="text" id="recipesearch" name="recipesearch" class="form-control" placeholder="Search...">
                        </div>

                        <div id="recipes"></div>

                    </div>
                </div>

            </div> <!-- Modal body - end -->

        </div> <!-- Modal content - end -->

  </div>  <!-- Modal dialog - end --> 

</div> <!-- Modal - end -->



<script type="text/javascript">

    $(document).ready(function(){

        // Load plan recipes
        loadDivData("{{ route('plans.items.recipe.load',['plan_id' => $plan,'item' => $item, 'category_id' => $category]) }}",'recipes');
   
        // Live search 
        $('#recipesearch').on('keyup',function(){
          
            $value=$(this).val();

            $.ajax({
             
                type : 'get',
                url : "{{ route('plans.items.recipe.search',['plan_id' => $plan,'item' => $item, 'category_id' => $category]) }}",
                dataType: 'html',
                data:{'search':$value},
                success:function(data){
                    console.log(data);
                    $('#recipes').html(data);      
                }
         
            });
         
        });
});
    
</script>





