<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    description: "API documentation for my project",
    title: "My Laravel 13 API"
)]
abstract class Controller extends BaseController
{

    #[OA\Get(
        path: "/api/test",
        summary: "Sample API Endpoint",
        responses: [
            new OA\Response(response: 200, description: "Success")
        ]
    )]
    public function testEndpoint()
    {
        return response()->json(['message' => 'Swagger is working!']);
    }
}
