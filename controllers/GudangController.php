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

class GudangController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/gudanglist[/{id}]", [PermissionMiddleware::class], "list.gudang")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "GudangList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/gudangadd[/{id}]", [PermissionMiddleware::class], "add.gudang")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "GudangAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/gudangview[/{id}]", [PermissionMiddleware::class], "view.gudang")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "GudangView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/gudangedit[/{id}]", [PermissionMiddleware::class], "edit.gudang")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "GudangEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/gudangdelete[/{id}]", [PermissionMiddleware::class], "delete.gudang")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "GudangDelete");
    }
}
