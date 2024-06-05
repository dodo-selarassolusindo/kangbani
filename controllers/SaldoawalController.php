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

class SaldoawalController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/saldoawallist[/{id}]", [PermissionMiddleware::class], "list.saldoawal")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SaldoawalList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/saldoawaladd[/{id}]", [PermissionMiddleware::class], "add.saldoawal")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SaldoawalAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/saldoawalview[/{id}]", [PermissionMiddleware::class], "view.saldoawal")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SaldoawalView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/saldoawaledit[/{id}]", [PermissionMiddleware::class], "edit.saldoawal")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SaldoawalEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/saldoawaldelete[/{id}]", [PermissionMiddleware::class], "delete.saldoawal")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SaldoawalDelete");
    }
}
