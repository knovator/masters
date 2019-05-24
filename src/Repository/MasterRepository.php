<?php


namespace Knovators\Masters\Repository;


use Knovators\Masters\Criteria\IsActiveCriteria;
use Knovators\Masters\Models\Master;
use Knovators\Support\Traits\BaseRepository;
use Knovators\Support\Traits\StoreWithTrashedRecord;

/**
 * Class MasterRepository
 * @package Knovators\Masters\Repository
 */
class MasterRepository extends BaseRepository
{

    use StoreWithTrashedRecord;

    /**
     * Configure the Model
     *
     **/
    public function model()
    {
        return Master::class;
    }

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(IsActiveCriteria::class);
    }


    /**
     * @param $input
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Exception
     */
    public function getActiveParentMasters($input)
    {
        $masters = $this->model->whereNull('parent_id')->orderByDesc('id');
        if (isset($input['code'])) {
            $masters = $masters->whereCode($input['code']);
        }
        /** @var Master $masters */
        if (!isset($input['all'])) {
            $this->applyCriteria();
            $masters = $masters->with([
                'childMasters' => function ($query) use ($input) {
                    if (isset($input['length'])) {
                        $query = $query->inRandomOrder()->take($input['length']);
                    }
                    $query->isActive();
                }
            ]);
            $masters = $masters->get()->keyBy('code');
        } else {
            $masters = datatables()->of($masters)
                ->editColumn('image', '{{$master_image}}')
                ->make(true);
        }
        $this->resetModel();

        return $masters;
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function getSubMasterList($input)
    {
        $masters = $this->model
            ->where('parent_id', '=', $input['parent_id'])->orderByDesc('id');

        return datatables()->of($masters)
            ->editColumn('image', '{{$master_image}}')
            ->make(true);
    }


    /**
     * @param $name
     * @param $parentId
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function findByNameWithMaster($name, $parentId)
    {
        $master = $this->model->where([
            'name' => $name,
            'parent_id' => $parentId
        ])->first();
        $this->resetModel();

        return $master;
    }

}
