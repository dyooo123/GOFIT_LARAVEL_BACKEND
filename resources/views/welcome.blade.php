<!Doctype html>
        <html lang="en">

        <head>
        <link rel="stylesheet"href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- Bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <link rel="stylesheet" href="./style.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap" rel="stylesheet">
            <script
             src="https://code.jquery.com/jquery-3.4.1.min.js"
             integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
             crossorigin="anonymous"></script>
              <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
             <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
             <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/i18n/id.js" type="text/javascript"></script>
            <title>Dashboard!</title>
            <style>
                * {
                    ont-family: "Poppins";
                }

                .side-bar {
                    width: 260px;
                    background-color: #212A3E;
                    min-height: 100vh;
                }

                a {
                    padding-left: 10px;
                    font-size: 13px;
                    text-decoration: none;
                    color:#EBD8B2;
                }

                .menu i {
                    padding-left: 20px;
                }

                .menu .content-menu {
                    padding: 9px 7px;
                }

                .isActive {
                    background-color: #071853 !important;
                    border-right: 8px solid #010E2F;
                }

                i {
                    color: white;
                }
            </style>
        </head>

        <body>
            <aside>
                <div class="d-flex">
                    <div class="side-bar">
                        <h2 class="fas fa-heartbeat text-light text-center pt-2 " style="letter-spacing: 5px; color:#EBD8B2">GOFIT STUDIO</h2>
                        <hr>
                        <div class="menu">
                            <div class="content-menu">
                                <i class="fa fa-user"></i>
                                <a href="./profilePage.php" style="font-weight:600">Data Member</a>
                            </div>
                            <div class="content-menu">
                                <i class="fa fa-book"></i>
                                <a href="./listBuku.php" style="font-weight:600">Reset Password</a>
                            </div>
                            <div class="content-menu ">
                                <i class="fa fa-sign-out"></i>
                                <a href="../process/logoutProcess.php" style="font-weight:600">&nbspLogout</a>
                            </div>
                            <hr>
                        </div>
                    </div>

                    <div class="">
                        @yield('main')
                    </div>

                </body>