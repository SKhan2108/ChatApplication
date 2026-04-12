<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Database\Capsule\Manager as DB;

class UserController
{
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $request->getParsedBody();
        $username = $data['username'] ?? null;

        if (!$username) {
            return $this->json($response, ['error' => 'Missing username'], 400);
        }

        try {
            $userId = DB::table('users')->insertGetId(['username' => $username]);
        } catch (\Exception $e) {
            return $this->json($response, ['error' => 'Username already exists'], 400);
        }

        return $this->json($response, ['id' => $userId, 'username' => $username]);
    }

    private function json(ResponseInterface $response, $data, $status = 200)
    {
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}
