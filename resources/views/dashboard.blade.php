<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive sidebar template with sliding effect and dropdown menu based on bootstrap 3">
	<title>Mikman</title>
    {{--Custom Button--}}
    {{--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">--}}

    <link rel="stylesheet" href="{{asset('dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.mCustomScrollbar.min.css')}}">
    
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/sidebar-themes.css')}}">
    <link rel="shortcut icon" type="image/png" href="{{asset('img/icon.png')}}" />
    
    {{--Swall Fire--}}
    {{--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>--}}
    <script type="text/javascript" src="{{asset('js/sweetalert2.all.min.js')}}"></script>
    
    <script src="{{asset('js/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/jquery/jquery.mCustomScrollbar.concat.min.js')}}"></script>

    <script src="{{asset('dist/js/bootstrap.min.js')}}"></script>

</head>

<body>
    <div class="page-wrapper default-theme bg1 toggled">
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <!-- sidebar-brand  -->
                <div class="sidebar-item sidebar-brand" style="margin: 20px">
                    <img src="{{asset('img/binus_it.png')}}" width="200px">
                </div>
                <div class="sidebar-item sidebar-brand" >
                    <a href="javascript:;" onclick="showInfo()" style="text-align: center">MIKROTIK VPN MANAGEMENT</a>
                </div>
                <!-- sidebar-header  -->
                @if(Session::get('login'))
                <div class="sidebar-item sidebar-header d-flex flex-nowrap" style="align-content: center;text-align: center">
                    <div class="user-pic">
                        <img class="img-responsive img-rounded" src="img/{{Session::get("image")}}" onerror="this.src='img/user.jpg';">
                    </div>
                    <div class="user-info">
                        <span class="user-name">Hello,
                            <strong>{{Session::get('login')}}</strong>
                        </span>
                        <span class="user-role">Administrator</span>
                        <span class="user-status">
                            <i class="fa fa-circle"></i>
                            <span>Online</span>
                        </span>
                        <span style="margin-top: 10px">
                            <a href="/logout">
                                <button class="btn btn-danger">Logout</button>
                            </a>
                        </span>
                    </div>
                </div>
                @endif
                <!-- sidebar-search  -->
                <div class="sidebar-item sidebar-search">
                    <div>
                        <div class="input-group">
                            <input type="text" class="form-control search-menu" onkeydown="searchExtension(event.keyCode)" placeholder="Search vpn, name, division..." >
                            <div class="input-group-append" onclick="searchExtension('13')">
                                <span class="input-group-text">
                                    <!-- <i class="fa fa-search" aria-hidden="true"></i> -->
                                    <img src="img/search.png" width="20px">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- sidebar-menu  -->
                <div class="sidebar-item sidebar-menu">
                    <ul>
                        <li class="sidebar-dropdown info active" style="padding: 0px;border-top: 1px solid #ffffff;">
                            <a href="#" id="show-request" onclick="showRequest(this)">
                                <span class="menu-text" style="padding:10px 0 10px 10px;">Request</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>
            <!-- sidebar-footer  -->
        </nav>

        <!-- page-content  -->
        <main class="page-content pt-2">
            <div id="toggle-sidebar"><img id="arrowImg" src="img/prev.png"></div>
            <div id="overlay" class="overlay"></div>
            <div class="container-fluid p-5 syahdanImage">
                <div class="row">
                    <img src="" alt="">
                </div>
            </div>

            <div class="table-height" style="display: none;"></div>

        </main>
        <!-- page-content" -->

        <div class="modal fade bd-example-modal-lg" id="modal-action" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Login MikroTik</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <strong><h5>Password:</h5></strong>
                        <p id="error"></p>
                        <input type="password" id="password" placeholder="MikroTik Password" class="form-control" name="password">
                        <input type="hidden" id="command" name="command">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="relogin()">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- page-wrapper -->

</body>
</html>

<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/mikman.js')}}"></script>

<script type="text/javascript">
    // Mengambil Data pada setip baris di tombol create/add
    //  $(".getRow").click(function(){
    //     var $row = $(this).closest("tr");
    //     var $tickNum = $row.find(".tickNum").text();
    //     var $uName = $row.find(".uName").text();
    //     var $eMail = $row.find(".eMail").text();
    //     var $div = $row.find(".div").text();
    //     var $stat = $row.find(".stat").text();
    //     var $ip = $row.find(".ip").text();
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },    
    //         url: 'createVPN',
    //         type: "post",
    //         data: {
    //             tickNum : $tickNum,
    //             uName : $uName,
    //             eMail : $eMail,
    //             div : $div,
    //             stat : $stat,
    //             ip : $ip
    //             // test : "ini datanya"
    //         },
    //             success: function(response){ // What to do if we succeed
    //             if(data != null){
    //                 alert("data ada");
    //             }
    //             // alert(response); 
    //             // alert(data);
    //             },
    //         function(data, status){
    //             alert('value stored');
    //         }
    //     // var $text = $row.find(".tickNum,.uName,.eMail,.div,.stat,.ip").text();
    //     // alert($text);

    //     });
    // });