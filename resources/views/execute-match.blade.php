<!DOCTYPE html>
<html>
    <head> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="{!! asset('js/custom.js') !!}"></script>
        <style>
            .fl{float:left;}
            .cfx{clear:both;}
            .div-width {width:400px;}
            .div2-width {width:95px;}
            .adjust-div{margin-top: 15px;}
            .mrg-lft{margin-left: 200px;}
            .err-msg{margin-left:130px;color:red;}
            .d-none{display:none;}
            .astrix{color:red;}
        </style>
    </head>
    <body>
        
        <br/>
        <a href="{{env('BASE_URL').'home'}}">@lang('cricket.back')</a>
        <br/>
        
        <h2 class="mrg-lft">
            @lang('cricket.play_match') 
        </h2>
        
        <br/><br/><br/><br/><br/>
        {!! Form::open(['id'=>'teamMatch']) !!}
        
        <div class="fl div-width">
            {{Form::label('teamOneId','Select Team One')}} <span class="astrix">*</span>
            {{Form::select('teamOneId',$data, '',['id' => 'teamOne','class'=> 'target'])}}
        </div>
        
        <div class="fl div-width">
            {{Form::label('teamTwoId','Select Team Two')}} <span class="astrix">*</span>
            {{Form::select('teamTwoId',$data, '',['id' => 'teamTwo','class'=> 'target'])}}
            <div class="err-msg d-none teamTwoId">{{config('constants.messages.duplicateTeam')}}</div>
        </div>
        
        <div class="fl div-width">
            {{Form::label('winnerId','Select Match Result')}} <span class="astrix">*</span>
            {{Form::select('winnerId',[ 'teamOne'=>'Team One Winner','teamTwo'=>'Team Two Winner','draw'=> 'Match Draw'], '',['id' => 'winner'])}}
        </div>
        {{Form::hidden('domain', env('BASE_URL'),['id'=> 'domain']) }}
        <br/><br/><br/><br/>
        <div class="mrg-lft">
            {{Form::button('Save', ['id' => 'executeMatch', 'type'=> "button"]) }}
        </div>
        {!! Form::close() !!}
    </body>    
</html>
