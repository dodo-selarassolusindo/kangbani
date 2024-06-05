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

class KelompokController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/kelompoklist[/{id}]", [PermissionMiddleware::class], "list.kelompok")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KelompokList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/kelompokadd[/{id}]", [PermissionMiddleware::class], "add.kelompok")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KelompokAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/kelompokview[/{id}]", [PermissionMiddleware::class], "view.kelompok")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KelompokView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/kelompokedit[/{id}]", [PermissionMiddleware::class], "edit.kelompok")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KelompokEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/kelompokdelete[/{id}]", [PermissionMiddleware::class], "delete.kelompok")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KelompokDelete");
    }
}
