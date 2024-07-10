
<html lang="en">

<head>
<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AdminLTE 3 | Starter</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

        <link rel="stylesheet" href="dist/css/adminlte.min.css?v=3.2.0">
        <script nonce="4cd21327-a31b-46e3-bf3a-b8a625b1a878">
            try {
                (function(w, d) {
                    ! function(U, V, W, X) {
                        U[W] = U[W] || {};
                        U[W].executed = [];
                        U.zaraz = {
                            deferred: [],
                            listeners: []
                        };
                        U.zaraz._v = "5705";
                        U.zaraz.q = [];
                        U.zaraz._f = function(Y) {
                            return async function() {
                                var Z = Array.prototype.slice.call(arguments);
                                U.zaraz.q.push({
                                    m: Y,
                                    a: Z
                                })
                            }
                        };
                        for (const $ of ["track", "set", "debug"]) U.zaraz[$] = U.zaraz._f($);
                        U.zaraz.init = () => {
                            var ba = V.getElementsByTagName(X)[0],
                                bb = V.createElement(X),
                                bc = V.getElementsByTagName("title")[0];
                            bc && (U[W].t = V.getElementsByTagName("title")[0].text);
                            U[W].x = Math.random();
                            U[W].w = U.screen.width;
                            U[W].h = U.screen.height;
                            U[W].j = U.innerHeight;
                            U[W].e = U.innerWidth;
                            U[W].l = U.location.href;
                            U[W].r = V.referrer;
                            U[W].k = U.screen.colorDepth;
                            U[W].n = V.characterSet;
                            U[W].o = (new Date).getTimezoneOffset();
                            if (U.dataLayer)
                                for (const bg of Object.entries(Object.entries(dataLayer).reduce(((bh, bi) => ({
                                        ...bh[1],
                                        ...bi[1]
                                    })), {}))) zaraz.set(bg[0], bg[1], {
                                    scope: "page"
                                });
                            U[W].q = [];
                            for (; U.zaraz.q.length;) {
                                const bj = U.zaraz.q.shift();
                                U[W].q.push(bj)
                            }
                            bb.defer = !0;
                            for (const bk of [localStorage, sessionStorage]) Object.keys(bk || {}).filter((bm => bm.startsWith("_zaraz_"))).forEach((bl => {
                                try {
                                    U[W]["z_" + bl.slice(7)] = JSON.parse(bk.getItem(bl))
                                } catch {
                                    U[W]["z_" + bl.slice(7)] = bk.getItem(bl)
                                }
                            }));
                            bb.referrerPolicy = "origin";
                            bb.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(U[W])));
                            ba.parentNode.insertBefore(bb, ba)
                        };
                        ["complete", "interactive"].includes(V.readyState) ? zaraz.init() : U.addEventListener("DOMContentLoaded", zaraz.init)
                    }(w, d, "zarazData", "script");
                })(window, document)
            } catch (e) {
                throw fetch("/cdn-cgi/zaraz/t"), e;
            };
        </script>
    @vite(['resources/css/app2.css', 'resources/js/app.js'])


</head>
<nav>
    
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
            {{ __('Log Out') }}
        </x-responsive-nav-link>
    </form>
</nav>



    <body class="hold-transition sidebar-mini">
        <div class="wrapper">

            <nav class="main-header navbar navbar-expand navbar-white navbar-light">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="index3.html" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#" class="nav-link">Contact</a>
                    </li>
                </ul>

 
            </nav>


            <aside class="main-sidebar sidebar-dark-primary elevation-4">

                <a href="index3.html" class="brand-link">
                    <img src="https://i.pinimg.com/originals/f8/98/bf/f898bfb34a80f0784e1417c86a096e13.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">AdminLTE 3</span>
                </a>

                <div class="sidebar">

                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="info">
                            <a href="#" class="d-block">Admin</a>
                        </div>
                    </div>

                    <div class="form-inline">
                        <div class="input-group" data-widget="sidebar-search">
                            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-sidebar">
                                    <i class="fas fa-search fa-fw"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Starter Pages
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link active">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Active Page</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Inactive Page</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Simple Link
                                        <span class="right badge badge-danger">New</span>
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>

                </div>

            </aside>

            <div class="content-wrapper">

                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Starter Page</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Starter Page</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">
                                            Some quick example text to build on the card title and make up the bulk of the card's
                                            content.
                                        </p>
                                        <a href="#" class="card-link">Card link</a>
                                        <a href="#" class="card-link">Another link</a>
                                    </div>
                                </div>
                                <div class="card card-primary card-outline">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">
                                            Some quick example text to build on the card title and make up the bulk of the card's
                                            content.
                                        </p>
                                        <a href="#" class="card-link">Card link</a>
                                        <a href="#" class="card-link">Another link</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="m-0">Featured</h5>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title">Special title treatment</h6>
                                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                        <a href="#" class="btn btn-primary">Go somewhere</a>
                                    </div>
                                </div>
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h5 class="m-0">Featured</h5>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title">Special title treatment</h6>
                                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                        <a href="#" class="btn btn-primary">Go somewhere</a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>


            <aside class="control-sidebar control-sidebar-dark">

                <div class="p-3">
                    <h5>Title</h5>
                    <p>Sidebar content</p>
                </div>
            </aside>


            <footer class="main-footer">

                <div class="float-right d-none d-sm-inline">
                    Anything you want
                </div>

                <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
            </footer>
        </div>
    </body>


    </html>