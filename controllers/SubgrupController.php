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

class SubgrupController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/subgruplist[/{id}]", [PermissionMiddleware::class], "list.subgrup")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SubgrupList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/subgrupadd[/{id}]", [PermissionMiddleware::class], "add.subgrup")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SubgrupAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/subgrupview[/{id}]", [PermissionMiddleware::class], "view.subgrup")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SubgrupView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/subgrupedit[/{id}]", [PermissionMiddleware::class], "edit.subgrup")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SubgrupEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/subgrupdelete[/{id}]", [PermissionMiddleware::class], "delete.subgrup")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SubgrupDelete");
    }
}
