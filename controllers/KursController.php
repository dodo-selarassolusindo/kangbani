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

class KursController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/kurslist[/{id}]", [PermissionMiddleware::class], "list.kurs")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KursList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/kursadd[/{id}]", [PermissionMiddleware::class], "add.kurs")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KursAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/kursview[/{id}]", [PermissionMiddleware::class], "view.kurs")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KursView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/kursedit[/{id}]", [PermissionMiddleware::class], "edit.kurs")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KursEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/kursdelete[/{id}]", [PermissionMiddleware::class], "delete.kurs")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KursDelete");
    }
}
