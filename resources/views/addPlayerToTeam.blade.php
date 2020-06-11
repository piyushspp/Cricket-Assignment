<!DOCTYPE html>
<html>
    <head> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="{!! asset('js/custom.js') !!}"></script>
        <style>
            .fl{float:left;}
            .cfx{clear:both;}
            .div-width {width:200px;}
            .div2-width {width:95px;}
            .adjust-div{margin-top: 15px;}
            .mrg-lft{margin-left: 200px;}
            .err-msg{margin-left:200px;color:red;}
            .d-none{display:none;}
            .astrix{color:red;}
        </style>
    </head>
    <body>
        
        <br/>
        <a href="{{env('BASE_URL').'home'}}">@lang('cricket.back')</a>
        <br/>
        
        <h2 class="mrg-lft">
            @lang('cricket.add_player_to_team') {{$result['teamData']['name']}} 
        </h2>
        
        <br/>
        {!! Form::open(['id'=>'addplayertoteam']) !!}
        
        {{Form::label('playerId','Select Player')}} <span class="astrix">*</span>
        {{Form::select('playerId',$result['players'], '',['id' => 'playerId'])}}
 
        <br/><br/>
        {{Form::hidden('domain', env('BASE_URL'),['id'=> 'domain']) }}
        {{Form::hidden('teamId', ($result['teamData']['teamId']) ?? '',['id'=> 'teamId']) }}
        <br/><br/>
        <div class="mrg-lft">
            {{Form::button('Save', ['id' => 'addPlayerToTeam', 'type'=> "button"]) }}
        </div>
        {!! Form::close() !!}
    </body>    
</html>
