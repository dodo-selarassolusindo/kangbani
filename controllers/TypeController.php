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

class TypeController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/typelist[/{id}]", [PermissionMiddleware::class], "list.type")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TypeList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/typeadd[/{id}]", [PermissionMiddleware::class], "add.type")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TypeAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/typeview[/{id}]", [PermissionMiddleware::class], "view.type")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TypeView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/typeedit[/{id}]", [PermissionMiddleware::class], "edit.type")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TypeEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/typedelete[/{id}]", [PermissionMiddleware::class], "delete.type")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TypeDelete");
    }
}
