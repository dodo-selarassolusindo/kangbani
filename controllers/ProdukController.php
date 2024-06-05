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

class ProdukController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/produklist[/{id}]", [PermissionMiddleware::class], "list.produk")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProdukList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/produkadd[/{id}]", [PermissionMiddleware::class], "add.produk")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProdukAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/produkview[/{id}]", [PermissionMiddleware::class], "view.produk")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProdukView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/produkedit[/{id}]", [PermissionMiddleware::class], "edit.produk")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProdukEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/produkdelete[/{id}]", [PermissionMiddleware::class], "delete.produk")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProdukDelete");
    }
}
