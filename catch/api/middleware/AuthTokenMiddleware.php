<?php

namespace catchAdmin\api\middleware;

use catcher\Code;
use catcher\exceptions\FailedException;
use thans\jwt\exception\TokenBlacklistException;
use thans\jwt\exception\TokenExpiredException;
use thans\jwt\exception\TokenInvalidException;
use thans\jwt\facade\JWTAuth;
use think\Middleware;

class AuthTokenMiddleware extends Middleware
{
    public function handle($request, \Closure $next)
    {
        try {
            JWTAuth::auth();
        } catch (\Exception $e) {
            if ($e instanceof TokenExpiredException) {
                throw new FailedException('登录过期，请重新登录', Code::LOGIN_EXPIRED);
            }
            if ($e instanceof TokenBlacklistException) {
                throw new FailedException('登录过期，请重新登录', Code::LOGIN_BLACKLIST);
            }
            if ($e instanceof TokenInvalidException) {
                throw new FailedException('登录过期，请重新登录', Code::LOST_LOGIN);
            }

            throw new FailedException('登录过期，请重新登录', Code::LOST_LOGIN);
        }

        return $next($request);
    }
}
