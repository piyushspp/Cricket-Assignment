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
        
        <h2 class="mrg-lft">{{isset($player['playerId']) ?'Edit': 'Add'}} @lang('cricket.player') :</h2>
        
        <br/>
        {!! Form::open(['id'=>'playerForm']) !!}
        
        <div class="fl div-width">
            {{Form::label('firstName','First Name')}}<span class="astrix">*</span>
        </div>
        {{Form::text('firstName', ($player['firstName']) ?? '',['id'=> 'firstName', 'maxlength'=> 30]) }}
        <div class="err-msg d-none f-name">{{config('constants.messages.fill_first_name')}}</div>
        
        <br/><br/>
        <div class="fl div-width">
            {{Form::label('lastName','Last Name')}}<span class="astrix">*</span>
        </div>    
        {{Form::text('lastName', ($player['lastName']) ?? '',['id'=> 'lastName','maxlength'=> 30 ])}}
        <div class="err-msg d-none l-name">{{config('constants.messages.fill_last_name')}}</div>
        
        <br/><br/>
        <div class="fl div-width">
            {{Form::label('playerJersyNumber','Player Jersy Number')}}<span class="astrix">*</span>
        </div>    
        {{Form::text('playerJersyNumber', ($player['playerJersyNumber']) ?? '',['id'=> 'playerJersyNumber','maxlength'=> 3]) }}
        <div class="err-msg d-none jersy-number">{{config('constants.messages.fill_jersy_no')}}</div>
        
        <br/><br/>
        <div class="fl div-width">
            {{Form::label('country','Country')}}<span class="astrix">*</span>
        </div>    
        {{Form::text('country', ($player['country']) ?? '',['id'=> 'country','maxlength'=> 10]) }}
        <div class="err-msg d-none country">{{config('constants.messages.fill_country_name')}}</div>
        
        <br/><br/>
        <div class="fl div-width">
            {{Form::label('matches','Matches')}}<span class="astrix">*</span>
        </div>    
        {{Form::text('matches', ($player['matches']) ?? '',['id'=> 'matches','maxlength'=> 3]) }}
        <div class="err-msg d-none matches">{{config('constants.messages.fill_matches')}}</div>
        
        <br/><br/>
        <div class="fl div-width">
            {{Form::label('run','Run')}}<span class="astrix">*</span>
        </div>
        {{Form::text('run', ($player['run']) ?? '',['id'=> 'run','maxlength'=> 5]) }}
        <div class="err-msg d-none run">{{config('constants.messages.fill_run')}}</div>
        
        <br/><br/>
        <div class="fl div-width">
            {{Form::label('highestScore','highest Score')}}<span class="astrix">*</span>
        </div>
        {{Form::text('highestScore', ($player['highestScore']) ?? '',['id'=> 'highestScore','maxlength'=> 3]) }}
        <div class="err-msg d-none h-score">{{config('constants.messages.fill_high_score')}}</div>
        
        <br/><br/>
        <div class="fl div-width">
            {{Form::label('fifties','Fifties')}}<span class="astrix">*</span>
        </div>
        {{Form::text('fifties', ($player['fifties']) ?? '',['id'=> 'fifties','maxlength'=> 2]) }}
        <div class="err-msg d-none fifties">{{config('constants.messages.fill_fifties')}}</div>
        
        <br/><br/>
        <div class="fl div-width">
            {{Form::label('hundreds','Hundreds')}}<span class="astrix">*</span>
        </div>
        {{Form::text('hundreds', ($player['hundreds']) ?? '',['id'=> 'hundreds','maxlength'=> 2]) }}
        <div class="err-msg d-none hundreds">{{config('constants.messages.fill_hundred')}}</div>
        
        
        <br/><br/>
        <div class="fl div-width">
            {{Form::label('imageUri','Image')}}<span class="astrix">*</span>
        </div>
        
        @if(isset($player['playerId']))
            {{ Html::image(asset('images/'.$player['imageUri']), $player['imageUri'], array( 'width' => 60, 'height' => 60 )) }}
        <br/><br/>
        <div class="fl div-width">
            {{Form::label('imageUri','Change Image?')}}<span class="astrix"></span>
        </div>    
        @endif
        {{Form::file('imageUri',['id'=> 'imageUri'])}}
        <div class="err-msg d-none playerImage-name">{{config('constants.messages.upload_image')}}</div>
        <div class="err-msg d-none valid-image">{{config('constants.messages.valid-image')}}</div>
        
        
        <br/><br/>
        {{Form::hidden('domain', env('BASE_URL'),['id'=> 'domain']) }}
        {{Form::hidden('playerId', ($player['playerId']) ?? '',['id'=> 'playerId']) }}
        <br/><br/>
        <div class="mrg-lft">
            {{Form::button(isset($player['playerId']) ?'Update': 'Save', ['id' => 'add-edit-player', 'type'=> "button"]) }}
        </div>
        {!! Form::close() !!}
    </body>    
</html>
