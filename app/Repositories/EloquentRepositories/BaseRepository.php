<?php


namespace App\Repositories\EloquentRepositories;

use BadMethodCallException;
use Prophecy\Exception\Doubler\MethodNotFoundException;

abstract class BaseRepository
{
    public function __call($name, $arguments)
    {
        try {
            return $this->model->$name(...$arguments);
        } catch (\Throwable $th) {
            if ($th instanceof BadMethodCallException) {
                throw new MethodNotFoundException('Method name not found', self::class, $name);
            }

            throw $th;
        }
    }
}
