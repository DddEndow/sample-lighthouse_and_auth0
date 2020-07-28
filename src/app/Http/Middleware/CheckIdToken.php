<?php

namespace App\Http\Middleware;

use Auth0\SDK\Helpers\JWKFetcher;
use Auth0\SDK\Helpers\Tokens\AsymmetricVerifier;
use Auth0\SDK\Helpers\Tokens\IdTokenVerifier;
use Auth0\SDK\Helpers\Tokens\SymmetricVerifier;
use Closure;

class CheckIdToken
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
        // id tokenを検証
        $id_token = $request->bearerToken();

        $id_token_header = explode('.', $id_token)[0];

        try {
            $token_alg = json_decode(base64_decode($id_token_header))->alg;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 401);
        }

        $token_issuer = 'https://' . config('laravel-auth0.domain') . '/';

        $signature_verifier = null;

        if ('RS256' === $token_alg) {
            $jwks_fetcher = new JWKFetcher();
            $jwks        = $jwks_fetcher->getKeys($token_issuer.'.well-known/jwks.json');
            $signature_verifier = new AsymmetricVerifier($jwks);
        } else if ('HS256' === $token_alg) {
            $signature_verifier = new SymmetricVerifier(config('laravel-auth0.client_secret'));
        }

        $token_verifier = new IdTokenVerifier(
            $token_issuer,
            config('laravel-auth0.client_id'),
            $signature_verifier
        );

        try {
            $decoded_token = $token_verifier->verify($id_token);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 401);
        }

        $request->merge([
            'auth0_user_id' => $decoded_token['sub'],
            'email' => $decoded_token['email']
        ]);

        return $next($request);
    }
}
