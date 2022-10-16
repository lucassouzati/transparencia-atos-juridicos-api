<?php

namespace App\Http\Controllers\Api;

use App\Models\Subscription;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subscriptions = Subscription::when($request->get('user_id'), fn ($query) => $query->where('user_id', $request->get('user_id')))
                            ->when($request->get('type_id'), fn ($query) => $query->where('type_id', $request->get('type_id')))
                            ->paginate(100);
        return SubscriptionResource::collection($subscriptions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubscriptionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubscriptionRequest $request)
    {
        $subscription = Subscription::create($request->all());
        return new SubscriptionResource($subscription);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        return new SubscriptionResource($subscription);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubscriptionRequest  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubscriptionRequest $request, Subscription $subscription)
    {
        $subscription->fill($request->all())->save();
        return new SubscriptionResource($subscription);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return response()->json([null], 204);
    }
}
