<?php

namespace App\Contracts\Repositories;

interface ReminderRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function query();
    public function countByStatus(string $status): int;
    public function getPaginated(array $filters, int $perPage = 10);
}
