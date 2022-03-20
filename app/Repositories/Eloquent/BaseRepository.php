<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\RepositoryException;
use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

abstract class BaseRepository implements EloquentRepositoryInterface
{
    protected $fillable = [];

    /**
     * @var Model
     */
    protected $model;

    private $container;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $query;

    /**
     * BaseRepository constructor.
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->model     = $this->makeModel();
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws RepositoryException
     */
    public function query(): Builder
    {
        if ($this->query instanceof Builder) {
            return $this->query;
        }

        return $this->model->newQuery();
    }

    /**
     * Make model.
     *
     * @throws RepositoryException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return mixed
     */
    public function makeModel(): Model
    {
        $model = $this->container->make($this->getModelName());

        if (!$model instanceof Model) {
            throw new RuntimeException('Class {' . get_class($this->model) . '} must be an instance of Illuminate\\Database\\Eloquent\\Model', );
        }

        return $model;
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param $id
     *
     * @return Model
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Find a collection of models by conditions.
     *
     * @param array $conditions Array of conditions
     * @param array $relations  An array of relations
     * @param bool  $paginate   Either paginated or not
     * @param int   $pageSize   Page size
     *
     * @return ?Collection|?LengthAwarePaginator A collection or paginated result
     */
    public function findBy(array $conditions, array $relations = [], bool $paginate = true, int $pageSize = 10)
    {
        $query = $this
            ->query()
            ->with($relations)
            ->where($conditions)
        ;

        return $paginate ? $query->paginate($pageSize) : $query->get();
    }

    /**
     * Find a model by conditions.
     *
     * @param array $conditions Array of conditions
     * @param array $relations  An array of relations
     *
     * @return ?Model The first result if the collection
     */
    public function findOneBy(array $conditions, array $relations = [])
    {
        return $this
            ->query()
            ->with($relations)
            ->where($conditions)
            ->first()
        ;
    }

    /**
     * Delete a model.
     *
     * @param Model $object
     */
    public function delete(Model $model): ?bool
    {
        if (is_numeric($model)) {
            $model = $this->find($model)->first();
        }

        return $model->delete();
    }

    /**
     * Update an entity.
     *
     * @param mixed $object
     *
     * @return Model model
     */
    public function update(Model $model, array $data)
    {
        if (!($model instanceof Model)) {
            $model = $this->find($model);
        }

        $data['updated_at'] = new Carbon('now');
        
        $fillable = $model->getFillable();
        if (!empty($fillable)) {
            $model->fillable($fillable)->fill($data);
        }

        $model->save();

        return $model;
    }

    abstract protected function getModelName();
}
