<?php

namespace Knovators\Masters\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class IsActiveCriteria.
 *
 * @package namespace App\Criteria;
 */
class IsActiveCriteria implements CriteriaInterface
{

    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository) {
        $model = $model->where('is_active', '=', 1);
        return $model;
    }
}
