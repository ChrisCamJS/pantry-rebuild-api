<?php
use App\Router;

$router = new Router();

$router->add('GET', '/recipes', 'RecipeController', 'getAllRecipes');
$router->add('POST', '/recipes', 'RecipeController', 'addRecipe');
$router->add('GET', '/recipes/single', 'RecipeController', 'getSingleRecipe');
$router->add('POST', '/login', 'AuthController', 'login');
$router->add('POST', '/logout', 'AuthController', 'logout');

$router->add('DELETE', '/recipes', 'RecipeController', 'getSingleRecipe');
$router->add('PUT', '/recipes/draft', 'RecipeController', 'toggleDraft');
$router->add('PUT', '/recipes', 'RecipeController', 'updateRecipe');
$router->add('POST', '/upload', 'RecipeController', 'uploadImages');

return $router;