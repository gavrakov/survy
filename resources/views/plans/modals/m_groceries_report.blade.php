@php 
$total = 0; 
$list = $data['list'];
$item = $data['item'];
@endphp



<div id="m_groceries_report" class="modal fade" tabindex="-1">
  <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <i class="fas fa-chart-line"></i>&nbsp; Groceries report
            </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

            	<table class="table table-condensed">

            		<tr class="table-secondary">
            			<td colspan="100" class="small text-dark small"> <img width="20px" class="ml-r" src="<?php  $path = 'storage/icons/calendar-icon.png'; echo asset($path); ?>">&nbsp;
            <strong>{{$item->date}}</strong></td>	
            		</tr>

            		@if (count($list)==0)
            			<tr class="table-light"><td style="border:0px" colspan="100%">&nbsp;</td></tr>
            			<tr class="table-light"><td style="border:0px" colspan="100%"><em>No recipes for today...</em></td></tr>
            			<tr class="table-light"><td style="border:0px" colspan="100%">&nbsp;</td></tr>
            		@endif

            		@if (isset($list))

					    @foreach ($list as $l)
				        
					     	<tr>
					        	<td class="align-middle small">		
					        		<img style="position:relative; width:25px;  border-radius:100%; padding: 2px; border:1px #888888 solid"

					                    src="
					                    	<?php
					                    	$icon = $l->icon;
					                    	$path = 'storage/icons/groceries/' . $icon;
					                    	echo asset($path);
					                    	?>
					                    ">
					        	</td>	
					            <td class="align-middle small">
					             <!-- name -->
					       			{{$l->name}}
					            </td>
					            <td class="align-middle small">
					                <!-- Quantity - Unite -->
					                {{$l->quantity}}&nbsp;{{$l->unite}}
					            </td>
					            <td class="align-middle small text-right">
					             	<!-- Price -->
					             	{{number_format($l->price, 2)}}
					            </td>
					        </tr>


						        @php ($total += $l->price) @endphp
						        	
						      

					    @endforeach 

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
