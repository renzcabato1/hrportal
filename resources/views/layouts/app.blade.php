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
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/select2-bootstrap.min.css')}}" rel="stylesheet">


    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet'>

    <link rel="stylesheet" href="https://storage.googleapis.com/code.getmdl.io/1.1.0/material.indigo-pink.min.css">
    
    <link href="{{asset('css/chosen.min.css')}}" rel="stylesheet">
    
    <link href="{{asset('css/new_style.css')}}" rel="stylesheet">

    <script src="https://storage.googleapis.com/code.getmdl.io/1.1.0/material.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

    

    

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>



@if (Auth::check())
   <nav class="navbar navbar-inverse navbar-fixed-top" style="margin-bottom: 0 ! important;">
        <div class="container">
            <div class="navbar-header" style="margin-left: 190px;">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand brand-hr" href="{{ url('/home') }}">
                        @if(Request::path() == 'home')
                            Dashboard
                        @elseif(str_contains(Request::path(),'employees'))
                            Employees
                        @elseif(str_contains(Request::path(),'users'))
                            Users
                        @elseif(str_contains(Request::path(),'roles'))
                            Roles
                        @elseif(str_contains(Request::path(),'company'))   
                            Company
                        @elseif(str_contains(Request::path(),'activities'))
                            Activities
                        @elseif(str_contains(Request::path(),'department'))
                            Department
                        @elseif(str_contains(Request::path(),'location'))
                            Location
                        @elseif(str_contains(Request::path(),'address'))
                            Address    
                        @elseif(str_contains(Request::path(),'totalUpdate'))
                            Total Update  
                        @elseif(str_contains(Request::path(),'head'))
                            Head Positions
                        @elseif(str_contains(Request::path(),'level'))
                            Levels
                        @elseif(str_contains(Request::path(),'marital_status'))
                            Marital Status    
                        @elseif(str_contains(Request::path(),'employee_approval_request'))
                            Employee Approval Requests    
                        @elseif(str_contains(Request::path(),'organizational_chart'))
                            Organizational Chart    
                        @else
                            Nope
                        @endif
                </a>


            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
 
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">
                    {{ Auth::user()->name}}
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                      
                    <li>
                            <a href="{{ url('/employee_approval_request') }}"  aria-expanded="false">
                            @if(session('notifications') > 0) <span class="label label-warning">{{ session('notifications')  }}</span> @endif  Employee Approval Requests 
                            </a>
                    </li>
                   
                      <li>
                            <a href="{{ url('/logout') }}"  aria-expanded="false">
                             <i class="fa fa-sign-out" aria-hidden="true"></i>  Logout 
                            </a>
                      </li>

                    </ul>
                  </li>
                  
                @if(Auth::user()->hasRole('Administrator'))
                <li class="hidden-md hidden-lg">
                    <a href="{{url('/employees')}}">
                    <i class="pe-7s-server"></i>
                    Employees
                    </a>
                </li>
                @else
                <li class="hidden-md hidden-lg">
                    <a href="{{url('/home')}}">
                    <i class="pe-7s-home"></i>
                    Home
                    </a>
                </li>
                @endif

                   
                </ul>


            </div>


        </div><!-- end nav container -->

    
    </nav>


      <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        HR Information Portal
                   <!--      <img class="img-responsive" src="{{asset('img/front-logo.png')}}" style="width: auto; height: 50px; display: block; margin: 10px auto;"> -->
                    </a>
                </li>

                @if(Auth::user()->hasRole('Administrator')  || Auth::user()->hasRole('HR Staff'))
                 <li>
                    <a href="{{url('/home')}}">
                    <i class="pe-7s-edit"></i>
                    Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{url('/employees')}}">
                    <i class="pe-7s-server"></i>
                    Employees
                    </a>
                </li>
                <li>
                    <a href="{{url('/users')}}">
                    <i class="pe-7s-users"></i>
                    Users
                    </a>
                </li>
                <li>
                    <a href="{{url('/roles')}}">
                    <i class="pe-7s-unlock"></i>
                    Roles
                    </a>
                </li>
                <li>
                    <a href="{{url('/company')}}">
                    <i class="pe-7s-settings"></i>
                    Manage Fields
                    </a>
                </li>
                <li>
                    <a href="{{url('/activities')}}">
                    <i class="pe-7s-note2"></i>
                    Activity log
                    </a>
                </li>
                
                @else
                    <li>
                        <a href="{{url('/home')}}">
                        <i class="pe-7s-home"></i>
                        Home
                        </a>
                    </li>
                    @if(Auth::user()->hasRole('Administrator Printer'))
                    <li>
                        <a href="{{url('/employees')}}">
                        <i class="pe-7s-server"></i>
                        Employees
                        </a>
                    </li>
                    @endif
                @endif
               
   
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                           
                            <div class="se-pre-con">
                            <div class="loader"></div>
                            </div>
                                @yield('content')


                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->


<nav class="navbar navbar-inverse navbar-bottom hidden-xs hidden-sm">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">HR Employee Information Portal</a>
    </div>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#">La Filipina Uy Gongco Group of Companies</a></li>
    </ul>
  </div>
</nav>

  @endif



</body>

    <!-- Scripts -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
      <script src="{{asset('js/jquery.min.js')}}"></script>
      <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
      @include('flashy::message')

      <!--- wizard js -->
     <script src="{{asset('js/jquery.bootstrap.wizard.js')}}"></script>
     <script src="{{asset('js/paper-bootstrap-wizard.js')}}"></script>
     <script src="{{asset('js/jquery.validate.min.js')}}"></script>

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

   
    <script type="text/javascript" src="{{asset('js/chosen.jquery.min.js')}}"></script>

     <!-- Include this after the sweet alert js file -->
    @include('sweet::alert')
    @yield('dependent_list')
    @yield('assigned_head_list')
    @yield('verify_bank_account')
    @yield('marital_attachment')
    @yield('division_list')


   <!-- InputMask -->
    <script src="{{asset('js/jquery.inputmask.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.inputmask.extensions.js')}}" type="text/javascript"></script>

    <script src="{{ asset('js/custom.js') }}"></script>

   

        <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        setTimeout(function(){
        $("#wrapper").toggleClass("toggled");
        }, 3000);
    });
    </script>

    <script>
            $(window).load(function() {
        // Animate loader off screen
        $(".loader, .se-pre-con").fadeOut("slow");
    });
    </script>


 


</html>
