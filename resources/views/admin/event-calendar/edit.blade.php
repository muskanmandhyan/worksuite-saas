

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><i class="icon-pencil"></i> @lang('app.edit') @lang('app.menu.Events')</h4>
</div>
<div class="modal-body">
    {!! Form::open(['id'=>'updateEvent','class'=>'ajax-form','method'=>'PUT']) !!}
    <input type= "hidden" name="event_unique_id" value="{{$event->event_unique_id}}">
    <div class="form-body">
        <div class="row">
            <div class="col-md-6 ">
                <div class="form-group">
                    <label class ="required">@lang('modules.events.eventName')</label>
                    <input type="text" name="event_name" id="event_name" value="{{ $event->event_name }}" class="form-control">
                </div>
            </div>

            <div class="col-md-2 ">
                <div class="form-group">
                    <label>@lang('modules.sticky.colors')</label>
                    <select id="edit-colorselector" name="label_color">
                        <option value="bg-info" data-color="#5475ed" @if($event->label_color == 'bg-info') selected @endif>Blue</option>
                        <option value="bg-warning" data-color="#f1c411" @if($event->label_color == 'bg-warning') selected @endif>Yellow</option>
                        <option value="bg-purple" data-color="#ab8ce4" @if($event->label_color == 'bg-purple') selected @endif>Purple</option>
                        <option value="bg-danger" data-color="#ed4040" @if($event->label_color == 'bg-danger') selected @endif>Red</option>
                        <option value="bg-success" data-color="#00c292" @if($event->label_color == 'bg-success') selected @endif>Green</option>
                        <option value="bg-inverse" data-color="#4c5667" @if($event->label_color == 'bg-inverse') selected @endif>Grey</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4 ">
                <div class="form-group">
                    <label class ="required">@lang('modules.events.where')</label>
                    <input type="text" name="where" id="where" value="{{ $event->where }}" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="form-group" style="margin-top: 7px;">
                <label >@lang('modules.tasks.category')
                   <a href="javascript:;" id="add_category" class="btn btn-xs btn-success btn-outline add_category"><i class="fa fa-plus"></i></a>
                </label>
                <select class="select2 form-control" name="category_id" id="category_add"
                    data-style="form-control">
                    <option value="">@lang('messages.pleaseSelectCategory')</option> 
                @forelse($categories as $category)
                 <option value="{{ $category->id }}" @if($event->category_id == $category->id) selected @endif>{{ ucwords($category->category_name) }}</option>
                     @empty
                   <option value="">@lang('messages.noCategoryAdded')</option>
                      @endforelse
                </select>
              </div>
       </div>
       <div class="col-md-6 ">
            <div class="form-group" style="margin-top: 7px;">
                <label >@lang('modules.events.eventType')
                   <a href="javascript:;" id="createEventType" class="btn btn-xs btn-success btn-outline createEventType"><i class="fa fa-plus"></i></a>
                </label>
                <select class="select2 form-control" name="event_type_id" id="event_type_id2"
                    data-style="form-control">
                @forelse($eventTypes as $eventType)
                 <option value="{{ $eventType->id }}" @if($event->event_type_id == $eventType->id) selected @endif>{{ ucwords($eventType->name) }}</option>
                     @empty
                   <option value="">@lang('messages.noCategoryAdded')</option>
                      @endforelse
                </select>
              </div>
       </div>
        <div class="row">
            <div class="col-xs-12 ">
                <div class="form-group">
                    <label class ="required">@lang('app.description')</label>
                    <textarea name="description" id="description" class="form-control">{{ $event->description }}</textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-md-3 ">
                <div class="form-group">
                    <label class ="required">@lang('modules.events.startOn')</label>
                    <input type="text" name="start_date" id="start_date" value="{{ $event->start_date_time->format($global->date_format) }}" class="form-control">
                </div>
            </div>
            <div class="col-xs-5 col-md-3">
                <div class="input-group bootstrap-timepicker timepicker">
                    <label>&nbsp;</label>
                    <input type="text" name="start_time" id="start_time" value="{{ $event->start_date_time->format($global->time_format) }}"
                           class="form-control">
                </div>
            </div>

            <div class="col-xs-6 col-md-3">
                <div class="form-group">
                    <label class ="required">@lang('modules.events.endOn')</label>
                    <input type="text" name="end_date" id="end_date" value="{{ $event->end_date_time->format($global->date_format) }}" class="form-control">
                </div>
            </div>
            <div class="col-xs-5 col-md-3">
                <div class="input-group bootstrap-timepicker timepicker">
                    <label>&nbsp;</label>
                    <input type="text" name="end_time" id="end_time" value="{{ $event->end_date_time->format($global->time_format) }}"
                           class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <a href="javascript:;" id="show-attendees" class="text-info"><i class="icon-people"></i> @lang('modules.events.viewAttendees') (<span id="attendeesCount">{{ $totalAttendee }}</span>)</a>
            </div>
            <div class="col-xs-12"  id="edit-attendees" style="display: none;">
                <div class="col-xs-12" style="max-height: 210px; overflow-y: auto;">
                    <ul class="list-group">
                        @foreach($event->attendee as $emp)
                        @if(in_array($emp->user_id, $employees->pluck('id')->toArray()))
                            <li class="list-group-item attend_id">{{ucwords($emp->user->name)}}
                                <a href="javascript:;" data-attendee-id="{{ $emp->id }}" class="btn btn-xs btn-rounded btn-danger pull-right remove-attendee"><i class="fa fa-times"></i> @lang('app.remove')</a>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="form-group">
                    <label class ="required" class="col-xs-3 m-t-10">@lang('modules.events.addAttendees')</label>
                    <div class="col-xs-7">
                        <div class="checkbox checkbox-info">
                            <input id="edit-all-employees" name="all_employees" value="true"
                                   type="checkbox">
                            <label for="edit-all-employees">@lang('modules.events.allEmployees')</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <select class="select3 m-b-10 select2-multiple " multiple="multiple"
                            data-placeholder="Choose Members, Clients" name="user_id[]" id="employees-list">
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ ucwords($emp->name) }} @if($emp->id == $user->id)
                                    (YOU) @endif</option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="form-group">
                    <label class="col-xs-3 m-t-10 required">@lang('modules.events.addClients')</label>
                    <div class="col-xs-7">
                        <div class="checkbox checkbox-info">
                            <input id="edit-all-employees" name="all_clients" value="true"
                                   type="checkbox">
                            <label for="edit-all-employees">@lang('modules.events.allClients')</label>
                        </div>
                    </div>
                </div>
               
                <div class="form-group">
                    <select class="select3 m-b-10 select2-multiple " multiple="multiple"
                            data-placeholder="Choose Clients" name="user_id[]" id="employees-list">
                            @php $selectedClient = []; @endphp
                    @foreach($clients as $client)
                        @if(in_array($client->id, $event->attendee->pluck('user_id')->toArray()))
                            @php $selectedClient[] = $client->id ; @endphp
                        @endif
                        <option value="{{ $client->id }}" {{in_array($client->id, $event->attendee->pluck('user_id')->toArray())  ? 'selected' : ''}}>{{ ucwords($client->name) }}
                        </option>
                    @endforeach
                    </select>
                    @if($selectedClient)
                        @foreach($selectedClient as $slectclient)
                        <input type="hidden" name="selected_client[]" value="{{ $slectclient }}">
                        @endforeach
                    @endif

                </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-xs-6">
                    <div class="checkbox checkbox-info">
                        <input id="edit-repeat-event" name="repeat" value="yes" @if($event->repeat == 'yes') checked @endif
                               type="checkbox">
                        <label for="edit-repeat-event">@lang('modules.events.repeat')</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="edit-repeat-fields" @if($event->repeat == 'no') style="display: none" @endif>
            <div class="col-xs-6 col-md-3 ">
                <div class="form-group">
                    <label>@lang('modules.events.repeatEvery')</label>
                    <input type="number" min="1" value="{{ $event->repeat_every }}" name="repeat_count" class="form-control">
                </div>
            </div>
            <div class="col-xs-6 col-md-3">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <select name="repeat_type" id="" class="form-control">
                        <option @if($event->repeat_type == 'day') selected @endif value="day">Day(s)</option>
                        <option @if($event->repeat_type == 'week') selected @endif value="week">Week(s)</option>
                        <option @if($event->repeat_type == 'month') selected @endif value="month">Month(s)</option>
                        <option @if($event->repeat_type == 'year') selected @endif value="year">Year(s)</option>
                    </select>
                </div>
            </div>

            <div class="col-xs-6 col-md-3">
                <div class="form-group">
                    <label>@lang('modules.events.cycles') <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2">@lang('modules.events.cyclesToolTip')</span></span></span></a></label>
                    <input type="text" value="{{ $event->repeat_cycles }}" name="repeat_cycles" id="repeat_cycles" class="form-control">
                </div>
            </div>
        </div>

    </div>
    {!! Form::close() !!}

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-success save-event waves-effect waves-light">@lang('app.update')</button>
</div>



