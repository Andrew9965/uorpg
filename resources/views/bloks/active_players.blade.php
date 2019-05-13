<div class="content-market">
            <div class="content-market__wrap">
                <div class="content-market__search">
                    <form class="content-market__search-left" method="get" action="{{route('active_players')}}">
                        @foreach(request_all(['nick','page']) as $key => $val)
                            <input type="hidden" name="{{$key}}" value="{{$val}}" >
                        @endforeach
                        <div class="form-group">
                            <label for="user-name">{{trans("ActivePlayers.imya_personazha")}}:</label>
                            <div class="input-wrap">
                                <input name="nick" type="text" value="{{request()->nick}}" id="user-name" class="form-control my-form-custom"/>
                            </div>
                        </div>
                        <div class="content-market__search-btn">
                            <button type="submit">{{trans("market.iskat")}}</button>
                        </div>
                    </form>
                    <div class="content-market__search-right"><span class="inf">{!! trans("market.pokazat") !!}</span>
                        <select class="selectpicker" onchange="location='{{route('active_players').'?'.http_build_query(request_all('num'))}}&num='+$(this).val()">
                            <option {{request()->num=='50' ? 'selected':''}}>50</option>
                            <option {{request()->num=='100' ? 'selected':''}}>100</option>
                            <option {{request()->num=='200' ? 'selected':''}}>200</option>
                            <option {{request()->num=='500' ? 'selected':''}}>500</option>
                        </select><i class="ico ico-select"></i>
                    </div>
                </div>

                <table align="center" style="margin: 4px;">
                    @php
                    $hed = [
                        ['title' => trans("ActivePlayers.imya_personazha"), 'field' => 'nick_name'],
                        ['title' => trans("ActivePlayers.uroven"), 'field' => 'level'],
                        ['title' => trans("ActivePlayers.klass"), 'field' => 'class'],
                        ['title' => trans("ActivePlayers.storona"), 'field' => 'pforce'],
                        ['title' => trans("ActivePlayers.opyt"), 'field' => 'exp'],
                        ['title' => trans("ActivePlayers.izvestnost"), 'field' => 'fame'],
                        ['title' => trans("ActivePlayers.chasov_v_igre"), 'field' => 'timeingame']
                    ];
                    @endphp
                    <thead>
                        <tr>
                            @foreach($hed as $h)
                                <th>
                                    <a href="{{route('active_players', request_all(array_pluck($hed, 'field'), [$h['field'] => request()->{$h['field']}=='up' ? 'down' : 'up']))}}" @if(request()->{$h['field']}) style="font-weight: 900;" @endif >
                                        {{$h['title']}}
                                    </a>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($players as $p)
                        <tr style="color: {{$const::partie($p->PFORCE)['color']}};">
                            <td style="color: {{$const::partie($p->PFORCE)['color']}};">{{$p->NICK}}</td>
                            <td style="color: {{$const::partie($p->PFORCE)['color']}};">{{$p->LEVEL}}</td>
                            <td style="color: {{$const::partie($p->PFORCE)['color']}};">{{$const::classes($p->CLASS)}}</td>
                            <td style="color: {{$const::partie($p->PFORCE)['color']}};">{{$const::partie($p->PFORCE)['title']}}</td>
                            <td style="color: {{$const::partie($p->PFORCE)['color']}};">{{$p->EXP}}</td>
                            <td style="color: {{$const::partie($p->PFORCE)['color']}};">{{$p->FAME}}</td>
                            <td style="color: {{$const::partie($p->PFORCE)['color']}};">{{$p->TIMEINGAME}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            {{$players->links()}}

        </div>