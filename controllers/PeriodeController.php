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

class PeriodeController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/periodelist[/{id}]", [PermissionMiddleware::class], "list.periode")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PeriodeList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/periodeadd[/{id}]", [PermissionMiddleware::class], "add.periode")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PeriodeAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/periodeview[/{id}]", [PermissionMiddleware::class], "view.periode")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PeriodeView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/periodeedit[/{id}]", [PermissionMiddleware::class], "edit.periode")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PeriodeEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/periodedelete[/{id}]", [PermissionMiddleware::class], "delete.periode")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PeriodeDelete");
    }
}
