<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Database\Capsule\Manager as DB;

class GroupController
{
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $request->getParsedBody();
        $name = $data['name'] ?? null;

        if (!$name) {
            return $this->json($response, ['error' => 'Missing group name'], 400);
        }

        try {
            $groupId = DB::table('chat_groups')->insertGetId(['name' => $name]);
        } catch (\Exception $e) {
            return $this->json($response, ['error' => 'Group already exists'], 400);
        }

        return $this->json($response, ['id' => $groupId, 'name' => $name]);
    }

    public function list(ResponseInterface $response): ResponseInterface
    {
        $groups = DB::table('chat_groups')->get();
        return $this->json($response, $groups);
    }

    public function join(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $groupId = (int)$args['id'];
        $data = $request->getParsedBody();
        $username = $data['username'] ?? null;

        if (!$username) {
            return $this->json($response, ['error' => 'Missing username'], 400);
        }

        $user = DB::table('users')->where('username', $username)->first();
        if (!$user) {
            return $this->json($response, ['error' => 'User not found'], 404);
        }

        DB::table('group_members')->insertOrIgnore([
            'user_id' => $user->id,
            'group_id' => $groupId
        ]);

        return $this->json($response, ['status' => 'joined']);
    }

    private function json(ResponseInterface $response, $data, $status = 200)
    {
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}
