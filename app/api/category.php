<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// Get All Categories
$app->get('/api/categories', function(Request $request, Response $response){
    $sql = "SELECT * FROM categories";

    try{
        // Get Database Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($categories);

    } catch(PDOEception $e){
        echo '{"error": {"text": '.$e->getMessage().'}}';
    }
});

// Get Single Category
$app->get('/api/category/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM categories WHERE id=$id";
    try{
        // Get Database Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $category = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($category);

    } catch(PDOEception $e){
        echo '{"error": {"text": '.$e->getMessage().'}}';
    }
});

// Add New Post
$app->post('/api/category/add', function(Request $request, Response $response){
    $name = $request->getParam('name');
    $sql= "INSERT INTO categories (name) VALUES (:name)";
    try{
        // Get Database Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->execute();

        echo '{"notice": {"text": "Category Added"}}';

    } catch(PDOEception $e){
        echo '{"error": {"text": '.$e->getMessage().'}}';
    }

});

// Update Post
$app->put('/api/category/update/{id}', function(Request $request, Response $response){
    
    $id = $request->getAttribute('id');

    $name = $request->getParam('name');
    $sql= "UPDATE categories SET
                            name = :name
                        WHERE id=$id";
    try{
        // Get Database Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->execute();

        echo '{"notice": {"text": "Category '.$id.' Updated"}}';

    } catch(PDOEception $e){
        echo '{"error": {"text": '.$e->getMessage().'}}';
    }

});

// Delete Post
$app->delete('/api/category/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM categories WHERE id=$id";
    try{
        // Get Database Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;

        echo '{"notice": {"text": "Category '.$id.' Deleted"}}';

    } catch(PDOEception $e){
        echo '{"error": {"text": '.$e->getMessage().'}}';
    }
});