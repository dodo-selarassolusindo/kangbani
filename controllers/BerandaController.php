<?php

namespace PHPMaker2024\prj_accounting;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPMaker2024\prj_accounting\Attributes\Delete;
use PHPMaker2024\prj_accounting\Attributes\Get;
use PHPMaker2024\prj_accounting\Attributes\Map;
use PHPMaker2024\prj_accounting\Attributes\Options;
use PHPMaker2024\prj_accounting\Attributes\Patch;
use PHPMaker2024\prj_accounting\Attributes\Post;
use PHPMaker2024\prj_accounting\Attributes\Put;

/**
 * beranda controller
 */
class BerandaController extends ControllerBase
{
    // custom
    #[Map(["GET", "POST", "OPTIONS"], "/beranda[/{params:.*}]", [PermissionMiddleware::class], "custom.beranda")]
    public function custom(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Beranda");
    }
}
