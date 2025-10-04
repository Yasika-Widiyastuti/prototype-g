# <?php

#namespace App\Http;

#use Illuminate\Foundation\Http\Kernel as HttpKernel;

#class Kernel extends HttpKernel
#{
    // Middleware global
 #   protected $middleware = [
 #       \App\Http\Middleware\TrustProxies::class,
 #       \Fruitcake\Cors\HandleCors::class,
 #       \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
 #       \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
 #       \App\Http\Middleware\TrimStrings::class,
 #       \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
  #  ];

    // Middleware grup
 #   protected $middlewareGroups = [
 #       'web' => [
#            \App\Http\Middleware\EncryptCookies::class,
#            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
#            \Illuminate\Session\Middleware\StartSession::class,
#            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
#            \App\Http\Middleware\VerifyCsrfToken::class,
#            \Illuminate\Routing\Middleware\SubstituteBindings::class,
#        ],

 #       'api' => [
#            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
#            'throttle:api',
  #          \Illuminate\Routing\Middleware\SubstituteBindings::class,
 #       ],
 #   ];

#    // SESUDAH (BENAR) - untuk Laravel 11+
#    protected $middlewareAliases = [
#        'auth' => \App\Http\Middleware\Authenticate::class,
#        'admin' => \App\Http\Middleware\AdminMiddleware::class,
#        'user.access' => \App\Http\Middleware\UserMiddleware::class,
#    ];
#}
