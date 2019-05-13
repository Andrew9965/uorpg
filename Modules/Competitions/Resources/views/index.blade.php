@extends('layouts.app')

@section('content')
    <div class="central-section">
        <div class="content-competitions">
            <div class="title fix_pd">
                <h1><span>{{$page->title}}</span></h1>
            </div>
            @if(isset(Admin::user()->id))
                <div class="content-classes__icons">
                    <div class="icon-container">
                        <a href="{{route('pages_v2.edit', ['page' => $page->id])}}" class="edit" target="_blank"><i class="ico ico-edit-icon"></i></a>
                        <a href="{{route('pages_v2.destroy', ['page' => $page->id])}}" class="delete"><i class="ico ico-delete-icon"></i></a>
                    </div>
                </div>
            @endif

            <div class="content-competitions__wrap js-collapse-wrap">
                    <div class="content-competitions__info">
                        <div class="content-competitions__info-img"><i class="ico ico-goblet-larger"></i></div>
                        <div class="content-competitions__info-txt">
                            {!! $page->content !!}
                        </div>
                    </div>
                    @push('styles')
                        <style>
                            .jeneral_wrapper {
                                padding: 0;
                            }
                        </style>
                    @endpush
                    @include('sections.template', ['page' => $page])

                    @php
                        $nextDate = \Carbon\Carbon::create($year, $month, 1, 0, 0, 0)->addMonth()->format('Y-m');
                        $backDate = \Carbon\Carbon::create($year, $month, 1, 0, 0, 0)->subMonth()->format('Y-m');
                    @endphp

                    <div class="content-competitions__section js-collapse">
                        <div class="content-competitions__calendar js-calendar">
                            <div class="content-competitions__calendar-slider">
                                <button type="button" class="calendar-btn-prev" {{$first[0] >= $year && $first[1] >= $month ? 'disabled':'date-prev-month'}}><img src="{{asset('/s/images/useful/content-calendar/calc-arrow-left.png')}}" alt="icon"/></button>

                                <div class="content-competitions__calendar-data"><span class="month js-slider-month">{{trans("date.month_".$month)}}</span><span class="year js-slider-year">{{$year}}</span>
                                    <div class="calendar-btn-down"><img src="{{asset('/s/images/useful/content-calendar/calc-arrow-down.png')}}" alt="icon"/></div>
                                </div>

                                <button type="button" class="calendar-btn-next" {{$last[0] <= $year && $last[1] <= $month ? 'disabled':'date-next-month'}}><img src="{{asset('/s/images/useful/content-calendar/calc-arrow-right.png')}}" alt="icon"/></button>
                            </div>

                            <div class="content-competitions__calendar-dropdown">

                                <button type="button" id="calendarYearMin" class="cell cell-arrow"><img src="{{asset('/s/images/useful/content-calendar/calc-arrow-left.png')}}" alt="icon"/></button>
                                <input type="text" id="calendarYear" disabled="true" value="{{$year}}" data-min="{{$first[0]}}" data-max="{{$last[0]}}" class="cell cell-year"/>
                                <button type="button" id="calendarYearPlus" class="cell cell-arrow"><img src="{{asset('/s/images/useful/content-calendar/calc-arrow-right.png')}}" alt="icon"/></button>

                                @push('scripts')
                                <script>
                                    $(function(){
                                        $('[date-prev-month]').on('click', function(){
                                            location = '{{route('competitions.page', ['date' => $backDate])}}';
                                        });

                                        $('[date-next-month]').on('click', function(){
                                            location = '{{route('competitions.page', ['date' => $nextDate])}}';
                                        });

                                        var yInput = $('#calendarYear');
                                        $('#calendarYearMin').on('click', function(){
                                            var obj = $(this);
                                            var val = yInput.val();
                                            var min = yInput.data('min');
                                            if(Number(val)-1<min) return;
                                            yInput.val(Number(val)-1);
                                        });
                                        $('#calendarYearPlus').on('click', function(){
                                            var obj = $(this);
                                            var val = yInput.val();
                                            var max = yInput.data('max');
                                            if(Number(val)+1>max) return;
                                            yInput.val(Number(val)+1);
                                        });
                                        $('[data-ch-month]').on('click', function(){
                                            location = "{{route('competitions.page')}}?date="+yInput.val()+"-"+$(this).data('ch-month');
                                        });

                                        yInput.on('change', function(){
                                            location = "{{route('competitions.page')}}?date="+yInput.val()+"-{{$month}}";
                                        });
                                    });
                                </script>
                                @endpush

                                <button type="button" class="cell" data-ch-month="01"><span>{{trans("date.month_01")}}</span></button>
                                <button type="button" class="cell" data-ch-month="02"><span>{{trans("date.month_02")}}</span></button>
                                <button type="button" class="cell" data-ch-month="03"><span>{{trans("date.month_03")}}</span></button>
                                <button type="button" class="cell" data-ch-month="04"><span>{{trans("date.month_04")}}</span></button>
                                <button type="button" class="cell" data-ch-month="05"><span>{{trans("date.month_05")}}</span></button>
                                <button type="button" class="cell" data-ch-month="06"><span>{{trans("date.month_06")}}</span></button>
                                <button type="button" class="cell" data-ch-month="07"><span>{{trans("date.month_07")}}</span></button>
                                <button type="button" class="cell" data-ch-month="08"><span>{{trans("date.month_08")}}</span></button>
                                <button type="button" class="cell" data-ch-month="09"><span>{{trans("date.month_09")}}</span></button>
                                <button type="button" class="cell" data-ch-month="10"><span>{{trans("date.month_10")}}</span></button>
                                <button type="button" class="cell" data-ch-month="11"><span>{{trans("date.month_11")}}</span></button>
                                <button type="button" class="cell" data-ch-month="12"><span>{{trans("date.month_12")}}</span></button>
                            </div>
                        </div>
                        <div class="content-competitions__itm-container">
                            @foreach($results as $key=>$val)
                            <div class="content-competitions__item">
                                <h3>{{trans("competitions.".$key)}}:</h3>
                                <div class="content-competitions__table">
                                    <div class="content-competitions__category">
                                        <div class="content-competitions__category-place"><span>{{trans("competitions.mesto")}}</span></div>
                                        <div class="content-competitions__category-winner"><span>{{trans("competitions.pobeditel")}}</span></div>
                                        <div class="content-competitions__category-result"><span>{{trans("competitions.rezultat")}}</span></div>
                                    </div>
                                    @if($key=='tour')
                                        @foreach(\Help\ArrayClass::group($val, 'CHAR_ID') as $user)
                                            <div class="content-competitions__box">
                                                <div class="content-competitions__box-place"><span>{{$user[0]->PLACE}}</span></div>
                                                <div class="content-competitions__box-winner"><span>{{App::getLocale()=='en' ? $user[0]->CHAR_NAME_EN : $user[0]->CHAR_NAME}}</span></div>
                                                <div class="content-competitions__box-result"><span>{{implode('/', collect($user)->pluck('VALUE')->toArray())}}</span></div>
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach($val as $user)
                                            <div class="content-competitions__box">
                                                <div class="content-competitions__box-place"><span>{{$user->PLACE}}</span></div>
                                                <div class="content-competitions__box-winner"><span>{{App::getLocale()=='en' ? $user->CHAR_NAME_EN : $user->CHAR_NAME}}</span></div>
                                                <div class="content-competitions__box-result"><span>{{$user->VALUE}}</span></div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div style="margin: 30px"></div>
                    </div>
                </div>


        </div>
    </div>
@stop
