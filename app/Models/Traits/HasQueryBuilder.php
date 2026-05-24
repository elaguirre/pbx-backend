<?php

namespace App\Models\Traits;

use Spatie\QueryBuilder\QueryBuilder;

trait HasQueryBuilder
{
    public function scopeQueryBuilder($builder, array $add_includes = []): \Spatie\QueryBuilder\QueryBuilder
    {
        $builder = QueryBuilder::for($builder);

        if (count($allowed_sorts = $this->getAllowedSorts())) {
            $builder->allowedSorts(...$allowed_sorts);
        }

        if (count($allowed_includes = $this->getAllowedIncludes())) {
            $builder->allowedIncludes(...array_merge($allowed_includes, $add_includes));
        }

        if (count($default_sorts = $this->getDefaultSorts())) {
            $builder->defaultSort(...$default_sorts);
        }

        if (request()->get('query') && request()->get('query') && method_exists(self::class, 'scopeSearch')) {
            $builder->search(request('query'));
        }

        if (app()->runningInConsole() === false && request()->isMethod('get') && method_exists(self::class, 'scopeAdvancedSearch')) {
            $builder->advancedSearch();
        }

        if (request()->get('only_actives') && method_exists(self::class, 'scopeActive')) {
            $builder->active();
        }

        return $builder;
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->queryBuilder()->where($field ?: 'id', $value)->firstOrFail();
    }

    public function scopeAsList($query)
    {
        return $query->select([
            'id as value',
            'title as label',
        ]);
    }

    public function scopeResolve($query)
    {
        if (request('limit')) {
            $query->take(request('limit', 1000));
        }

        if (request()->boolean('paginated')) {
            return $query->paginate(request('limit', config('app.limit')));
        }

        if (request()->has('listed')) {
            return $query->asList()->get();
        }

        return $query->get();
    }

    private function getAllowedSorts(): array
    {
        if (!property_exists(self::class, 'allowed_sorts')) {
            return [];
        }

        return $this->allowed_sorts ?: [];
    }

    private function getAllowedIncludes(): array
    {
        if (!property_exists(self::class, 'allowed_includes')) {
            return [];
        }

        return $this->allowed_includes ?: [];
    }

    private function getDefaultSorts(): array
    {
        if (!property_exists(self::class, 'default_sorts')) {
            return [];
        }

        return $this->default_sorts ?: [];
    }

    private function scopeReturnNothing($query)
    {
        return $query->where('id', null);
    }
}
