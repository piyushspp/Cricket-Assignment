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
        <title>Register Form</title>
    </head>
    <body>
        
        <h3>Create Account</h3>
        <div class="">
            {!! Form::open(['id'=>'regForm']) !!}    
                {{ csrf_field() }}
                <div class="fl div-width">
                    {{Form::label('name','Name')}}<span class="astrix">*</span>
                </div>
                {{Form::text('name', '',['id'=> 'name','maxlength'=> 30]) }}<br/>
                <div class="err-msg d-none u-name">{{config('constants.messages.fill_name')}}</div>
                <br/>
                
                <div class="fl div-width">
                    {{Form::label('email','Email')}}<span class="astrix">*</span>
                </div>
                {{Form::text('email', '',['id'=> 'email','maxlength'=> 30]) }}<br/>
                <div class="err-msg d-none email">{{config('constants.messages.fill_email')}}</div>
                <br/>
                
                <div class="fl div-width">
                    {{Form::label('password','Password')}}<span class="astrix">*</span>
                </div>
                {{Form::text('password', '',['id'=> 'password','maxlength'=> 30]) }}<br/>
                <div class="err-msg d-none password">{{config('constants.messages.fill_password')}}</div>
                <br/> 
                
                {{Form::button('Create Account', ['id' => 'signup', 'type'=> "button"]) }}
            {!! Form::close() !!}
        </div>
        <a href="{{url('login')}}">Have an account? Go to login</a>
                                           
    </body>
</html>