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

class MatauangController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/matauanglist[/{id}]", [PermissionMiddleware::class], "list.matauang")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MatauangList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/matauangadd[/{id}]", [PermissionMiddleware::class], "add.matauang")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MatauangAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/matauangview[/{id}]", [PermissionMiddleware::class], "view.matauang")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MatauangView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/matauangedit[/{id}]", [PermissionMiddleware::class], "edit.matauang")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MatauangEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/matauangdelete[/{id}]", [PermissionMiddleware::class], "delete.matauang")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MatauangDelete");
    }
}
