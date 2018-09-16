<!-- Modal create recipe -->
<div id="m_edit_plan" class="modal fade">
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit plan</h3>
            </div>

            <div class="modal-body">

                <div class="row">

                    <form id="edit_f" class="form" role="form" enctype="multipart/form-data" method="POST" action="{{ route('plans.update', ['id' => $plan->id]) }}">

                        <!-- Name -->
                        <div class="col-md-12">
                        <div id="f_name" class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            
                                <label for="name">Plan name</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ $plan->name }}" required autofocus >
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        {{ $errors->first('name') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Date -->
                        <div id="f_dates" class="form_group">

                            <div class="col-md-12">
                                <div id="f_plan_period" class= class="form-group {{ $errors->has('date_from') ? ' has-error' : '' }}">
                                </div>
                            </div>

                            <!-- Date from -->
                            <div class="col-md-6">
                                <div id="f_date_from" class= class="form-group {{ $errors->has('date_from') ? ' has-error' : '' }}">
                                    <label for="date_from">Date from</label>
                                    <input id="date_from" type="text" class="form-control" name="date_from" value="{{ $plan->date_from }}" placeholder="MM/DD/YYYY" autocomplete="off" required autofocus disabled="">
                                    @if ($errors->has('date_from'))
                                    <span class="help-block">
                                        {{ $errors->first('date_from') }}
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Date to -->
                            <div class="col-md-6">
                                <div id="f_date_to" class="form-group {{ $errors->has('date_to') ? ' has-error' : '' }}">
                                    <label for="date_to">Date to</label>
                                    <input id="date_to" type="text" class="form-control" name="date_to" value="{{ $plan->date_to }}" placeholder="MM/DD/YYYY" autocomplete="off" required autofocus disabled>
                                    @if ($errors->has('date_to'))
                                    <span class="help-block">
                                        {{ $errors->first('date_to') }}
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div> 


                        <!-- Number of persons -->
                        <div class="col-md-12">
                        <div id="f_persons" class="form-group {{ $errors->has('persons') ? ' has-error' : '' }}">
                            
                                <label for="persons">Number of persons</label>
                                <input id="persons" type="text" class="form-control" name="persons" value="{{$plan->persons}}" autocomplete="off" required autofocus >
                                @if ($errors->has('persons'))
                                    <span class="help-block">
                                        {{ $errors->first('persons') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        
                        <!-- Description -->
                        <div class="col-md-12">
                        <div id="f_description" class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                            
                                <label for="description">Description</label>
                                 <textarea id="description" class="form-control" name="description" rows="10">{{$plan->description}}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        {{ $errors->first('description') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                              
                    </form>

                </div> <!-- row end -->
            </div> <!-- modal-body end -->

            <div class="modal-footer">
                 <button id="btn_insert" onClick="UpdatePlan('m_edit_plan');" type="button" name="btn_edit" class="btn btn-md btn-success">Save</button>
            </div>

        </div>
  </div>  
</div>
