<!DOCTYPE html>
<html>
    <head> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="{!! asset('js/custom.js') !!}"></script>
        <style>
            .fl{float:left;}
            .cfx{clear:both;}
            .div-width {width:200px;}
            .adjust-div{margin-top: 15px;margin-left: 80px;}
            .div-margin-header{margin-left: 30px;}
            .div-margin{margin-left: 20px;}
            .adjust-image{margin-top: 10px;}
        </style>
    </head>
    <body>
        <br/>
        <h2><a href="{{env('BASE_URL').'home'}}">@lang('cricket.back')</a></h2>
           
        <br/><br/>
        <h3>@lang('cricket.phpunit_text')</h3>
        <div>
            <b>This will perform <i style="color:blue;">random matches</i> between teams and deciding match results followed 
                by updation of points , matches , match result w.r.t each team in database.
                <br/><br/>
                In order to view the details around passed test cases, file needs to be opened as-is into MS Office Excel
                /LibreOffice / OpenOffice Calc P.S. While opening file, the field separator has to be a PIPE ( | ) symbol.
            </b>
        </div>
        
        
    </body>
</html>
