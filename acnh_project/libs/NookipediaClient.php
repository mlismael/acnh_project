<?php

class NookipediaClient
{
    private $config;

    public function __construct()
    {
        $this->config = Config::singleton();
    }

    public function get($endpoint, array $query = [])
    {
        $baseUrl = rtrim($this->config->get('nookipedia_base_url'), '/');
        $token = $this->config->get('nookipedia_token');

        if (empty($token)) {
            return [
                'status' => 500,
                'error' => 'Nookipedia token no configurado en el backend'
            ];
        }

        $url = $baseUrl . '/' . ltrim($endpoint, '/');
        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        $headers = [
            'Accept: application/json',
            'X-API-KEY: ' . $token
        ];

        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);
        curl_close($curl);

        if ($response === false) {
            return [
                'status' => 500,
                'error' => 'Error de conexión a Nookipedia: ' . $curlError
            ];
        }

        $payload = json_decode($response, true);
        if ($payload === null && json_last_error() !== JSON_ERROR_NONE) {
            return [
                'status' => $httpCode ?: 500,
                'error' => 'Respuesta inválida de Nookipedia',
                'raw' => $response
            ];
        }

        return [
            'status' => $httpCode,
            'data' => $payload
        ];
    }
}
?>