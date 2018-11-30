<?php $recipe = $data['recipe']; ?>
<?php $groceries = $data['groceries']; ?>
<?php $location = $data['location']; ?>



<!-- Modal edit photos -->
<div id="m_groceries" class="modal modal-wide fade">
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit recipes groceries</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               
            <div class="row">

                <div class="col">
                    
                    <!-- Card -->
                    <div class="card">
                        
                        <!-- Card body -->
                        <div class="card-body p-0">

                                <h6 class="card-title pl-3 pt-3">Groceries</h6>
                          
                                
                                <form name="f_add_groceries" id="f_add_groceries" role="form" class="main-form needs-validation" type="post" action="{{ route('recipes.groceries.store',['id' => $recipe->id]) }}">
                                    <input name="f_grocery" id="f_grocery" type="text" class="form-control" value="" hidden>
                                    <input name="f_quantity" id="f_quantity" type="text" class="form-control" value="" hidden>
                               
                                    <!-- Errors -->
                                    <div id='errors' name="errors" class="pull-left p-3" style="width:70%;"></div>

                                    <!-- Search bar -->
                                    <div class="input-group custom-search-form pull-right p-3" align="center" style="width:30%;">
                                            <input width="150px" type="text" id="groceriessearch" name="groceriessearch" class="form-control" placeholder="Search...">
                                    </div>

                               
                                
                                <table id="groceries" class="table">
                                    <!--thead>
                                        
                                            <th width="10%">Photo</th>
                                            <th width="30%">Name</th>
                                            <th width="20%">Category</th>
                                            <th width="10%">Quantity</th>
                                            <th width="10%">Unite</th>
                                            @if ($location !== null)   
                                                <th width="15%">Price <small class='text-danger'>({{$location->currency}})</small></th>
                                            @endif
                                            <th width="10%">Price</th>
                                            <th width="10%"></th>
                                        
                                        
                                    </thead-->

                                    <tbody>
                                       <!-- Load groceries - Ajax -->
                                    </tbody>

                                </table>

                            </form>
                                
                        </div> <!-- Card-body - end -->
                        
                    </div> <!-- Card - end -->
                </div> <!-- col-md-8 -end -->


                <!--- List of recipes groceries -->
                <div class="col">
                    
                    <!-- Card -->
                    <div class="card">
                        <!-- Card body -->
                        <div class="card-body p-0">

                                <h6 class="card-title mt-3 ml-3">Basket</h6>

                                <table id="basket" class="table">
                                    <tbody>
                                        <!-- Load basket - Ajax -->
                                    </tbody>
                                </table>

                            <!-- ovde paginacija -->

                        </div> <!-- Card-body ends -->
                    </div>  <!-- Card ends -->

                </div> <!-- col-md-4 - end -->  

        </div> <!-- row-fluid - end -->

                      
                    


        </div> <!-- Modal body - end -->

        <div class="modal-footer">
                <button id="btn_close" data-dismiss="modal" type="button" name="btn_close" class="btn btn-md btn-secondary">Close</button>
        </div>

    </div> <!-- Modal content - end -->

  </div>  <!-- Modal dialog - end --> 

</div> <!-- Modal - end -->



<!-- File upload -->
<script type="text/javascript">


    $(document).ready(function(){
     
        // Load groceries
        loadTableData('{{ route("recipes.groceries.load",["id" => $recipe->id]) }}','groceries');

        // Load basket - inserted groceries
        loadTableData('{{ route("recipes.groceries.basket",["id" => $recipe->id]) }}','basket');


        // Pagination
        $(function() {
            $('#groceries > tbody').on('click', '.pagination a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');  
                getGroceries(url);
                window.history.pushState("", "", url);
            });



            function getGroceries(url) {
                $.ajax({
                    type: 'get',
                    url : url ,
                    dataType: 'html' 
                }).done(function (data) {
                    $('#groceries > tbody').html(data);  
                }).fail(function () {
                    alert('Recipes could not be loaded.');
                });
            }
        });


        // Close modal edit photos event
        $('#m_groceries').on('hide.bs.modal', function(){

            // Load basket - inserted groceries
            loadTableData('{{ route("recipes.basket",["id" => $recipe->id]) }}','groceries_basket');
        });



        // Live search 
        $('#groceriessearch').on('keyup',function(){
          
            $value=$(this).val();

            $.ajax({
             
                type : 'get',
                url : '{{ route("recipes.groceries.search",["id" => $recipe->id]) }}',
                dataType: 'html',
                data:{'search':$value},
                success:function(data){
                    console.log(data);
                    $('#groceries > tbody').html(data);      
                }
         
            });
         
        });



    });


   


</script>
