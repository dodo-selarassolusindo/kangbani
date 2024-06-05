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

class KonversiController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/konversilist[/{id}]", [PermissionMiddleware::class], "list.konversi")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KonversiList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/konversiadd[/{id}]", [PermissionMiddleware::class], "add.konversi")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KonversiAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/konversiview[/{id}]", [PermissionMiddleware::class], "view.konversi")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KonversiView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/konversiedit[/{id}]", [PermissionMiddleware::class], "edit.konversi")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KonversiEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/konversidelete[/{id}]", [PermissionMiddleware::class], "delete.konversi")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KonversiDelete");
    }
}
