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
        </style>
    </head>
    <body>
        <br/>
        <a href="{{env('BASE_URL').'home'}}">@lang('cricket.back')</a>
        <br/><br/>
    <h2>{{ Html::tag('a','Add More Players To System', ['href' => env('BASE_URL').'player/']) }}</h2>
        @if(!empty($players))
            <b>@lang('cricket.playerlist'):--</b><br/><br/>
            @foreach ($players as $player)
            <div class="fl div-width">
                <span>
                    {{ Html::image(asset('images/'.$player['imageUri']), $player['imageUri'], array( 'width' => 60, 'height' => 60 )) }}
                </span>
            </div>
            <div class="fl div-width adjust-div">
                {{ Html::tag('a',($player['lastName']) ?? 'n/a', ['href' => env('BASE_URL').'player/'.$player['playerId']]) }}
            </div>
            <div class="fl div-width adjust-div div-margin">
                {{ Html::tag('a',($player['firstName']) ?? 'n/a', ['href' => env('BASE_URL').'player/'.$player['playerId']]) }}
            </div>
            <div class="fl adjust-div div-margin">
                {{ Html::tag('a','Edit Player', ['href' => env('BASE_URL').'player/'.$player['playerId']]) }}
            </div>
            <div class="cfx"></div><br/>
            @endforeach
        @endif
    </body>
</html>
