<?php

namespace App\Http\Controllers\Cost;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cost\EditCostTrackingRequest;
use App\Http\Requests\Cost\ShowCostTrackingRequest;
use App\Models\Cost\CostTracking;
use App\Http\Requests\Cost\StoreCostTrackingRequest;
use App\Http\Requests\Cost\UpdateCostTrackingRequest;
use App\Services\Cost\CostService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CostTrackingController extends Controller
{
    protected CostService $cost_service;

    public function __construct(CostService $cost_service)
    {
        $this->cost_service = $cost_service;
    }

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index() : View
    {
        $costs_list = $this->cost_service->getCostsList();

        return view('cost.main', compact('costs_list'));
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create() : View
    {
        return view('cost.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCostTrackingRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCostTrackingRequest $request) : RedirectResponse
    {
        $this->cost_service->saveCost(collect($request->all()));

        return redirect()->intended(route('costs.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param ShowCostTrackingRequest $request
     * @return View
     */
    public function show(ShowCostTrackingRequest $request) : View
    {
        $cost_info = $this->cost_service->processCostInfo(
            $request->getCostTracking()
        );

        return view('cost.show', compact('cost_info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CostTracking $costTracking
     * @return View
     */
    public function edit(EditCostTrackingRequest $request) : View
    {
        $cost_info = $this->cost_service->processCostInfo(
            $request->getCostTracking()
        );

        return view('cost.edit', compact('cost_info'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCostTrackingRequest $request
     * @return RedirectResponse
     */
    public function update(UpdateCostTrackingRequest $request) : RedirectResponse
    {
        $cost_tracking = $request->getCostTracking();

        $this->cost_service->updateCost(
            $cost_tracking,
            $request->collect()
        );

        return redirect(route('costs.show', ['cost' => $cost_tracking->id]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CostTracking $costTracking)
    {
        //
    }
}
