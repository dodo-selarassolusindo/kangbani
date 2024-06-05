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

class KlasifikasiController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/klasifikasilist[/{id}]", [PermissionMiddleware::class], "list.klasifikasi")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KlasifikasiList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/klasifikasiadd[/{id}]", [PermissionMiddleware::class], "add.klasifikasi")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KlasifikasiAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/klasifikasiview[/{id}]", [PermissionMiddleware::class], "view.klasifikasi")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KlasifikasiView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/klasifikasiedit[/{id}]", [PermissionMiddleware::class], "edit.klasifikasi")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KlasifikasiEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/klasifikasidelete[/{id}]", [PermissionMiddleware::class], "delete.klasifikasi")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KlasifikasiDelete");
    }
}
