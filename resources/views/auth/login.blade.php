<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="{{url('css/output.css')}}" >
        <link rel="stylesheet" href="{{url('MaterialDesignIcons6/css/materialdesignicons.min.css')}}";>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
   </head>

   <body>
        <div class="Mcontainer h100vh aiC"  >
            <div id="formLogin" class="bodyFlexRow800" >
                <div class="Abg radiusL10"> 
                </div>  
                <div class="Flogin bdark radiusR10" > 
                    <div class="tcenter">
                        <h2 class="pm0 cinfo">BAPPEDA</h2>
                        <h6><u>Badan Perencanaan Pembangunan Daerah</u></h6> 
                    </div> 
                    <form method="POST" action="{{ route('login') }}">
                        <div class="fcookie fzL3 flexR aiC jcC">
                            <h2 style="display:inline">Si      P</h2><p>ertanggung</p>
                            <h2 style="display:inline">`        J</h2><p>awaban</p>
                        </div> 
                        @csrf 
                        <div class="">
                            <label for="email" class="">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="pwrap">
                            <label for="password" class="">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="pwrap">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </form>  
                    <small class="tcenter fziconS">
                        bappeda-Sumbawa Barat
                        <span class="mdi mdi-copyright cdanger "></span>
                        2023
                    </small>
                </div>
            </div> 
        </div> 
   </body>

</html>