<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('js/cbpFWTabs.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/multiselect/js/jquery.multi-select.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-colorselector/bootstrap-colorselector.min.js') }}"></script>

<script>
    jQuery('#start_date, #end_date').datepicker({
        autoclose: true,
        todayHighlight: true,
        weekStart:'{{ $global->week_start }}',
        format: '{{ $global->date_picker_format }}',
    })

    $('#edit-colorselector').colorselector();

    $('#start_time, #end_time').timepicker({
        @if($global->time_format == 'H:i')
        showMeridian: false
        @endif
    });

    $(".select3").select2();
    $("select.select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });

    $('.save-event').click(function () {
        var attendeeId = $('.remove-attendee').map(function() {
            return $(this).attr('data-attendee-id');
        }).toArray();
        
        $.easyAjax({
            url: '{{route('admin.events.update', $event->id)}}',
            container: '#updateEvent',
            type: "PUT",
            data: $('#updateEvent').serialize()+ "&attendeeId=" + attendeeId,
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        })
    })
    $('.createEventType').click(function(){
            var url = '{{ route('admin.events-type.create')}}';
            $('#modelHeading').html("@lang('modules.contracts.manageContractType')");
            $.ajaxModal('#projectCategoryModal', url);
        });
        $('.add_category').click(function () {
            console.log("ds");
            var url = '{{ route('admin.events-category.create')}}';
            $('#modelHeading').html('...');
            $.ajaxModal('#projectCategoryModal', url);
         });
    $('#edit-repeat-event').change(function () {
        if($(this).is(':checked')){
            $('#edit-repeat-fields').show();
        }
        else{
            $('#edit-repeat-fields').hide();
        }
    })

    $('#show-attendees').click(function () {
        $('#edit-attendees').slideToggle();
    })

    $('.remove-attendee').click(function () {
        var row = $(this);
        var attendeeId = row.data('attendee-id');
        var url = '{{route('admin.events.removeAttendee')}}';

        $.easyAjax({
            url: url,
            type: "POST",
            data: { attendeeId: attendeeId,event_id: '{{ $event->id }}', _token: '{{ csrf_token() }}'},
            success: function (response) {
                var attendeesCount = parseInt($('#attendeesCount').text());

                $('#attendeesCount').text(attendeesCount - 1);
                if(response.status == 'success'){
                    row.closest('.list-group-item').fadeOut();
                    var options = '';
                    response.employees.forEach(employee => {
                        options += `<option value='${employee.id}'>${employee.text}</option>`
                    })

                    $('#employees-list').html(options);
                    $('#employees-list').select2().trigger('change')
                }
            }
        })
    })

</script>