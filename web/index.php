<?php
error_reporting(E_ALL);

define('CONTROLLER', 'Mitopaths\\Controller\\');

require_once 'lib/autoloader.php';
require_once 'lib/error_catcher.php';

$router = new \Mitopaths\Router();

$router
// Front end
->declareRoute('/$', CONTROLLER . 'Home')
->declareRoute('/guide', CONTROLLER . 'Guide')
->declareRoute('/browse', CONTROLLER . 'Browse')
->declareRoute('/categories', CONTROLLER . 'CategoriesWeb')
->declareRoute('/legal', CONTROLLER . 'Legal')
->declareRoute('/register', CONTROLLER . 'Register')
->declareRoute('/login', CONTROLLER . 'Login')
->declareRoute('/search', CONTROLLER . 'SearchWeb')
->declareRoute('/molecule/{name}', CONTROLLER . 'MoleculeWeb')
->declareRoute('/pathway/{name}', CONTROLLER . 'PathwayWeb')
->declareRoute('/category/{name}', CONTROLLER . 'CategoryWeb')
->declareRoute('/documentation/api', CONTROLLER . 'Apidoc')

// Back end
->declareRoute('/my-account', CONTROLLER . 'MyAccount')
->declareRoute('/users/{id}/edit', CONTROLLER . 'UserEdit')
->declareRoute('/molecule/{name}/edit', CONTROLLER . 'MoleculeEdit')
->declareRoute('/pathway/{name}/edit', CONTROLLER . 'PathwayEdit')
->declareRoute('/category/{name}/edit', CONTROLLER . 'CategoryEdit')
->declareRoute('/function/{name}/edit', CONTROLLER . 'FunctionEdit')
->declareRoute('/pathology/{name}/edit', CONTROLLER . 'PathologyEdit')
->declareRoute('/suggest', CONTROLLER . 'Suggest')

// API
->declareRoute('/API/me', CONTROLLER . 'Session')
->declareRoute('/API/contact-us', CONTROLLER . 'Contact')
->declareRoute('/API/users', CONTROLLER . 'Users')
->declareRoute('/API/user/{id}', CONTROLLER . 'User')
->declareRoute('/API/molecules', CONTROLLER . 'Molecules')
->declareRoute('/API/pathways', CONTROLLER . 'Pathways')
->declareRoute('/API/categories', CONTROLLER . 'Categories')
->declareRoute('/API/functions', CONTROLLER . 'Functions')
->declareRoute('/API/pathologies', CONTROLLER . 'Pathologies')
->declareRoute('/API/search', CONTROLLER . 'Search')
->declareRoute('/API/expression/syntax-checker', CONTROLLER . 'ExpressionSyntaxChecker')
->declareRoute('/API/molecule/{name}', CONTROLLER . 'Molecule')
->declareRoute('/API/pathway/{name}', CONTROLLER . 'Pathway')
->declareRoute('/API/category/{name}', CONTROLLER . 'Category')
->declareRoute('/API/function/{name}', CONTROLLER . 'Functionality')
->declareRoute('/API/pathology/{name}', CONTROLLER . 'Pathology')


->declareRoute('/echo', CONTROLLER . 'EchoTest')
   
// Resource not found
->defaultRoute(CONTROLLER . 'NotFound')
;
