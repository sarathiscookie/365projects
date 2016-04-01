<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\OfferRequest;
use App\Http\Controllers\Controller;
use App\Offer;
use App\Offerdate;
use App\Facility;
use Auth;
use App\Formfield;
use App\Formvalue;

class OfferController extends Controller
{
    /**
     * OfferController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($facilityId)
    {
        $facility   = Facility::find($facilityId);
        $groupTitle = '';
        $groupID    = '';
        $formFields = Formfield::select('form_fields.id' ,'form_groups.id as groupsid', 'form_fields.title', 'form_fields.description', 'form_fields.placeholder', 'form_fields.type', 'form_fields.options' ,'form_groups.title as groupstitle' ,'form_groups.description')
            ->join('form_groups', 'form_fields.form_group_id','=','form_groups.id')
            ->where('form_fields.project_id', 1)
            ->where('form_fields.relation', 'offer')
            ->get();
        foreach($formFields as $formField){
            $groupTitle = $formField->groupstitle;
            $groupID    = $formField->groupsid;
        }
        return view('backend.addoffer', ['formFields' => $formFields, 'groupTitle' => $groupTitle, 'groupID' => $groupID, 'facility'=>$facility]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OfferRequest $request, $facilityId)
    {
        $published_at   =null;
        $unpublished_at =null;
        if($request->publishrange !="")
        {
           $date_split = explode(" To ",$request->publishrange);
           $published_at   = date('Y-m-d H:i', strtotime($date_split[0]));
           $unpublished_at = date('Y-m-d H:i', strtotime($date_split[1]));
        }
        $offer                 = new Offer;
        $offer->facility_id    = $facilityId;
        $offer->title          = $request->title;
        $offer->subtitle       = $request->subtitle;
        $offer->alias          = $request->alias;
        $offer->description    = $request->description;
        $offer->header         = $request->header;
        $offer->footer         = $request->footer;
        $offer->freetext1      = $request->freetext1;
        $offer->freetext2      = $request->freetext2;
        $offer->type           = $request->type;
        $offer->type_date      = $request->typedate;
        $offer->price          = $request->price;
        $offer->pseudo_price   = $request->pseudoprice;
        $offer->discount       = $request->discount;
        $offer->status         = $request->status;
        $offer->published_at   = $published_at;
        $offer->unpublished_at = $unpublished_at;
        $offer->save();

        // Form values begin
        if($request->groupID){
            foreach($request->fieldID as $values){
                $fieldsIdResult[]   = $values;
            }

            $j = 0;
            while($j < count($request->fieldID)) {
                $IdResult                 = $fieldsIdResult[$j];
                $ValField                 = 'dynField_'.$IdResult;
                $formValue                = new Formvalue;
                $formValue->form_field_id = $IdResult;
                $formValue->value         = $request->$ValField;
                $formValue->parent_id     = $offer->id;
                $formValue->save();
                $j++;
            }
        }
        // Form values end
        return redirect(url('/facility/offer/'.$facilityId))->with('status', 'Offer added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offers = Offer::where('facility_id',$id)->where('status','<>','deleted')
            ->select('id','title','subtitle','alias')
            ->orderBy('published_at', 'DESC')
            ->orderBy('title')
            ->paginate(20);
        $facility = Facility::find($id);
        return view('backend.offers', ['offers' => $offers,'facility' =>$facility]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($offerId)
    {
        $date_range ='';
        $offerDetails = Offer::where('id', $offerId)->first();
        if($offerDetails->published_at!=null && $offerDetails->unpublished_at!=null)
        {
            $date_range = date('d-m-Y h:i A', strtotime($offerDetails->published_at)).' To '.date('d-m-Y h:i A', strtotime($offerDetails->unpublished_at));
        }
        $facility   = Facility::find($offerDetails->facility_id);
        $offerDates = $this->listOfferDates($offerId);

        // Form values begin
        $groupTitle = '';
        $groupID    = '';
        $formFields = Formfield::select('form_fields.id', 'form_groups.id as groupsid', 'form_fields.title', 'form_fields.type', 'form_fields.options', 'form_groups.title as groupstitle', 'form_groups.description', 'form_values.value', 'form_values.id as formvalueid', 'form_values.parent_id')
            ->join('form_groups', 'form_fields.form_group_id','=','form_groups.id')
            ->join('form_values', 'form_fields.id','=','form_values.form_field_id')
            ->where('form_fields.project_id', 1)
            ->where('form_fields.relation', 'offer')
            ->where('form_values.parent_id', $offerId)
            ->get();
        foreach($formFields as $formField){
            $groupTitle = $formField->groupstitle;
            $groupID    = $formField->groupsid;
        }
        // Form values end

        return view('backend.editoffer', ['offerDetails' => $offerDetails, 'date_range'=>$date_range, 'facility' =>$facility, 'offerDates'=>$offerDates, 'formFields' => $formFields, 'groupTitle' => $groupTitle, 'groupID' => $groupID]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OfferRequest $request, $offerId)
    {
        $published_at   =null;
        $unpublished_at =null;
        if($request->publishrange !="")
        {
            $date_split = explode(" To ",$request->publishrange);
            $published_at   = date('Y-m-d H:i', strtotime($date_split[0]));
            $unpublished_at = date('Y-m-d H:i', strtotime($date_split[1]));
        }
        $offerUpdate                 = Offer::find($offerId);
        $offerUpdate->title          = $request->title;
        $offerUpdate->subtitle       = $request->subtitle;
        $offerUpdate->alias          = $request->alias;
        $offerUpdate->description    = $request->description;
        $offerUpdate->header         = $request->header;
        $offerUpdate->footer         = $request->footer;
        $offerUpdate->freetext1      = $request->freetext1;
        $offerUpdate->freetext2      = $request->freetext2;
        $offerUpdate->type           = $request->type;
        $offerUpdate->type_date      = $request->typedate;
        $offerUpdate->price          = $request->price;
        $offerUpdate->pseudo_price   = $request->pseudoprice;
        $offerUpdate->discount       = $request->discount;
        $offerUpdate->status         = $request->status;
        $offerUpdate->published_at   = $published_at;
        $offerUpdate->unpublished_at = $unpublished_at;
        $offerUpdate->save();

        // Form values begin
        if($request->groupID){
            foreach($request->fieldID as $values){
                $fieldsIdResult[]   = $values;
            }

            foreach($request->formValueID as $valueid){
                $formValueIdResult[] = $valueid;
            }

            $j = 0;
            while($j < count($request->fieldID)) {
                $IdResult             = $fieldsIdResult[$j];
                $ValField             = 'dynField_'.$IdResult;
                $ValResult            = $request->$ValField;
                $ValIDResult          = $formValueIdResult[$j];
                Formvalue::where('id', $ValIDResult)
                    ->update(['form_field_id' => $IdResult, 'value' => $ValResult]);
                $j++;
            }
        }
        // Form values end
        return redirect(url('/facility/offer/edit/'.$offerId))->with('status', 'Offer updated successfully!');
    }

    /**
     * Delete offer - change status to deleted, same for all dates
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $affectedoffer = Offer::where('id', $id)->update(array('status' =>'deleted'));
        $affecteddates = Offerdate::where('offer_id', $id)->update(array('status' =>'deleted'));
        if($affectedoffer>=0)
            return response()->json(['mes'=>'done']);
        else
            return response()->json(['mes'=>'Not deleted']);
    }

    /**
     * list all offer dates - edit mode of offer
     * @param $offerId
     * @return mixed
     */
    protected function listOfferDates($offerId)
    {
        $offerdates = Offerdate::with('offer')->where('offer_id',$offerId)->orderBY('date_end','DESC')->get();
        return $offerdates;
    }
}
