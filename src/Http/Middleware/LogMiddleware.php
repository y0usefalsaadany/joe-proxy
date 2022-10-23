<?php

namespace Yousefpackage\JoeProxy\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yousefpackage\JoeProxy\Models\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Yousefpackage\JoeProxy\Http\Controllers\HelperController;
use Yousefpackage\JoeProxy\Models\Alert;

class LogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
        $api = Http::get('http://ipwho.is/'. $request->ip());
        $data = json_decode($api, true);
        // $parameters = $request->route()->parameters();
        $item_id = null;
        if($request->route('id')){
            $item_id = $request->route('id');
        }
        $logs =  new Log();
        $logs->ip = $request->ip();
        if(isset($data['city'])){
            $logs->city = $data['city'];
        }
        $actionController = explode('@',Route::currentRouteAction()) ?? null;
        $logs->page_name = $request->url();
        $logs->item_id = $item_id;
        $logs->action = $actionController[1] ?? null;
        $logs->os = $this->getOS();
        $logs->save();
        $startDate = date("Y-m-d H:i:s");
        $endDate = date("Y-m-d H:i:s",strtotime('-1 minutes',strtotime($startDate)));
        if (Log::whereIp($request->ip())->whereBetween('created_at', [$endDate, $startDate])->count() > 5){
            $visitTable = Log::latest()->take(10);
            $visitTable->delete();
            $alert = new Alert();
            $alert->ip = $request->ip();
            $alert->page_name = $request->url();
            $alert->save();
            $city = $data['city'] ?? null;
            $helper = HelperController::manyRequests($request->ip(),$request->url(),$city);
            return abort("403",'TOO MANY REQUESTS');
        }
        return $next($request);
    }

    function getOS() {

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_platform =   "Bilinmeyen İşletim Sistemi";
        $os_array =   array(
            '/windows nt 10/i'      =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ( $os_array as $regex => $value ) {
            if ( preg_match($regex, $user_agent ) ) {
                $os_platform = $value;
            }
        }
        return $os_platform;
    }
}
