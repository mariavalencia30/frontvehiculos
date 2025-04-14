<?php

class UsuarioAPI {
    private $baseUrl = 'http://192.168.100.3:3001/api/usuarios';

    private function request($method, $url, $data = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($data) {
            $json = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($json)
            ]);
        }

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ['status' => $httpcode, 'body' => json_decode($response, true)];
    }

    public function registrarUsuario($email, $nombre, $telefono, $contrasena) {
        return $this->request('POST', "$this->baseUrl/register", [
            'email' => $email,
            'nombre' => $nombre,
            'telefono' => $telefono,
            'contraseña' => $contrasena
        ]);
    }

    public function login($email, $contrasena) {
        return $this->request('POST', "$this->baseUrl/login", [
            'email' => $email,
            'contraseña' => $contrasena
        ]);
    }

    public function obtenerUsuarioPorId($id) {
        return $this->request('GET', "$this->baseUrl/$id");
    }

    public function actualizarUsuario($id, $email, $nombre, $telefono) {
        return $this->request('PUT', "$this->baseUrl/$id", [
            'email' => $email,
            'nombre' => $nombre,
            'telefono' => $telefono
        ]);
    }

    public function eliminarUsuario($id) {
        return $this->request('DELETE', "$this->baseUrl/$id");
    }

    public function obtenerTodos() {
        return $this->request('GET', $this->baseUrl);
    }

    public function compararContrasena($email, $contrasena) {
        $login = $this->login($email, $contrasena);
        return $login['status'] === 200;
    }

    public function generarToken($email, $contrasena) {
        $login = $this->login($email, $contrasena);
        return $login['body']['token'] ?? null;
    }

    public function registrarUsuarioEnDB($email, $nombre, $telefono, $contrasena) {
        return $this->registrarUsuario($email, $nombre, $telefono, $contrasena);
    }
}
?>
