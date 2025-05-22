<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClustersRequest;
use App\Http\Requests\UpdateClustersRequest;
use App\Models\Cluster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClusterApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {

        $clusterNumber = $request->perPage;
        $search = $request->search;

        $query = Cluster::query();

        $searchableFields = ['cluster', 'code', 'title', 'qualification', 'qualification_code' ];

        if ($search) {
            foreach ($searchableFields as $field) {
                $query->orWhere($field, 'like', '%' . $search . '%');
            }
        }

        $clusters = $query->paginate($clusterNumber ?? 6);

        if ($clusters->isNotEmpty()) {
            return ApiResponse::success($clusters, 'All Clusters Found', 201);
        }

        return ApiResponse::error([], 'No Clusters Found', 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClustersRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $validated['qualification'] = $validated['qualification'] ?? null;
        $validated['qualification_code'] = $validated['qualification_code'] ?? null;

        $cluster = Cluster::create($validated);

        return ApiResponse::success($cluster, 'Cluster added', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {

        $cluster = Cluster::find($id);

        if ($cluster) {
            return ApiResponse::success($cluster, 'Cluster Found', 201);
        }

        return ApiResponse::error([], 'Specific Cluster Not Found', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClustersRequest $request, Cluster $cluster): JsonResponse
    {
        $validated = $request->validated();

        $validated['qualification'] = $validated['qualification'] ?? null;
        $validated['qualification_code'] = $validated['qualification_code'] ?? $validated['qualification'];

        $cluster = Cluster::create($validated);

        return ApiResponse::success($cluster, 'Cluster Updated', 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($clusterId): JsonResponse
    {
        $cluster = Cluster::find($clusterId);

        if (!$cluster) {
            return ApiResponse::error([], 'Specific Cluster Not Found', 404);
        }
        $cluster->delete();
        return ApiResponse::success([], 'Cluster deleted', 201);
    }
}
