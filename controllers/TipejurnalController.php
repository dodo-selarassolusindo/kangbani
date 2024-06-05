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

class TipejurnalController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/tipejurnallist[/{id}]", [PermissionMiddleware::class], "list.tipejurnal")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipejurnalList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/tipejurnaladd[/{id}]", [PermissionMiddleware::class], "add.tipejurnal")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipejurnalAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/tipejurnalview[/{id}]", [PermissionMiddleware::class], "view.tipejurnal")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipejurnalView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/tipejurnaledit[/{id}]", [PermissionMiddleware::class], "edit.tipejurnal")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipejurnalEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/tipejurnaldelete[/{id}]", [PermissionMiddleware::class], "delete.tipejurnal")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipejurnalDelete");
    }
}
