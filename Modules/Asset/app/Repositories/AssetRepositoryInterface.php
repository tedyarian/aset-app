<?php

namespace Modules\Asset\Repositories;

interface AssetRepositoryInterface
{
    public function getAll();
    public function getMetrics();
    public function create(array $data);
}