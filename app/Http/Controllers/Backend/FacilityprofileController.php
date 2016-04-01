<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Facility;
use App\Team;
use App\Offer;
use App\Offerdate;
use App\Formfield;
use App\Formvalue;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Storage;

class FacilityprofileController extends Controller
{
    /**
     * FacilityprofileController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * SHow Facility Profile - All associated data with a facility - details, images, team, offer, offer dates, Form fields values etc.
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showFacility($id)
    {
        $user_id  = Auth::user()->id;
        $facility = Facility::where('facilities.user_id',$user_id)->find($id);
        $pictures = $this->getFacilityImages($id);
        $members  = $this->getFacilityTeam($id);
        $offers   = $this->getFacilityOffers($id);
        $form_values = $this->getFormFieldValues($id,'facility');


        return view('backend.facilityprofile', ['facility' => $facility, 'pictures'=>$pictures, 'members'=>$members, 'offers' =>$offers, 'form_values'=>$form_values]);
    }

    /**
     * get images associated with a facility
     * @param $id
     * @return array
     */
    protected function getFacilityImages($id)
    {
        $pictures = array();

        $dir      = storage_path().'/facility/'.$id.'/gallery';
        if(Storage::exists('/facility/'.$id.'/gallery')) {
            $pictures = scandir($dir);
            ksort($pictures);
        }
        return $pictures;
    }

    /**
     * Get team members of a facility
     * @param $id
     * @return mixed
     */
    protected function getFacilityTeam($id)
    {
        $members = Team::where('facility_id',$id)
            ->orderBy('name')
            ->get();
        return $members;
    }

    /**
     * get member image name - for profile
     * @param $facility_id
     * @return mixed
     */
    public function getMemberImage($facility_id,$id)
    {
        $return = '';
        $path                = 'facility/'.$facility_id.'/team';
        if(Storage::exists($path)) {
            $directories = Storage::files($path);
            foreach ($directories as $values) {
                $split_folder_file = explode('/', $values);
                $splitted_file = end($split_folder_file);
                $image = explode('.', $splitted_file);
                if ($image[0] == $id) {
                    $return = $splitted_file;
                }
            }
        }
        return $return;
    }

    /**
     * Get All offers under a facility
     * @param $id
     * @return string
     */
    protected function getFacilityOffers($id)
    {
        $offers = Offer::where('facility_id',$id)
            ->where('status','<>','deleted')
            ->select('id','title','subtitle','description', 'price','pseudo_price')
            ->orderBy('created_at','DESC')
            ->get();

        $offer_html ='';
        foreach ($offers as $offer) {
            $dates       = $this->getOfferDates($offer->id);
            $form_values = $this->getFormFieldValues($offer->id,'offer');
            $offer_html .='<div class="col-md-4"><div class="panel panel-info">
  <div class="panel-heading separator">
    <div class="panel-title">'.$offer->title.'</div>
  </div>
  <div class="panel-body">
    '.$offer->subtitle.'
    <p>'.$offer->description.'</p>
    '.$form_values.'
    <div class="p-b-10">
    <span class="bold">'.$offer->pseudo_price.' EUR</span>  only <span class="bold">'.$offer->price.' EUR</span>
    </div>
    '.$dates.'
    <button type="button" class="btn btn-primary btn-block">Booking</button>
  </div>
</div>
</div>';
        }
        return $offer_html;
    }

    /**
     * Get all offer dates with an offer
     * @param $offer_id
     * @return string
     */
    protected function getOfferDates($offer_id)
    {
        $offer_date = Offerdate::where('offer_id',$offer_id)
            ->select('id','date_begin','date_end','nights', 'arrival')
            ->orderBy('date_end', 'DESC')
            ->get();
        $date_html = '';
        foreach ($offer_date as $date) {
            $date_html .='<div class="well">
<p class="bold">'.date('d.m.Y', strtotime($date->date_begin)).' to '.date('d.m.Y', strtotime($date->date_end)).'</p>
<label>Arrival:  </label> '.$date->arrival.' <label>Nights:  </label> '.$date->nights.'
</div>';
        }
        return $date_html;
    }

    /**
     * Get Form field values associated with an offer - parent_id
     * @param $offer_id
     * @return string
     */
    protected function getFormFieldValues($offer_id,$relation)
    {
        $form_values = Formvalue::where('parent_id',$offer_id)
            ->where('FLD.relation','=',$relation)
            ->join('form_fields AS FLD', 'FLD.id','=','form_values.form_field_id')
            ->select('form_values.id','value','FLD.title')
            ->get();
        $form_value = '';
        foreach($form_values as $value)
        {
            $form_value .='<p><label>'.$value->title.' : </label> '.$value->value.'</p>';
        }
        if($form_value!='')
            $form_value ='<div class="well">
<h4><small>Form field values</small></h4>
'.$form_value.'
</div>';

        return $form_value;
    }


}
