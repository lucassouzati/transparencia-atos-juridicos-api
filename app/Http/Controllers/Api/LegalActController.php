<?php

namespace App\Http\Controllers\Api;

use App\Models\LegalAct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\LegalActResource;
use App\Http\Requests\LegalAct\LegalActRequest;

class LegalActController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $request->all();
        $legalActs = LegalAct::when(isset($filters["title"]), function ($query) use ($filters)
            {
                return $query->where("title", 'like', $filters['title']);
            })
            ->when(isset($filters["type"]), function ($query) use ($filters)
            {
                return $query->where("type", $filters['type']);
            })
            ->when(isset($filters["description"]), function ($query) use ($filters)
            {
                return $query->where("description", $filters['description']);
            })
            ->when(isset($filters['start_act_date']), function ($query) use ($filters){
                if(isset($filters['end_act_date']))
                    return $query->whereBetween('act_date', [$filters['start_act_date'], $filters['end_act_date']]);
                else
                    return $query->where('act_date','>=', $filters['start_act_date']);
            })
            ->when(isset($filters["order_by"]), function ($query) use ($filters)
            {
                return $query->orderBy($filters["order_by"]);
            }, function ($query) {
                return $query->orderBy("act_date");
            })
            ->when(isset($filters["order_by"]), function ($query) use ($filters)
            {
                return $query->orderBy($filters["order_by"]);
            }, function ($query) {
                return $query->orderBy("act_date");
            })
            ->when(isset($filters["paginate"]), function ($query) use ($filters)
            {
                return $query->paginate($filters["paginate"]);
            }, function ($query) {
                return $query->paginate(100);
            });

        return LegalActResource::collection($legalActs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LegalActRequest $request)
    {
        $legalAct = LegalAct::create($request->all());

        return new LegalActResource($legalAct);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LegalAct  $legalAct
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $legalAct = LegalAct::findOrFail($id);
        return new LegalActResource($legalAct);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LegalAct  $legalAct
     * @return \Illuminate\Http\Response
     */
    public function update(LegalActRequest $request, $id)
    {
        $legalAct = LegalAct::findOrFail($id);
        $legalAct->fill($request->validated())->save();
        return new LegalActResource($legalAct);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LegalAct  $legalAct
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $legalAct = LegalAct::findOrFail($id);
        $legalAct->delete();
        return response()->json(null, 204);
    }
}
