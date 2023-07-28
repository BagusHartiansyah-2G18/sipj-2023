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

        <div class="wrapLogin1 mh650p">
            <div class="wrap bdark clight">
                <div class="logo">
                    <img src="/logo/ksb.png" />
                </div>
                <div>
                    <h2>BAPPEDA</h2>
                    <p>Badan Perencanaan Pembangunan Daerah</p>
                </div>
                <div class="subitem">
                    <div class="" id="kanan">
                        <span class="mdi mdi-login cinfo"></span>
                    </div>
                    <div class="binfo" id="text"><span class="title"> Login Sistem</span></div>
                </div>
            </div>
            <div class="login blight">
                <div class="wrap">

                    <div class="form">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="tjudul"><p>Sistem Administrasi Pertanggung Jawaban</p> </div>
                            <div class="pwrap">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="pwrap">
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
                    </div>
                </div>
            </div>
        </div>
        <div class="flexC bmuted">
            <div class="flexR algI m0auto pwrap">
                <h2 class="tjudul clight fziconS">
                    Sumbawa Barat
                    <span class="mdi mdi-copyright cdanger "></span>
                    2023
                </h2>
            </div>

        </div>
   </body>

</html>
