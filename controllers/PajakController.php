<?php

namespace PHPMaker2024\prj_accounting;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPMaker2024\prj_accounting\Attributes\Delete;
use PHPMaker2024\prj_accounting\Attributes\Get;
use PHPMaker2024\prj_accounting\Attributes\Map;
use PHPMaker2024\prj_accounting\Attributes\Options;
use PHPMaker2024\prj_accounting\Attributes\Patch;
use PHPMaker2024\prj_accounting\Attributes\Post;
use PHPMaker2024\prj_accounting\Attributes\Put;

class PajakController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/pajaklist[/{id}]", [PermissionMiddleware::class], "list.pajak")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PajakList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/pajakadd[/{id}]", [PermissionMiddleware::class], "add.pajak")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PajakAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/pajakview[/{id}]", [PermissionMiddleware::class], "view.pajak")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PajakView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/pajakedit[/{id}]", [PermissionMiddleware::class], "edit.pajak")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PajakEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/pajakdelete[/{id}]", [PermissionMiddleware::class], "delete.pajak")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PajakDelete");
    }
}
