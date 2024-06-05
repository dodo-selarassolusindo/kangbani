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

class JurnaldController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/jurnaldlist[/{id}]", [PermissionMiddleware::class], "list.jurnald")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "JurnaldList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/jurnaldadd[/{id}]", [PermissionMiddleware::class], "add.jurnald")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "JurnaldAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/jurnaldview[/{id}]", [PermissionMiddleware::class], "view.jurnald")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "JurnaldView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/jurnaldedit[/{id}]", [PermissionMiddleware::class], "edit.jurnald")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "JurnaldEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/jurnalddelete[/{id}]", [PermissionMiddleware::class], "delete.jurnald")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "JurnaldDelete");
    }
}
