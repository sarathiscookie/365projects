<?php

namespace App\Http\Controllers\Backend;

use App\Facility;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Storage;

use App\Http\Requests\FacilityRequest;
use App\Http\Requests\FacilityUploadRequest;
use App\Formfield;
use App\Formvalue;

class FacilityController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * List User facilities
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listFacilities()
    {
        $user_id = Auth::user()->id;
        $facilities = Facility::where('facilities.user_id',$user_id)
            ->join('projects', 'projects.id','=','facilities.project_id')
            ->select('facilities.id','facilities.title','projects.title as project')
            ->orderBy('facilities.id', 'DESC')
            ->paginate(20);
        return view('backend.facilities', ['facilities' => $facilities]);
    }

    /**
     * show create facility view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCreate()
    {
        $groupTitle = '';
        $groupID    = '';
        $formFields = Formfield::select('form_fields.id' ,'form_groups.id as groupsid', 'form_fields.title', 'form_fields.description', 'form_fields.placeholder', 'form_fields.type', 'form_fields.options', 'form_groups.title as groupstitle' ,'form_groups.description')
            ->join('form_groups', 'form_fields.form_group_id','=','form_groups.id')
            ->where('form_fields.project_id', 1)
            ->where('form_fields.relation', 'facility')
            ->get();
        foreach($formFields as $formField){
            $groupTitle = $formField->groupstitle;
            $groupID    = $formField->groupsid;
        }
        return view('backend.createfacility', ['formFields' => $formFields, 'groupTitle' => $groupTitle, 'groupID' => $groupID]);
    }

    /**
     * save new facility
     * @param FacilityRequest $request
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function createFacility(FacilityRequest $request)
    {
        $user_id       = Auth::user()->id;
        $project_id    = 1; //should change to real values
        $title         = $request->title;
        $content       = $request->contents;
        $services      = $request->services;
        $terms         = $request->terms;
        $country       = $request->country;
        $street        = $request->street;
        $city          = $request->city;
        $postal        = $request->postal;

        /* For getting Geo Coordinates begin*/
        $address       = $street.'+'.$postal.'+'.$city.'+'.$country;
        $replaceSpace  = str_replace(" ", "+", $address);
        //Europa-Allee+50,+60327,+Frankfurt+am+Main,+Germany
        $geocode       = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$replaceSpace.'&key=AIzaSyDBNwmOAn7joStHCNjmx7nlvsHeN_W1lqA');
        $output        = json_decode($geocode);
        $latitude      = $output->results[0]->geometry->location->lat;
        $longitude     = $output->results[0]->geometry->location->lng;
        $geocoord      = $latitude .','. $longitude;
        /* For getting Geo Coordinates end*/

        $insert = Facility::create(['user_id'=>$user_id, 'project_id' => $project_id, 'title' => $title, 'content'=> $content, 'services' => $services, 'terms' => $terms, 'street' => $street, 'postal' => $postal, 'city' => $city, 'country' => $country, 'geocoord' => $geocoord]);
        $insert_id = $insert->id;

        if($insert_id>0){
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
                    $formValue->parent_id     = $insert_id;
                    $formValue->save();
                    $j++;
                }
            }
            // Form values end
            return redirect(url('/facilities'))->with('status', 'Facility created!');
        }
        return false;
    }

    /**
     * Facility view edit mode
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEdit($id)
    {
        $facility = Facility::find($id);
        // Form values begin
        $groupTitle = '';
        $groupID    = '';
        $formFields = Formfield::select('form_fields.id', 'form_groups.id as groupsid', 'form_fields.title', 'form_fields.type', 'form_fields.options', 'form_groups.title as groupstitle', 'form_groups.description', 'form_values.value', 'form_values.id as formvalueid', 'form_values.parent_id')
            ->join('form_groups', 'form_fields.form_group_id','=','form_groups.id')
            ->join('form_values', 'form_fields.id','=','form_values.form_field_id')
            ->where('form_fields.project_id', 1)
            ->where('form_fields.relation', 'facility')
            ->where('form_values.parent_id', $id)
            ->get();
        foreach($formFields as $formField){
            $groupTitle = $formField->groupstitle;
            $groupID    = $formField->groupsid;
        }
        // Form values end
        return view('backend.editfacility', ['facility' => $facility, 'formFields' => $formFields, 'groupTitle' => $groupTitle, 'groupID' => $groupID]);
    }

    /**
     * Update facility
     * @param FacilityRequest $request
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function updateFacility(FacilityRequest $request)
    {
        $id = $request->facility_id;

        /* For getting Geo Coordinates begin*/
        $address       = $request->street.'+'.$request->postal.'+'.$request->city.'+'.$request->country;
        $replaceSpace  = str_replace(" ", "+", $address);
        //Europa-Allee+50,+60327,+Frankfurt+am+Main,+Germany
        $geocode       = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$replaceSpace.'&key=AIzaSyDBNwmOAn7joStHCNjmx7nlvsHeN_W1lqA');
        $output        = json_decode($geocode);
        $latitude      = $output->results[0]->geometry->location->lat;
        $longitude     = $output->results[0]->geometry->location->lng;
        $geocoord      = $latitude .','. $longitude;
        /* For getting Geo Coordinates end*/

        $affectedRows = Facility::where('id', $id)->update(['title' => $request->title, 'content'=> $request->contents, 'services' => $request->services, 'terms' => $request->terms, 'street' => $request->street, 'postal' => $request->postal, 'city' => $request->city, 'country' => $request->country, 'geocoord' => $geocoord]);

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
                $IdResult            = $fieldsIdResult[$j];
                $ValField            = 'dynField_'.$IdResult;
                $ValResult           = $request->$ValField;
                $ValIDResult         = $formValueIdResult[$j];
                Formvalue::where('id', $ValIDResult)
                    ->update(['form_field_id' => $IdResult, 'value' => $ValResult]);
                $j++;
            }
        }
        // Form values end

        if($affectedRows>=0)
            return redirect(url('/facilities'))->with('status', 'Facility updated!');
        else
            return false;
    }

    /**
     * Facility images view - tabbed
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showFacilityImages($id)
    {
        $pictures = array();
        $facility = Facility::find($id);

        $dir      = storage_path().'/facility/'.$id.'/gallery';
        if(Storage::exists('/facility/'.$id.'/gallery')) {
            $pictures = scandir($dir);
            ksort($pictures);
        }
        return view('backend.facilityimages', ['facility' => $facility, 'pictures'=>$pictures]);
    }

    /**
     * upload images to facility - dropzone -Ajax
     * @param FacilityUploadRequest $request
     */
    public function uploadImages(FacilityUploadRequest $request)
    {
        $upload_base = '/facility/'.$request->id;
        $upload_dir  = $upload_base.'/gallery';


        if (!empty($_FILES)) {
            $files = Storage::files($upload_base);

            if (empty($files)) {
                Storage::makeDirectory($upload_base);
                Storage::makeDirectory($upload_dir);
            }

            $new_filename = $this->getNewFileName($upload_dir);
            $new_file = fopen($_FILES['file']['tmp_name'], 'r');

            Storage::put($upload_dir . '/' . $new_filename, $new_file);
        }
    }


    /**
     * get the next file name
     * @param $entryID
     * @return string
     */
    protected function getNewFileName($path)
    {
        $arr_file = array();
        $dir      = storage_path().$path;
        $pictures = scandir($dir);
        foreach($pictures as $file) {
            $arr_file[] = str_replace(".jpg","",$file);
        }
        if(max($arr_file)>0){
            $filename = (max($arr_file)+1).".jpg";
        }
        else {
            $filename = "1.jpg";
        }
        return $filename;
    }

    /**
     * Show Original image - gallery overlay
     * @param $path
     */
    public function getImageOriginal($path)
    {
        $im = imagecreatefromjpeg(storage_path() .'/facility/'. $path);

        header('Content-type: image/jpeg');
        imagejpeg($im);
        imagedestroy($im);
    }

    /**
     * Delete facility image
     * @param FacilityUploadRequest $request
     */
    public function unlinkImage(FacilityUploadRequest $request)
    {
        $image     = 'facility/'.str_replace("_","/gallery/",$request->item).".jpg";

        if (Storage::exists($image)) {
            Storage::delete($image);
            return response()->json(['mes' => 'done']);
        }
        else
            return response()->json(['mes' => 'Not deleted']);
    }

}
