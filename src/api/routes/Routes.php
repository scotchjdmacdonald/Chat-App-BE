<?php 

include_once __DIR__ . '/../controllers/UserController.php';  
include_once __DIR__ . '/../controllers/MessageController.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Routes {
    
    private $app;

    public function __construct(){

        $app = new \Slim\App();

        //CORS config
        $app->options('/{routes:.+}', function ($request, $response, $args) {
            return $response;
        });
        $app->add(function ($req, $res, $next) {
            $response = $next($req, $res);
            return $response
                    ->withHeader('Access-Control-Allow-Origin', '*')
                    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        });
    
        //Base route
        $app->get('/', function (Request $request, Response $response) {
            $response->getBody()->write("Welcome to the backend for the Simple Chat App");
            return $response;
        });
    
        $app->post('/message/send', function (Request $request, Response $response, array $args) {
            $data = $request->getParsedBody();
            if($data['sender_id'] && $data['recipient_id'] && $data['message_text']){
                $messageController = new MessageController();
                $rdata = $messageController->createNewMessage($data);
                $r = $response->withJson($rdata, 201);
                return $r;
            }
            else{
                return $response->withStatus(400);
            }
        });
    
        $app->get('/messages/{sender_id}/{recipient_id}', function (Request $request, Response $response, array $args) {
            $sender_id = $args['sender_id'];
            $recipient_id = $args['recipient_id'];
            $messageController = new MessageController();
            $rdata = $messageController->getMessagesForConversation($sender_id, $recipient_id);
            $r = $response->withJson($rdata, 200);
            return $r;
        });
    
        $app->get('/users', function (Request $request, Response $response, array $args) {
            $userController = new UserController();
            $rdata = $userController->getUsers();
            $r = $response->withJson($rdata, 200);
            return $r;
        });

        $this->app = $app;
    }

    public function get()
    {
        return $this->app;
    }
}