<?php
namespace App\Controller;

use App\Service\ItemService;
use App\Response;

class ItemController {
    public function __construct(private ItemService $service) {}

    public function index(): void { Response::json($this->service->list()); }

    public function show(int $id): Response {
        $item = $this->service->get($id);
        if (!$item) return Response::json(['error'=>'Not found'], 404);
        Response::json($item);
    }

    public function store(array $data): Response {
        $id = $this->service->create($data);
        Response::json(['id'=>$id], 201);
    }

    public function update(int $id, array $data): Response {
        if (!$this->service->update($id, $data)) return Response::json(['error'=>'Not found or not updated'], 400);
        Response::json(['success'=>true]);
    }

    public function destroy(int $id): Response {
        if (!$this->service->delete($id)) return Response::json(['error'=>'Not found'], 404);
        Response::json([],204);
    }
}