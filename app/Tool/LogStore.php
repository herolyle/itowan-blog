<?php
namespace App\Tool;

use App\Repository\LogRepository;

class LogStore
{
    private $repository;
    private $logs = [];

    public function __construct(LogRepository $repository)
    {
        $this->repository = $repository;
    }

    public function add($data)
    {
        $this->logs = $data;
    }

    public function save()
    {
        $this->repository->create($this->logs);
    }
}