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

class PersonController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/personlist[/{id}]", [PermissionMiddleware::class], "list.person")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PersonList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/personadd[/{id}]", [PermissionMiddleware::class], "add.person")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PersonAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/personview[/{id}]", [PermissionMiddleware::class], "view.person")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PersonView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/personedit[/{id}]", [PermissionMiddleware::class], "edit.person")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PersonEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/persondelete[/{id}]", [PermissionMiddleware::class], "delete.person")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PersonDelete");
    }
}
