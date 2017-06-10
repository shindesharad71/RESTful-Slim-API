<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// Get All Posts
$app->get('/api/posts', function(Request $request, Response $response){
    $sql = "SELECT * FROM posts";

    try{
        // Get Database Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($posts);

    } catch(PDOEception $e){
        echo '{"error": {"text": '.$e->getMessage().'}}';
    }
});

// Get Single Post
$app->get('/api/post/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM posts WHERE id=$id";
    try{
        // Get Database Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $post = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($post);

    } catch(PDOEception $e){
        echo '{"error": {"text": '.$e->getMessage().'}}';
    }

});