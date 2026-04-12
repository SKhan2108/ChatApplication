<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$app->post('/users', function ($request, $response) {
    $data = $request->getParsedBody();

    if (!isset($data['username'])) {
        $response->getBody()->write(json_encode(["error" => "Missing username"]));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    try {
        $pdo = \App\Database\Database::getConnection();

        $stmt = $pdo->prepare("INSERT INTO users (username) VALUES (:username)");
        $stmt->execute([
            'username' => $data['username']
        ]);

        $response->getBody()->write(json_encode([
            "message" => "User created"
        ]));
    } catch (\Exception $e) {
        $response->getBody()->write(json_encode([
            "error" => $e->getMessage()
        ]));
        return $response->withStatus(500);
    }

    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/users', function ($request, $response) {
    $pdo = \App\Database\Database::getConnection();

    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll();

    $response->getBody()->write(json_encode($users));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/users/{id}', function ($request, $response, $args) {
    $pdo = \App\Database\Database::getConnection();

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $args['id']]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $response->getBody()->write(json_encode(["error" => "User not found"]));
        return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
    }

    $response->getBody()->write(json_encode($user));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/groups', function ($request, $response) {
    $data = $request->getParsedBody();

    if (!isset($data['name'])) {
        $response->getBody()->write(json_encode(["error" => "Missing group name"]));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $pdo = \App\Database\Database::getConnection();

    $stmt = $pdo->prepare("INSERT INTO chat_groups (name) VALUES (:name)");
    $stmt->execute([
        'name' => $data['name']
    ]);

    $response->getBody()->write(json_encode([
        "message" => "Group created"
    ]));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/groups/{id}/join', function ($request, $response, $args) {
    $groupId = $args['id'];
    $data = $request->getParsedBody();

    if (!isset($data['user_id'])) {
        $response->getBody()->write(json_encode(["error" => "Missing user_id"]));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $pdo = \App\Database\Database::getConnection();

    $stmt = $pdo->prepare("
        INSERT INTO group_members (user_id, group_id) 
        VALUES (:user_id, :group_id)
    ");

    $stmt->execute([
        'user_id' => $data['user_id'],
        'group_id' => $groupId
    ]);

    $response->getBody()->write(json_encode(["message" => "User joined group"]));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/groups', function ($request, $response) {
    $pdo = \App\Database\Database::getConnection();

    $stmt = $pdo->query("SELECT * FROM chat_groups");
    $groups = $stmt->fetchAll();

    $response->getBody()->write(json_encode($groups));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/groups/{id}/messages', function ($request, $response, $args) {
    $groupId = $args['id'];

    $pdo = \App\Database\Database::getConnection();

    $stmt = $pdo->prepare("
        SELECT m.*, u.username 
        FROM messages m
        JOIN users u ON m.user_id = u.id
        WHERE m.group_id = :group_id
        ORDER BY m.created_at ASC
    ");

    $stmt->execute(['group_id' => $groupId]);

    $messages = $stmt->fetchAll();

    $response->getBody()->write(json_encode($messages));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/groups/{id}/messages', function ($request, $response, $args) {
    $groupId = $args['id'];
    $data = $request->getParsedBody();

    if (!isset($data['user_id']) || !isset($data['content'])) {
        $response->getBody()->write(json_encode(["error" => "Missing fields"]));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $pdo = \App\Database\Database::getConnection();

    $stmt = $pdo->prepare("
        INSERT INTO messages (user_id, group_id, content) 
        VALUES (:user_id, :group_id, :content)
    ");

    $stmt->execute([
        'user_id' => $data['user_id'],
        'group_id' => $groupId,
        'content' => $data['content']
    ]);

    $response->getBody()->write(json_encode(["message" => "Message sent"]));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/groups/{id}/members', function ($request, $response, $args) {
    $groupId = $args['id'];

    $pdo = \App\Database\Database::getConnection();

    $stmt = $pdo->prepare("
        SELECT u.id, u.username 
        FROM group_members gm
        JOIN users u ON gm.user_id = u.id
        WHERE gm.group_id = :group_id
    ");

    $stmt->execute(['group_id' => $groupId]);

    $members = $stmt->fetchAll();

    $response->getBody()->write(json_encode($members));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();