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

class SatuanController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/satuanlist[/{id}]", [PermissionMiddleware::class], "list.satuan")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SatuanList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/satuanadd[/{id}]", [PermissionMiddleware::class], "add.satuan")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SatuanAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/satuanview[/{id}]", [PermissionMiddleware::class], "view.satuan")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SatuanView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/satuanedit[/{id}]", [PermissionMiddleware::class], "edit.satuan")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SatuanEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/satuandelete[/{id}]", [PermissionMiddleware::class], "delete.satuan")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SatuanDelete");
    }
}
