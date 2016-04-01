<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\OfferdateRequest;
use App\Http\Controllers\Controller;
use App\Offerdate;
use App\Offer;

class OfferdateController extends Controller
{
    /**
     * OfferdateController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Save new offer date - Ajax
     * @param OfferdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OfferdateRequest $request)
    {
        $date_begin = null;
        $date_end   = null;
        if($request->offerdate !="")
        {
            $date_split = explode(" To ",$request->offerdate);
            $date_begin  = date('Y-m-d', strtotime($date_split[0]));
            $date_end    = date('Y-m-d', strtotime($date_split[1]));
        }
        $offer             = new Offerdate;
        $offer->offer_id   = $request->offer_id;
        $offer->date_begin = $date_begin;
        $offer->date_end   = $date_end;
        $offer->nights     = $request->nights;
        $offer->arrival    = $request->arrival;
        $offer->type       = $request->type;
        $offer->status     = $request->status;
        $offer->save();
        if($offer->id>0) {
           return response()->json(['response'=>1]);
        }
        else{
           return response()->json(['response'=>'error']);
        }
    }

    /**
     * Update an offer date - Ajax
     * @param OfferdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(OfferdateRequest $request)
    {
        $date_begin = null;
        $date_end   = null;
        if($request->offerdate !="")
        {
            $date_split = explode(" To ",$request->offerdate);
            $date_begin  = date('Y-m-d', strtotime($date_split[0]));
            $date_end    = date('Y-m-d', strtotime($date_split[1]));
        }
        $offerUpdate             = Offerdate::find($request->date_id);
        $offerUpdate->date_begin = $date_begin;
        $offerUpdate->date_end   = $date_end;
        $offerUpdate->nights     = $request->nights;
        $offerUpdate->arrival    = $request->arrival;
        $offerUpdate->type       = $request->type;
        $offerUpdate->status     = $request->status;

        if($offerUpdate->save()) {
            return response()->json(['response'=>1]);
        }
        else{
            return response()->json(['response'=>'error']);
        }
    }

}
