<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;

class TestController extends AbstractController
{


    public function process(Request $request): Response
    {
        $uriParts = explode('/', trim($request->getUri(), '/'));
        $email = end($uriParts);
        return new Response('Test Controller  ' . $email);
    }
}
