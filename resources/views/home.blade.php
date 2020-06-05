<!DOCTYPE html>
<html>
    <head> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="{!! asset('js/custom.js') !!}"></script>
        <style>
            .fl{float:left;}
            .cfx{clear:both;}
            .div-width {width:200px;}
            .adjust-div{margin-top: 15px;}
            .div-margin-header{margin-left: 30px;}
            .div-margin{margin-left: 20px;}
        </style>
    </head>
    <body>
        <br/>
        <div>
            <div class="fl">
                <h2>{{ Html::tag('a','Team List', ['href' => env('BASE_URL').'home/']) }}</h2>
            </div> 
            <div class="fl div-margin-header">
                <h2>{{ Html::tag('a','Add Team', ['href' => env('BASE_URL').'team/']) }}</h2>
            </div>
            <div class="fl div-margin-header">
                <h2>{{ Html::tag('a','Player List', ['href' => env('BASE_URL').'player-list/']) }}</h2>
            </div>
            <div class="fl div-margin-header">
                <h2>{{ Html::tag('a','Add Player To System', ['href' => env('BASE_URL').'player/']) }}</h2>
            </div>
            <div class="fl div-margin-header">
                <h2>{{ Html::tag('a','Play Match', ['href' => env('BASE_URL').'match']) }}</h2>
            </div>
            <div class="fl div-margin-header">
                <h2>{{ Html::tag('a','Team Points Table', ['href' => env('BASE_URL').'team-points-table']) }}</h2>
            </div>
            <div class="cfx"></div>
        </div>
        <br/><br/>
        
        
        @if(!empty($data))
        <b>@lang('cricket.teamlist'):--</b><br/><br/>
            @foreach ($data as $team)
            <div class="fl div-width">
                <span>
                    {{ Html::image(asset('images/'.$team['logoUri']), $team['logoUri'], array( 'width' => 60, 'height' => 60 )) }}
                </span>
            </div>
            <div class="fl div-width adjust-div">
                {{ Html::tag('a',($team['name']) ?? 'n/a', ['href' => env('BASE_URL').'team-detail/'.$team['teamId']]) }}
            </div>
            <div class="fl adjust-div div-margin">
                {{ Html::tag('a','Edit Team', ['href' => env('BASE_URL').'team/'.$team['teamId']]) }}
            </div>
            <!--
            <div class="fl adjust-div div-margin">
                {{ Html::tag('a','Delete Team', ['href' => 'javascript:void(0)','id'=> $team['teamId'], 'class'=>'deleteTeam','domain'=>env('BASE_URL')]) }}
            </div>-->
            <div class="fl adjust-div div-margin">
                {{ Html::tag('a','Add Player To Team', ['href' => env('BASE_URL').'add-playerto-team/'.$team['teamId']]) }}
            </div>
            <div class="cfx"></div><br/>
            @endforeach
        @endif
    </body>
</html>
