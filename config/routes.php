<?php
use App\Router;

$router = new Router();

$router->add('GET', '/recipes', 'RecipeController', 'getAllRecipes');
$router->add('POST', '/recipes', 'RecipeController', 'addRecipe');
$router->add('GET', '/recipes/single', 'RecipeController', 'getSingleRecipe');
$router->add('POST', '/login', 'AuthController', 'login');
$router->add('POST', '/logout', 'AuthController', 'logout');

return $router;