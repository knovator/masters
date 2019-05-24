<?php

namespace Knovators\Masters;


use App\Support\HTTPCode;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Knovators\Masters\Http\Requests\Masters\CreateRequest;
use Knovators\Masters\Http\Requests\Masters\PartiallyUpdateRequest;
use Knovators\Masters\Http\Requests\Masters\RetrieveRequest;
use Knovators\Masters\Http\Requests\Masters\SubMasterRequest;
use Knovators\Masters\Http\Requests\Masters\UpdateRequest;
use Knovators\Masters\Http\Resources\Master as MasterResource;
use Knovators\Masters\Http\Resources\MasterCollection;
use Knovators\Masters\Models\Master;
use Knovators\Masters\Repository\MasterRepository;
use Knovators\Support\Traits\APIResponse;
use Knovators\Support\Traits\DestroyObject;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Trait MasterService
 * @package Knovators\Masters
 */
trait MasterService
{

    use DestroyObject, APIResponse;


    private $masterRepository;

    /**
     * Create a new controller instance.
     *
     * @param MasterRepository $masterRepository
     */
    public function __construct(MasterRepository $masterRepository)
    {
        $this->masterRepository = $masterRepository;
    }

    /**
     * @param CreateRequest $request
     * @return JsonResponse
     * @throws ValidatorException
     */
    public function store(CreateRequest $request)
    {
        $input = $request->all();
        try {
            $master = $this->masterRepository->createOrUpdateTrashed('code', $input['code'],
                $input);
//            $master->load('image');
            return $this->sendResponse($this->makeResource($master),
                __('messages.created', ['module' => 'Master']),
                HTTPCode::CREATED);
        } catch (Exception $exception) {
            Log::error($exception);

            return $this->sendResponse(null, __('messages.something_wrong'),
                HTTPCode::UNPROCESSABLE_ENTITY, $exception);
        }
    }

    /**
     * @param Master $master
     * @return MasterResource
     */
    private function makeResource($master)
    {
        return new MasterResource($master);
    }

    /**
     * @param Master $master
     * @param UpdateRequest $request
     * @return JsonResponse
     * @throws ValidatorException
     */
    public function update(Master $master, UpdateRequest $request)
    {
        try {
            $input = $request->all();
            $this->masterRepository->update($input, $master->id);
            return $this->sendResponse($this->makeResource($master->fresh()),
                __('messages.updated', ['module' => 'Master']),
                HTTPCode::OK);
        } catch (Exception $exception) {
            Log::error($exception);

            return $this->sendResponse(null, __('messages.something_wrong'),
                HTTPCode::UNPROCESSABLE_ENTITY, $exception);
        }

    }


    /**
     * @param Master $master
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Master $master)
    {
        try {
            return $this->removeMaster($master);
        } catch (Exception $exception) {
            Log::error($exception);

            return $this->sendResponse(null, __('messages.something_wrong'),
                HTTPCode::UNPROCESSABLE_ENTITY, $exception);
        }
    }


    /**
     * @param $master
     * @return JsonResponse
     */
    private function removeMaster($master)
    {
        $relations = [


        ];
        return $this->destroyModelObject($relations, $master, 'Master');
    }


    /**
     * @param RetrieveRequest $request
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function index(RetrieveRequest $request)
    {
        $input = $request->all();
        try {
            $masters = $this->masterRepository->getActiveParentMasters($input);

            return $this->sendResponse($this->makeResourceCollection($masters),
                __('messages.retrieved', ['module' => 'Masters']),
                HTTPCode::OK);
        } catch (Exception $exception) {
            Log::error($exception);

            return $this->sendResponse(null, __('messages.something_wrong'),
                HTTPCode::UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @param Master $masters
     * @return MasterCollection|JsonResponse
     */
    public function makeResourceCollection($masters)
    {
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
    public function childMasters(SubMasterRequest $request)
    {
        $input = $request->all();
        try {
            $masters = $this->masterRepository->getSubMasterList($input);

            /** @var Master $masters * */
            return $this->sendResponse($this->makeResourceCollection($masters),
                __('messages.retrieved', ['module' => 'Sub Masters']),
                HTTPCode::OK);
        } catch (Exception $exception) {
            Log::error($exception);

            return $this->sendResponse(null, __('messages.something_wrong'),
                HTTPCode::UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @param Master $master
     * @param PartiallyUpdateRequest $request
     * @return JsonResponse
     * @throws ValidatorException
     */

    public function partiallyUpdate(Master $master, PartiallyUpdateRequest $request)
    {
        $input = $request->all();
        $this->masterRepository->update($input, $master->id);

        return $this->sendResponse($this->makeResource($master->fresh()),
            __('messages.updated', ['module' => 'Master']),
            HTTPCode::OK);
    }

    /**
     * @param Master $master
     * @return JsonResponse
     */
    public function show(Master $master)
    {
        return $this->sendResponse($this->makeResource($master),
            __('messages.retrieved', ['module' => 'Master']),
            HTTPCode::OK);
    }
}
