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

class AkunController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/akunlist[/{id}]", [PermissionMiddleware::class], "list.akun")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AkunList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/akunadd[/{id}]", [PermissionMiddleware::class], "add.akun")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AkunAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/akunview[/{id}]", [PermissionMiddleware::class], "view.akun")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AkunView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/akunedit[/{id}]", [PermissionMiddleware::class], "edit.akun")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AkunEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/akundelete[/{id}]", [PermissionMiddleware::class], "delete.akun")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AkunDelete");
    }
}
