@pushonce('above_css')
<!-- JQUERY UI -->
<link href="{{ asset('admin/vendor/jquery-ui-1.12.1/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
@endpushonce

@pushonce('below_js')
<script language="javascript"
        type="text/javascript"
        src="{{ asset('admin/vendor/jquery-ui-1.12.1/jquery-ui.min.js') }}"></script>
@endpushonce

@pushonceOnReady('below_js_on_ready')
<script>
    $(document).on('datePickersInstance', function() {
        $('.datepicker').datepicker({
            dateFormat: "dd.mm.yy"
        });
    });
    $(document).trigger('datePickersInstance');
</script>
@endpushonceOnReady

@php
    $translationsDefault = trans('admin/activiable/activiable');
    $langs = isset($translations)?
        transOrOther($translations, 'admin/activiable/activiable', array_keys($translationsDefault)) : $translationsDefault;
    $activiable_bag = $activiable_bag ?? 'active';
@endphp

<fieldset>
    <span class="@if($errors->$inputBag->has('active.period_type')) text-danger @endif">{{$langs['period_type']}}:</span>
    <div class="form-check form-check-inline align-middle">
        <input type="radio"
               class="form-check-input"
               name="{{$inputBag}}[{{$activiable_bag}}][period_type]"
               id="{{$inputBag}}[{{$activiable_bag}}][period_type][0]"
               value="0"
               @if((!is_null(old($inputBag.'.'.$activiable_bag.'.period_type')) && !old($inputBag.'.'.$activiable_bag.'.period_type')) || (is_null(old($inputBag.'.'.$activiable_bag.'.period_type')) && isset($activiable) && !$activiable->period_type) )checked="checked"@endif
               @if(is_null(old($inputBag.'.'.$activiable_bag.'.period_type')) && !isset($activiable))checked="checked"@endif
        />
        <label class="form-check-label" for="{{$inputBag}}[{{$activiable_bag}}][period_type][0]">{{$langs['period_active']}}</label>
    </div>
    <div class="form-check form-check-inline align-middle">
        <input type="radio"
               class="form-check-input"
               name="{{$inputBag}}[{{$activiable_bag}}][period_type]"
               id="{{$inputBag}}[{{$activiable_bag}}][period_type][1]"
               value="1"
               @if((!is_null(old($inputBag.'.'.$activiable_bag.'.period_type')) && old($inputBag.'.'.$activiable_bag.'.period_type')) || (is_null(old($inputBag.'.'.$activiable_bag.'.period_type')) && $activiable?->period_type) ) checked="checked" @endif
        />
        <label class="form-check-label" for="{{$inputBag}}[{{$activiable_bag}}][period_type][1]">{{$langs['period_unactive']}}</label>
    </div>
    <!-- /.row -->

    <div class="form-inline mb-3 mt-2">
        <div class="form-group mr-2">
            <label for='{{$inputBag}}[{{$activiable_bag}}][period_from]' class="mr-2">{{$langs['period']}}:</label>
        </div>
        <div class="form-group mr-2">
            <input class="form-control datepicker @if($errors->$inputBag->has('active.period_from.date')) is-invalid @endif"
                   name='{{$inputBag}}[{{$activiable_bag}}][period_from][date]'
                   id='{{$inputBag}}[{{$activiable_bag}}][period_from][date]'
                   placeholder="{{$langs['period_date']}}"
                   value="{{ old($inputBag.'.'.$activiable_bag.'.period_from.date', ($activiable?->period_from)? $activiable->period_from->format('d.m.Y') : '') }}"
            />
        </div>
        @php
            $sPFhour = old($inputBag.'.'.$activiable_bag.'.period_from.hour', ($activiable?->period_from)? $activiable->period_from->format('H') : 0);
            $sPThour = old($inputBag.'.'.$activiable_bag.'.period_to.hour', ($activiable?->period_to)? $activiable->period_to->format('H') : 0);
            $sPFminute = old($inputBag.'.'.$activiable_bag.'.period_from.minutes', ($activiable?->period_from)? $activiable->period_from->format('i') : 0);
            $sPTminute = old($inputBag.'.'.$activiable_bag.'.period_to.minutes', ($activiable?->period_to)? $activiable->period_to->format('i') : 0);
        @endphp
        <div class="form-group mr-2">
            <select class="form-control"
                    name='{{$inputBag}}[{{$activiable_bag}}][period_from][hour]'
                    id='{{$inputBag}}[{{$activiable_bag}}][period_from][hour]'>
                @for($i=0;$i<24;$i++)
                    <option value='{{ sprintf('%02d', $i) }}'
                            @if($sPFhour == $i)selected="selected"@endif>{{ sprintf('%02d', $i) }}</option>
                @endfor
            </select>
        </div>
        <div class="form-group mr-2">&nbsp;:&nbsp;</div>
        <div class="form-group mx-2">
            <select class="form-control"
                    name='{{$inputBag}}[{{$activiable_bag}}][period_from][minutes]'
                    id='{{$inputBag}}[{{$activiable_bag}}][period_from][minutes]'>
                @for($i=0;$i<60;$i++)
                    <option value='{{ sprintf('%02d', $i) }}'
                            @if($sPFminute == $i)selected="selected"@endif>{{ sprintf('%02d', $i) }}</option>
                @endfor
            </select>
        </div>
        <div class="form-group mr-2">&nbsp;-&nbsp;</div>
        <div class="form-group mr-2">
            <input class="form-control datepicker @if($errors->$inputBag->has('active.period_to.date')) is-invalid @endif"
                   name='{{$inputBag}}[{{$activiable_bag}}][period_to][date]'
                   id='{{$inputBag}}[{{$activiable_bag}}][period_to][date]'
                   placeholder="{{$langs['period_date']}}"
                   value="{{ old($inputBag.'.'.$activiable_bag.'.period_to.date', ($activiable?->period_to)? $activiable->period_to->format('d.m.Y') : '') }}"
            />
        </div>
        <div class="form-group mr-2">
            <select class="form-control"
                    name='{{$inputBag}}[{{$activiable_bag}}][period_to][hour]'
                    id='{{$inputBag}}[{{$activiable_bag}}][period_to][hour]'
            >
                @for($i=0;$i<24;$i++)
                    <option value='{{ sprintf('%02d', $i) }}'
                            @if($sPThour == $i)selected="selected"@endif>{{ sprintf('%02d', $i) }}</option>
                @endfor
            </select>
        </div>
        <div class="form-group mr-2">&nbsp;:&nbsp;</div>
        <div class="form-group ml-2">
            <select class="form-control"
                    name='{{$inputBag}}[{{$activiable_bag}}][period_to][minutes]'
                    id='{{$inputBag}}[{{$activiable_bag}}][period_to][minutes]'>
                @for($i=0;$i<60;$i++)
                    <option value='{{ sprintf('%02d', $i) }}'
                            @if($sPTminute == $i)selected="selected"@endif>{{ sprintf('%02d', $i) }}</option>
                @endfor
            </select>
        </div>
    </div>
</fieldset>
