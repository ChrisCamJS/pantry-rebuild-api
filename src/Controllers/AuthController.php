<?php

namespace App\Controllers;

use App\Database;
use PDO;

class AuthController {

    public function login() {
        // start the session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $db = Database::connect();

        $raw_input = file_get_contents("php://input");
        $data = json_decode($raw_input, true);

        if (!is_array($data)) {
            $data = [];
        }

        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';
        $email = $data['email'] ?? '';

        if (empty($username) || empty($password)) {
            http_response_code(400);
            echo json_encode(["message" => "Provide a Username and a Password."]);
            return;
        }

        // fetch the user from the database
        $sql = "SELECT id, email, username, password_hash, is_admin FROM users WHERE username = :username LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // verify the user exists and the password matches the hash
        if ($user && password_verify($password, $user['password_hash'])) {
            // strip the has before sending the data back
            unset($user['password_hash']);

            // Save user info in the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];

            echo json_encode([
                "success" => true,
                "message" => "Welcome to the vault",
                "user" => $user
            ]);
        }
        else {
            // Keep the error vague for security (don't tell them if the username or password was wrong)
            http_response_code(401);
            echo json_encode(["success" => false, "message" => "Invalid credentials. Off you pop."]);
        }
    }
    
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        echo json_encode(["success" => true, "message" => "Logged out successfully."]);
    }
}