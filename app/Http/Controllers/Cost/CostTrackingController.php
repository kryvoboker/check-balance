<?php

namespace App\Http\Controllers\Cost;

use App\Http\Controllers\Controller;
use App\Models\Cost\CostTracking;
use App\Http\Requests\Cost\StoreCostTrackingRequest;
use App\Http\Requests\Cost\UpdateCostTrackingRequest;
use App\Services\Cost\CostService;

class CostTrackingController extends Controller
{
    protected CostService $cost_service;

    public function __construct(CostService $cost_service)
    {
        $this->cost_service = $cost_service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $costs_list = $this->cost_service->getCostsList();

        return view('cost.main', compact('costs_list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCostTrackingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CostTracking $costTracking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CostTracking $costTracking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCostTrackingRequest $request, CostTracking $costTracking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CostTracking $costTracking)
    {
        //
    }
}
