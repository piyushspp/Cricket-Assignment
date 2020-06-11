<!DOCTYPE html>
<html>
    <head> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="{!! asset('js/custom.js') !!}"></script>
        <style>
            .fl{float:left;}
            .cfx{clear:both;}
            .div-width {width:150px;}
            .adjust-div{margin-top: 15px;margin-left: 100px;}
            .div-margin{margin-left: 80px;}
            .adjust-image{margin-top: 10px;}
        </style>
    </head>
    <body>
        <br/>
        <a href="{{env('BASE_URL').'home'}}">@lang('cricket.back')</a>
        <br/><br/>
        {{ Html::tag('a','Add Player To Team', ['href' => env('BASE_URL').'add-playerto-team/'.$teamId]) }} 
        <br/><br/>      
        @if(!empty($data))
            <b>{{$teamName}} @lang('cricket.players_list') :</b>
            <br/><br/>
            @foreach ($data as $team)
            <div class="fl adjust-image div-width">
                <span>
                    <img width ="60" height="60" src="{{ asset('images/'.$team['imageUri']) }}" alt="{{$team['imageUri']}}">
                </span>
            </div>
            <div class="fl div2-width adjust-div">
                <span>{{ ($team['lastName']) ?? 'n/a' }}</span>
            </div>
            <div class="fl  div2-width  adjust-div">
                <span>{{ ($team['firstName']) ?? 'n/a' }}</span>
            </div>
            <div class="fl adjust-div"> 
                {{ Html::tag('a','Remove Player', ['href' => 'javascript:void(0)','player'=> $team['teamId'],'id'=>$team['playerId'],'class'=>'removePlayer','domain'=>env('BASE_URL')]) }}
            </div>    
            <div class="cfx"></div><br/>
            @endforeach
        
            <br/><br/>
            <a href="{{env('BASE_URL').'team-matches-summary/'.$team['teamId']}}">@lang('cricket.match_summary_of') {{ ($team['name']) ?? 'n/a' }}</a>
            <br/><br/>
            <a href="{{env('BASE_URL').'team-total-points/'.$team['teamId']}}">@lang('cricket.total_points_of') {{ ($team['name']) ?? 'n/a' }}</a>
        @endif     
    </body>
</html>
