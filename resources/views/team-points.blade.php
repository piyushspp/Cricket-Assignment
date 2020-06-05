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
        <br/><br/>
        @if(!empty($data))
            @foreach ($data as $team)
            <div>
                <b>{{ $team['name']}}</b>   @lang('cricket.has')
                <i style="color:blue;">{{$team['teamPoints']}} @lang('cricket.points')</i>
            </div>
            <br/>
            @endforeach
        @else    
            <br/><br/>
            <b>@lang('cricket.no_data_found')</b>
        @endif 
    </body>
</html>
