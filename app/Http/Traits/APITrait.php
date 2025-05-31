<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Query\Builder as QueryBuilder;

trait APITrait
{
    /**
     * Load relationships for a model or a query builder based on the 'include' query parameter.
     * @param Model|Builder|QueryBuilder|HasMany $modelOrQueryBuilder
     * @param ?array $relationships
     * @return Builder|Model|QueryBuilder|HasMany
     */
    public function loadRelationships(Model|Builder|QueryBuilder|HasMany $modelOrQueryBuilder, ?array $relationships = null): Model|Builder|QueryBuilder|HasMany
    {
        $relationships = $relationships ?? $this->relationships ?? [];

        foreach ($relationships as $relationship) {
            $modelOrQueryBuilder->when($this->shouldIncludeRelation($relationship), function ($q) use ($modelOrQueryBuilder, $relationship): void {
                $modelOrQueryBuilder instanceof Model ? $modelOrQueryBuilder->load($relationship) : $q->with($relationship);
            });
        }

        return $modelOrQueryBuilder;
    }

    /**
     * Check if a relation should be included based on the 'include' query parameter.
     * @param string $relation
     * @return bool
     */
    protected function shouldIncludeRelation(string $relation): bool
    {
        $include = request()->query('include');

        if (!$include) {
            return false;
        }

        $relations = array_map('trim', explode(',', $include));

        return in_array($relation, $relations);
    }
}