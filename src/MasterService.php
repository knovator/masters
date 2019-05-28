<?php

namespace Knovators\Masters;


use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Knovators\Masters\Http\Requests\Masters\CreateRequest;
use Knovators\Masters\Http\Requests\Masters\PartiallyUpdateRequest;
use Knovators\Masters\Http\Requests\Masters\RetrieveRequest;
use Knovators\Masters\Http\Requests\Masters\SubMasterRequest;
use Knovators\Masters\Http\Requests\Masters\UpdateRequest;
use Knovators\Masters\Http\Resources\MasterCollection;
use Knovators\Masters\Models\Master;
use Knovators\Masters\Repository\MasterRepository;
use Knovators\Support\Helpers\HTTPCode;
use Knovators\Support\Traits\APIResponse;
use Knovators\Support\Traits\DestroyObject;
use Prettus\Validator\Exceptions\ValidatorException;
use Knovators\Masters\Http\Resources\Master as MasterResource;

/**
 * Trait MasterService
 * @package Knovators\Masters
 */
trait MasterService
{

    use DestroyObject, APIResponse;

    protected $masterRepository;

    /**
     * Create a new controller instance.
     *
     * @param MasterRepository $masterRepository
     */
    public function __construct(MasterRepository $masterRepository) {
        $this->masterRepository = $masterRepository;
    }

    /**
     * @param CreateRequest $request
     * @return JsonResponse
     * @throws ValidatorException
     */
    public function store(CreateRequest $request) {
        $input = $request->all();
        try {
            $master = $this->masterRepository->createOrUpdateTrashed('code', $input['code'],
                $input);
            $master->load('image');

            return $this->sendResponse($this->makeResource($master),
                trans('masters::messages.created', ['module' => 'Master']),
                HTTPCode::CREATED);
        } catch (Exception $exception) {
            Log::error($exception);

            return $this->sendResponse(null, __('masters::messages.something_wrong'),
                HTTPCode::UNPROCESSABLE_ENTITY, $exception);
        }
    }

    /**
     * @param Master $master
     * @return mixed
     */
    private function makeResource($master) {

        if ($resource = config('masters.resource')) {
            return new $resource($master);
        }

        return new MasterResource($master);
    }

    /**
     * @param Master        $master
     * @param UpdateRequest $request
     * @return JsonResponse
     * @throws ValidatorException
     */
    public function update(Master $master, UpdateRequest $request) {
        try {
            $input = $request->all();
            $this->masterRepository->update($input, $master->id);
            return $this->sendResponse($this->makeResource($master->fresh('image')),
                trans('masters::messages.updated', ['module' => 'Master']),
                HTTPCode::OK);
        } catch (Exception $exception) {
            Log::error($exception);

            return $this->sendResponse(null, __('masters::messages.something_wrong'),
                HTTPCode::UNPROCESSABLE_ENTITY, $exception);
        }

    }

    /**
     * @param Master $master
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Master $master) {
        try {
            return $this->destroyModelObject(config('masters.delete_relations'), $master,
                'Master', 'masters');
        } catch (Exception $exception) {
            Log::error($exception);

            return $this->sendResponse(null, __('masters::messages.something_wrong'),
                HTTPCode::UNPROCESSABLE_ENTITY, $exception);
        }
    }


    /**
     * @param RetrieveRequest $request
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function index(RetrieveRequest $request) {
        $input = $request->all();
        try {
            $masters = $this->masterRepository->getActiveParentMasters($input);

            return $this->sendResponse($this->makeResourceCollection($masters),
                trans('masters::messages.retrieved', ['module' => 'Masters']),
                HTTPCode::OK);
        } catch (Exception $exception) {
            Log::error($exception);

            return $this->sendResponse(null, __('masters::messages.something_wrong'),
                HTTPCode::UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @param Master $masters
     * @return MasterCollection|JsonResponse
     */
    public function makeResourceCollection($masters) {
        if ($masters instanceof JsonResponse) {
            return $masters;
        }

        return new MasterCollection($masters);
    }

    /**
     * @param SubMasterRequest $request
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function childMasters(SubMasterRequest $request) {
        $input = $request->all();
        try {
            $masters = $this->masterRepository->getSubMasterList($input);

            /** @var Master $masters * */
            return $this->sendResponse($this->makeResourceCollection($masters),
                trans('masters::messages.retrieved', ['module' => 'Sub masters']),
                HTTPCode::OK);
        } catch (Exception $exception) {
            Log::error($exception);

            return $this->sendResponse(null, __('masters::messages.something_wrong'),
                HTTPCode::UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @param Master                 $master
     * @param PartiallyUpdateRequest $request
     * @return JsonResponse
     * @throws ValidatorException
     */

    public function partiallyUpdate(Master $master, PartiallyUpdateRequest $request) {
        $input = $request->all();
        $this->masterRepository->update($input, $master->id);

        return $this->sendResponse($this->makeResource($master->fresh('image')),
            trans('masters::messages.updated', ['module' => 'Master']),
            HTTPCode::OK);
    }

    /**
     * @param Master $master
     * @return JsonResponse
     */
    public function show(Master $master) {
        $master->load('image');
        return $this->sendResponse($this->makeResource($master),
            trans('masters::messages.retrieved', ['module' => 'Masters']),
            HTTPCode::OK);
    }
}
