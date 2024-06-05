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

class TopController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/toplist[/{id}]", [PermissionMiddleware::class], "list.top")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TopList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/topadd[/{id}]", [PermissionMiddleware::class], "add.top")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TopAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/topview[/{id}]", [PermissionMiddleware::class], "view.top")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TopView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/topedit[/{id}]", [PermissionMiddleware::class], "edit.top")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TopEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/topdelete[/{id}]", [PermissionMiddleware::class], "delete.top")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TopDelete");
    }
}
