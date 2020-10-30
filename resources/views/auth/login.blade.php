
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HR Employee Information Portal') }}</title>

    <!-- Styles -->
    <link href="{{asset('css/all.css')}}" rel="stylesheet">
    <link href="{{asset('css/login.css')}}" rel="stylesheet">

        <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://storage.googleapis.com/code.getmdl.io/1.1.0/material.indigo-pink.min.css">
    <script src="https://storage.googleapis.com/code.getmdl.io/1.1.0/material.min.js"></script>

    <style>
        .title{
                font-family: 'Montserrat', sans-serif ! important;
        }
    </style>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    
    <div class="wrapper">
        <div class="register-background"> 
            <div class="filter-black"></div>
                <div class="container">
                    <div class="row">

                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                                                             <div class="alert alert-warning alert-with-icon" data-notify="container">
                                    <button type="button" aria-hidden="true" class="close">×</button>
                                    <span data-notify="icon" class="ti-announcement"></span> Announcement
                                    <span data-notify="message">

                                        <ul>
                                            <li>
                                                Email Address – <strong>firstname.lastname</strong> ex. Juan.delacruz@lafilipinauygongco.com / company.com 
                                            </li>
                                            <li>
                                                Password – the default password is your <strong>first</strong> and <strong>last</strong> name separated by a dot “ . “ ex. juan.delacruz
                                            </li>
                                        </ul>
                                    </span>
                                </div>

                        </div>
                    </div>


                        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1 ">
                            <div class="register-card">
                                <h5 class="title text-center">
                                <img class="img-responsive" src="{{asset('/img/front-logo.png')}}" style="display: block; margin: 10px auto; width: auto; height: 100px;">
                                </h5>
                    <form class="register-form" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                                    <label>Email</label>
                                    <input id="email" type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                                    <label>Password</label>
                                        <input id="password" type="password" placeholder="Password" class="form-control" name="password" required>
                                                                        @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                                    <button type="submit" class="btn btn-info btn-block btn-submit-user">Login</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>     

        </div>
    </div>      

</body>

    <!-- Scripts -->
      <script src="{{asset('js/jquery.min.js')}}"></script>
      @include('flashy::message')
     <script src="{{asset('js/bootstrap.min.js')}}"></script>
      <script src="{{ asset('js/select2.min.js') }}"></script>
      <script src="{{ asset('js/select2.full.js') }}"></script>
     <!-- vue js -->
     <script src="{{ asset('js/vue.js') }}"></script>
     <script src="{{ asset('js/vue-resource.js') }}"></script>
     <script src="{{ asset('js/vue-custom.js') }}"></script>

     <!-- paper theme -->
     <script src="{{ asset('js/paper.js') }}"></script>
     
    <!-- datatables   -->  
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/responsive.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.columnFilter.js') }}"></script>
    <script src="{{ asset('js/dataTables.tableTools.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
   

    @yield('dependent_list')


   <!-- InputMask -->
    <script src="{{asset('js/jquery.inputmask.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.inputmask.extensions.js')}}" type="text/javascript"></script>

    <script src="{{ asset('js/custom.js') }}"></script>

        <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
 
</html>





