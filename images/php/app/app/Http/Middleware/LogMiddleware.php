<?php

namespace App\Http\Middleware;

use Closure;

class LogMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {

        $Date = date("Y-m-d H:i:s");
        $Method = $request->server->get("REQUEST_METHOD");
        $Uri = $request->server->get("REQUEST_URI");
        $FullData = $Date."\t".$Method."\t".$Uri."\n";
        
        $File = rtrim($_SERVER["DOCUMENT_ROOT"],"/")."/../storage/logs/access.log";

        //$File = "/var/www/html/app/storage/logs/access.log";

        file_put_contents($File,$FullData,FILE_APPEND);

        return $next($request);

    }
}
