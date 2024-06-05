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

class TosController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/toslist[/{id}]", [PermissionMiddleware::class], "list.tos")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TosList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/tosadd[/{id}]", [PermissionMiddleware::class], "add.tos")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TosAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/tosview[/{id}]", [PermissionMiddleware::class], "view.tos")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TosView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/tosedit[/{id}]", [PermissionMiddleware::class], "edit.tos")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TosEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/tosdelete[/{id}]", [PermissionMiddleware::class], "delete.tos")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TosDelete");
    }
}
