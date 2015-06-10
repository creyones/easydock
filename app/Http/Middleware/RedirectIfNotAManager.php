<?php namespace App\Http\Middleware;

use Closure;

class RedirectIfNotAManager {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

		if( $request->user()->hasRole('Provider') )
		{
			return redirect('home');
		}

		return $next($request);
	}

}
