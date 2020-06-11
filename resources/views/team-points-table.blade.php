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
        
        <br/><br/>
        <table>
    <thead>
        <tr>
            <th> Team Name</th>
            <th> Points  </th>
        </tr>
    </thead>
    <tbody>
         @foreach($data as $team)
          <tr>
              <td> {{$team['name']}} </td>
              <td> {{$team['teamPoints']}} </td>
          </tr>
         @endforeach
   </tbody>
</table>
        <div class="fl div-width">
        </div>
        
    </body>    
</html>
