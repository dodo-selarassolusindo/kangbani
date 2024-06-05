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

class JurnalController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/jurnallist[/{id}]", [PermissionMiddleware::class], "list.jurnal")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "JurnalList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/jurnaladd[/{id}]", [PermissionMiddleware::class], "add.jurnal")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "JurnalAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/jurnalview[/{id}]", [PermissionMiddleware::class], "view.jurnal")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "JurnalView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/jurnaledit[/{id}]", [PermissionMiddleware::class], "edit.jurnal")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "JurnalEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/jurnaldelete[/{id}]", [PermissionMiddleware::class], "delete.jurnal")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "JurnalDelete");
    }
}
