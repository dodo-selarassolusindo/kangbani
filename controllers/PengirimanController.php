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

class PengirimanController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/pengirimanlist[/{id}]", [PermissionMiddleware::class], "list.pengiriman")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PengirimanList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/pengirimanadd[/{id}]", [PermissionMiddleware::class], "add.pengiriman")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PengirimanAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/pengirimanview[/{id}]", [PermissionMiddleware::class], "view.pengiriman")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PengirimanView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/pengirimanedit[/{id}]", [PermissionMiddleware::class], "edit.pengiriman")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PengirimanEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/pengirimandelete[/{id}]", [PermissionMiddleware::class], "delete.pengiriman")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PengirimanDelete");
    }
}
