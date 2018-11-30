@php 
$breakfast_tmp = null; 
$lunch_tmp = null; 
$dinner_tmp = null; 
$breakfast_sum = 0;
$lunch_sum = 0; 
$dinner_sum = 0;
$total = 0;
@endphp

<div id="m_recipes_report" class="modal fade" tabindex="-1">
  <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <i class="far fa-chart-bar"></i>&nbsp; Recipes report
            </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

            	<table class="table table-sm">
            		@if (count($list)==0)
            			<tr class="table-light"><td style="border:0px" colspan="100%">&nbsp;</td></tr>
            			<tr class="table-light"><td style="border:0px" colspan="100%"><em>No recipes for today...</em></td></tr>
            			<tr class="table-light"><td style="border:0px" colspan="100%">&nbsp;</td></tr>
            		@endif

            		@if (isset($list))

					    @foreach ($list as $l)

					    	<!-- Breakfast sum -->
					    	@if($breakfast_tmp <> $l->breakfast and $l->breakfast == null)
					    		<tr class="table-light">
					    			<td class="small text-dark small"><strong>Breakfast price:</strong>&nbsp;</td>
					    			<td class="small text-dark text-right small">&nbsp;</td>
					    			<td class="small text-dark text-right small">&nbsp;</td>
					    			<td class="small text-dark text-right small"><strong>{{number_format($breakfast_sum, 2)}}</strong>&nbsp;<small class='text-danger'>({{LocationManager::country()->currency}})</td>
					    		</tr>
					    		<tr><td colspan="100%">&nbsp;</td></tr>

					    		@php ($breakfast_tmp = 0) @endphp
					    	@endif

					    	<!-- Lunch sum -->
					    	@if($lunch_tmp <> $l->lunch and $l->lunch == null)
					    		<tr class="table-light">
					    			<td class="small text-dark small"><strong>Lunch price:</strong>&nbsp;</td>
					    			<td class="small text-dark text-right small">&nbsp;</td>
					    			<td class="small text-dark text-right small">&nbsp;</td>
					    			<td class="small text-dark text-right small"><strong>{{number_format($lunch_sum, 2)}}</strong>&nbsp;<small class='text-danger'>({{LocationManager::country()->currency}})</td>
					    		</tr>
					    		<tr><td colspan="100%">&nbsp;</td></tr>

					    		@php ($lunch_tmp = 0) @endphp
					    	@endif

					    	<!-- Dinner sum -->
					    	@if($dinner_tmp <> $l->dinner and $l->dinner == null)
					    		<tr class="table-light">
					    			<td class="small text-dark small"><strong>Dinner price:</strong>&nbsp;</td>
					    			<td class="small text-dark text-right small">&nbsp;</td>
					    			<td class="small text-dark text-right small">&nbsp;</td>
					    			<td class="small text-dark text-right small"><strong>{{number_format($dinner_sum, 2)}}</strong>&nbsp;<small class='text-danger'>({{LocationManager::country()->currency}})</td>
					    		</tr>
					    		<tr><td colspan="100%">&nbsp;</td></tr>

					    		@php ($dinner_tmp = 0) @endphp
					    	@endif

					    	<!-- Breakfast header -->
					    	@if($breakfast_tmp <> $l->breakfast and $l->breakfast <> null)
					    		<tr class="table-info"><td colspan="100%" class="small text-dark">Breakfast</td></tr>
					    		<tr>
						    		<td>
						    			<img style="position:relative; width:25px;  border-radius:100%; padding: 2px; border:1px #888888 solid"
					                    src="{{asset($l->breakfast()->first()->cover_link_sm())}}">
					                  
					                </td>
					                <td colspan="3">
					                	  <strong>{{$l->breakfast()->first()->name}}</strong>
					                </td>
				                </tr>

				            <!-- Lunch header -->    
				            @elseif($lunch_tmp <> $l->lunch && $l->lunch <> null)
				            	<tr class="table-success"><td colspan="100%" class="small text-dark">Lunch</td></tr>
				            	<tr>
						    		<td>
						    			<img style="position:relative; width:25px;  border-radius:100%; padding: 2px; border:1px #888888 solid"
					                    src="{{asset($l->lunch()->first()->cover_link_sm())}}">
					                </td>
					                <td colspan="3">
					                	<strong>{{$l->lunch()->first()->name}}</strong>
					                </td>
				                </tr>

				            <!-- Dinner header -->
				            @elseif($dinner_tmp <> $l->dinner && $l->dinner <> null)
				            	<tr class="table-warning"><td colspan="100%" class="small text-dark">Dinner</td></tr>
				            	<tr>
						    		<td>
						    			<img style="position:relative; width:25px;  border-radius:100%; padding: 2px; border:1px #888888 solid"
					                    src="{{asset($l->dinner()->first()->cover_link_sm())}}"> 
					                </td>
					                <td colspan="3">
					                	<strong>{{$l->dinner()->first()->name}}</strong>
					                </td>
				                </tr>
					    	@endif

					        <tr>
					        	<td class="align-middle small">		
					        		<img style="position:relative; width:25px;  border-radius:100%; padding: 2px; border:1px #888888 solid"

					                    src="
					                    	<?php
					                    	$icon = $l->grocery()->first()->getCategoryIcon();
					                    	$path = 'storage/icons/groceries/' . $icon;
					                    	echo asset($path);
					                    	?>
					                    ">
					        	</td>	
					            <td class="align-middle small">
					             {{$l->grocery()->first()->name}}
					            </td>
					            <td class="align-middle small">
					                {{$l->quantity}}&nbsp; {{$l->grocery()->first()->getUnite()}}
					            </td>
					            <td class="align-middle small text-right">
					                {{ number_format($l->price, 2) }}
					            </td>
					        </tr>

						        @php
						        	$breakfast_tmp = $l->breakfast;
						        	$lunch_tmp = $l->lunch;
						        	$dinner_tmp = $l->dinner;
						        @endphp

						        @if($l->breakfast <> null) 
						        		@php ($breakfast_sum += $l->price) @endphp
						       	@endif

						        @if($l->lunch <> null) 
						        		@php ($lunch_sum += $l->price) @endphp
						        @endif

						        @if($l->dinner <> null)
						        		@php ($dinner_sum += $l->price) @endphp
						        @endif

						        @php ($total += $l->price) @endphp
						        	
						      

					        @endforeach 


					        <!-- Breakfast sum -->
					    	@if($breakfast_tmp != null)
					    		<tr class="table-light">
					    			<td class="small text-dark small"><strong>Breakfast price:</strong>&nbsp;</td>
					    			<td class="small text-dark text-right small">&nbsp;</td>
									<td class="small text-dark text-right small">&nbsp;</td>
					    			<td class="small text-dark text-right small"><strong>{{number_format($breakfast_sum, 2)}}</strong>&nbsp;<small class='text-danger'>({{LocationManager::country()->currency}})</td>
					    		</tr>
					    		<tr><td colsapn="100%">&nbsp;</td></tr>

					    		@php ($breakfast_sum = 0) @endphp
					    	@endif

					    	<!-- Lunch sum -->
					    	@if($lunch_tmp != null )
					    		<tr class="table-light">
					    			<td class="small text-dark small"><strong>Lunch price:</strong>&nbsp;</td>
					    			<td class="small text-dark text-right small">&nbsp;</td>
					    			<td class="small text-dark text-right small">&nbsp;</td>
					    			<td class="small text-dark text-right small"><strong>{{number_format($lunch_sum, 2)}}</strong>&nbsp;<small class='text-danger'>({{LocationManager::country()->currency}})</td>
					    		</tr>
					    		<tr><td colsapn="100%">&nbsp;</td></tr>

					    		@php ($lunch_sum = 0) @endphp
					    	@endif

					    	<!-- Dinner sum -->
					    	@if($dinner_tmp != null)
					    		<tr class="table-light">
					    			<td class="small text-dark small"><strong>Dinner price:</strong>&nbsp;</td>
					    			<td class="small text-dark text-right small">&nbsp;</td>
					    			<td class="small text-dark text-right small">&nbsp;</td>
					    			<td class="small text-dark text-right small"><strong>{{number_format($dinner_sum, 2)}}</strong>&nbsp;<small class='text-danger'>({{LocationManager::country()->currency}})</td>
					    		</tr>
					    		<tr><td colsapn="100%">&nbsp;</td></tr>

					    		@php ($dinner_sum = 0) @endphp
					    	@endif 

					    	<!-- Total -->
					    	<tr class="table-secondary">
				    			<td class="small text-dark small"><strong>Total:</strong>&nbsp;</td>
				    			<td class="small text-dark text-right small">&nbsp;</td>
				    			<td class="small text-dark text-right small">&nbsp;</td>
				    			<td class="small text-dark text-right small"><strong>{{number_format($total, 2)}}</strong>&nbsp;<small class='text-danger'>({{LocationManager::country()->currency}})</td>
					    	</tr>

					@endif
				</table>
                        

            </div> <!-- modal-body end -->

            <div class="modal-footer">
                <button id="btn_close" data-dismiss="modal" type="button" name="btn_close" class="btn btn-md btn-secondary">Close</button>
            </div>

        </div>
  </div>  
</div>
