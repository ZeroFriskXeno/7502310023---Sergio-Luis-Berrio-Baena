<?php
namespace App\Application\Auth\Service;
class JwtService
{
    private string $secret;
    private string $issuer;
    public function __construct()
    {
        $this->secret = 'MI_SECRETO_SUPER_SEGURO_CAMBIAR';
        $this->issuer = 'mi-app';
    }
    public function generate(array $payload, int $expiresIn = 3600): string
    {
        $header = ['alg' => 'HS256', 'typ' => 'JWT'];
        $payload['iss'] = $this->issuer;
        $payload['exp'] = time() + $expiresIn;
        $headerEnc = $this->base64UrlEncode(json_encode($header));
        $payloadEnc = $this->base64UrlEncode(json_encode($payload));
        $signature = hash_hmac('sha256', "$headerEnc.$payloadEnc", $this->secret, true);
        $signatureEnc = $this->base64UrlEncode($signature);
        return "$headerEnc.$payloadEnc.$signatureEnc";
    }
    public function validate(string $token): ?array
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) return null;
        [$headerEnc, $payloadEnc, $signatureEnc] = $parts;
        $expected = $this->base64UrlEncode(
            hash_hmac('sha256', "$headerEnc.$payloadEnc", $this->secret, true)
        );
        if (!hash_equals($expected, $signatureEnc)) return null;
        $payload = json_decode(base64_decode(strtr($payloadEnc, '-_', '+/')), true);
        if ($payload['exp'] < time()) return null;
        return $payload;
    }
    private function base64UrlEncode(string $data): string
    {return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');}
}
