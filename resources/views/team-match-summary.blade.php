<!DOCTYPE html>
<html>
    <head> 
        <style>
            .fl{float:left;}
            .cfx{clear:both;}
            .div-width {width:200px;}
            .div2-width {width:80px;}
        </style>
    </head>
    <body>
        <br/>
        <a href="{{env('BASE_URL').'home'}}">@lang('cricket.back')</a>
        <br/><br/>
        @if(!empty($data))
            <h3>@lang('cricket.match_summary_of') {{ ($data[0]['teamName']) ?? 'n/a' }}</h3>
            <br/><br/>
            @php
            $totalPoints = 0;
            @endphp
        
            @foreach ($data as $team)
            <div>
                <b>{{ $team['teamName'].' '}}</b>
                <i style="color:green">{{$team['matchStatus']}}</i>
               @lang('cricket.match_no') {{$team['matchId']}} @lang('cricket.against')
               <b>{{$team['opponentTeamName']}}</b>
               @lang('cricket.so_got') <i style="color:green">{{$team['points']}}</i> @lang('cricket.points_for_this_match')
            </div>
            @php
            $totalPoints = $totalPoints + $team['points'];
            @endphp
            <br/>
            @endforeach
        
            <br/><br/>
            <div>
                @lang('cricket.so')<b>{{ ($data[0]['teamName']) ?? 'n/a' }}</b>
                @lang('cricket.gottotal') <i style="color:green">{{$totalPoints}}</i> @lang('cricket.points')
            </div>
        @else    
            <br/><br/>
            <b>@lang('cricket.no_data_found')</b>
        @endif    
    </body>
</html>
