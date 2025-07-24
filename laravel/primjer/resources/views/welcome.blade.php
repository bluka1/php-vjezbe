<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links {
              margin-bottom: 40px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                @php
                    use Illuminate\Support\Facades\Route;
                    // $routes = collect(Route::getRoutes())->filter(function ($route) {
                    //     return in_array('GET', $route->methods())
                    //         && $route->uri()
                    //         && !str_contains($route->uri(), '{')
                    //         && !str_contains($route->uri(), 'up')
                    //         && !str_contains($route->uri(), 'order');
                    // });
                    $links = Route::getRoutes();
                    $routes = [];
                    foreach ($links as $route) {
                        $methods = $route->methods();
                        if (
                          in_array('GET', $methods) 
                          && $route->uri() 
                          && !str_contains($route->uri(), '{')
                          && !str_contains($route->uri(), 'up')
                          && !str_contains($route->uri(), 'order')) 
                        {
                            $routes[] = $route;
                        }
                    }

                @endphp

                @foreach ($routes as $route)
                    <a href="{{ url($route->uri()) }}">{{ $route->uri() }}</a>
                @endforeach
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://vapor.laravel.com">Vapor</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>
