<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    /**
     * Manejar una petición entrante inyectando cabeceras CSP dinámicas.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Definición de directivas permitiendo CDNs esenciales de SiConcilio
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://code.jquery.com; " .
               "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com http://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; " .
               "img-src 'self' data: https: http:; " .
               "font-src 'self' data: https://fonts.gstatic.com http://fonts.gstatic.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; " .
               "connect-src 'self'; " .
               "frame-ancestors 'none'; " .
               "object-src 'none';";

        // Inyectar la cabecera en la respuesta HTTP
        $response->headers->set('Content-Security-Policy', $csp);
        
        $permissionsPolicy = "camera=(), " .
                             "microphone=(), " .
                             "geolocation=('self'), " .
                             "fullscreen=('self'), " .
                             "payment=(), " .
                             "usb=(), " .
                             "screen-wake-lock=('self')";

        $response->headers->set('Permissions-Policy', $permissionsPolicy);
        return $response;
    }
}