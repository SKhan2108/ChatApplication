<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Database\Capsule\Manager as DB;

class MessageController
{
    public function send(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $groupId = (int)$args['id'];
        $data = $request->getParsedBody();
        $username = $data['username'] ?? null;
        $message = $data['message'] ?? null;

        if (!$username || !$message) {
            return $this->json($response, ['error' => 'Missing fields'], 400);
        }

        $user = DB::table('users')->where('username', $username)->first();
        if (!$user) {
            return $this->json($response, ['error' => 'User not found'], 404);
        }

        DB::table('messages')->insert([
            'user_id' => $user->id,
            'group_id' => $groupId,
            'message' => $message,
        ]);

        return $this->json($response, ['status' => 'sent']);
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $groupId = (int)$args['id'];
        $messages = DB::table('messages')
            ->join('users', 'users.id', '=', 'messages.user_id')
            ->where('messages.group_id', $groupId)
            ->select('users.username', 'messages.message', 'messages.created_at')
            ->orderBy('messages.created_at', 'asc')
            ->get();

        return $this->json($response, $messages);
    }

    private function json(ResponseInterface $response, $data, $status = 200)
    {
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}
