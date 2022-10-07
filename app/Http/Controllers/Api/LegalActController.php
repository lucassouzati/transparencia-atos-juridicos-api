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
    public function index()
    {
        return LegalActResource::collection(LegalAct::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LegalActRequest $request)
    {
        $legal_act = LegalAct::create($request->all());

        return $legal_act;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LegalAct  $legalAct
     * @return \Illuminate\Http\Response
     */
    public function show(LegalAct $legalAct)
    {
        return new LegalActResource($legalAct);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LegalAct  $legalAct
     * @return \Illuminate\Http\Response
     */
    public function update(LegalActRequest $request, LegalAct $legalAct)
    {
        $legalAct->fill($request->validated())->save();
        return new LegalActResource($legalAct);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LegalAct  $legalAct
     * @return \Illuminate\Http\Response
     */
    public function destroy(LegalAct $legalAct)
    {
        $legalAct->delete();
        return response()->json(null, 204);
    }
}
