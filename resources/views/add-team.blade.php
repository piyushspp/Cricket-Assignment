<!DOCTYPE html>
<html>
    <head> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="{!! asset('js/custom.js') !!}"></script>
        <style>
            .fl{float:left;}
            .cfx{clear:both;}
            .div-width {width:90px;}
            .div2-width {width:95px;}
            .adjust-div{margin-top: 15px;}
            .mrg-lft{margin-left: 100px}
            .err-msg{margin-left:90px;color:red;}
            .d-none{display:none;}
            .astrix{color:red;}
        </style>
    </head>
    
    <body>
        <br/>
        <a href="{{env('BASE_URL').'home'}}">@lang('cricket.back')</a>
        <br/><br/>
        
        <h2 class="mrg-lft">{{isset($team['teamId']) ?'Edit': 'Add'}} @lang('cricket.team') :</h2>
        <br/><br/>
        
        {!! Form::open(['id'=>'form']) !!}
        <div class="fl div-width">
            {{Form::label('name','Team Name')}}<span class="astrix">*</span>
        </div>
        {{Form::text('name', ($team['name']) ?? '',['id'=> 'name','maxlength'=> 30]) }}<br/>
        <div class="err-msg d-none t-name">{{config('constants.messages.fill_team_name')}}</div>
        
        <br/><br/>
        <div class="fl div-width">
            {{Form::label('state','Club State')}}<span class="astrix">*</span>
        </div>
        {{Form::text('state', ($team['clubState']) ?? '',['id'=> 'state','maxlength'=> 30]) }}
        <div class="err-msg d-none s-name">{{config('constants.messages.fill_state_name')}}</div>
        
        <br/><br/>
        {{Form::hidden('domain', env('BASE_URL'),['id'=> 'domain']) }}
        {{Form::hidden('teamId', ($team['teamId']) ?? '',['id'=> 'teamId']) }}
        <div class="mrg-lft">
            {{Form::button(isset($team['teamId']) ?'Update': 'Save', ['id' => 'addTeam', 'type'=> "button"]) }}
        </div>
        {!! Form::close() !!}
    </body>    
</html>
