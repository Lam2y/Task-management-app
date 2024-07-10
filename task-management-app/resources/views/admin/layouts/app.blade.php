<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Starter</title>


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
</nav>



<body class="hold-transition sidebar-mini" id="app">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/employee/admin" class="nav-link">Home</a>
                </li>
            </ul>


        </nav>


        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="index3.html" class="brand-link">
                <img src="https://i.pinimg.com/originals/f8/98/bf/f898bfb34a80f0784e1417c86a096e13.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">TaskMinder</span>
            </a>

            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <a href="#" class="d-block">
                            @auth
                            <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                            @endauth
                        </a>
                    </div>
                </div>



                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <router-link to="/admin/mainpage" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>

                                <p>
                                    Main Page
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/admin/taskmanagement" class="nav-link">
                                <i class="nav-icon fas fa-tasks"></i>

                                <p>
                                    Task Management
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/admin/leaderboard" class="nav-link">
                                <i class="nav-icon fas fa-trophy"></i>

                                <p>
                                    Leaderboard
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/admin/dashboard" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>

                                <p>
                                    Dashboard
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>

                        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                            @csrf
                            <button type="submit" style="display: none;">{{ __('Log Out') }}</button>
                        </form>

                    </ul>
                </nav>

            </div>

        </aside>

        <div class="content-wrapper">

            <router-view></router-view>

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