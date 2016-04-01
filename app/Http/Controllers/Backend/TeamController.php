<?php

namespace App\Http\Controllers\Backend;

use App\Facility;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Team;
use App\Http\Requests\TeamRequest;
use App\Http\Requests\MemberRequest;
use Storage;

class TeamController extends Controller
{
    /**
     * TeamController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * List Team of members belongs a facility
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listTeam($id)
    {
        $members = Team::where('facility_id',$id)
            ->select('id','name','position','email','phone')
            ->orderBy('name')
            ->paginate(20);

        $facility = Facility::find($id);

        return view('backend.team', ['members' => $members,'facility' =>$facility]);
    }

    /**
     * show Create member form
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCreate($id)
    {
        $facility = Facility::find($id);
        return view('backend.createteammember', ['facility_id'=>$id, 'facility' =>$facility]);
    }

    /**
     * Insert new member
     * @param TeamRequest $request
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function createTeamMember(TeamRequest $request)
    {
        $member = new Team();
        $member->name        = $request->name;
        $member->position    = $request->position;
        $member->phone       = $request->phone;
        $member->email       = $request->email;
        $member->facility_id = $request->facility_id;
        $member->save();
        if($member->id>0){
            return redirect(url('/facility/team/edit/'.$member->id))->with('status', 'Member created!');
        }
        return false;
    }

    /**
     * Show edit mode - member
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEdit($id)
    {
        $member = Team::find($id);

        $facility = Facility::find($member->facility_id);

        $member_image = $this ->getMemberImage($member->facility_id,$id);

        return view('backend.editteammember', ['member' => $member, 'facility' =>$facility,'member_image'=>$member_image]);
    }

    /**
     * Update member details
     * @param TeamRequest $request
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function updateTeamMember(TeamRequest $request)
    {
        $member = Team::find($request->team_id);
        $member->name        = $request->name;
        $member->position    = $request->position;
        $member->phone       = $request->phone;
        $member->email       = $request->email;
        $member->save();
        if($member->save())
            return redirect(url('/facility/team/'.$member->facility_id))->with('status', 'Member updated!');
        return false;

    }

    /**
     * Delete team member
     * @param MemberRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTeamMember(MemberRequest $request)
    {
        if(!$request->ajax()) {
            return response()->json(['mes' => 'bad request']);
            exit;
        }
        $this->destroyMemberImage();
        $member = Team::destroy($request->member);
        if($member>0)
            return response()->json(['mes' => 'done']);
        else
            return response()->json(['mes' => 'Not deleted']);
    }

    /**
     * Store Member avatar
     * @param $id
     * @param MemberRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function storeMemberImage($id,MemberRequest $request)
    {
        $team = Team::find($id);

        $tmp				 = explode(',',$_POST['data']);
        $imgdata 			 = base64_decode($tmp[1]);
        $imgname             = explode('.',$request->name);
        $extension			 = strtolower(end($imgname));
        $directory           = 'facility/'.$team->facility_id.'/team';

        if(!Storage::exists($directory)) {
            Storage::makeDirectory($directory,0777);
        }
        Storage::put($directory . '/' .$id.'.' . $extension, $imgdata);
        $response = array(
            "status" 		=> "success",
            "url" 			=> "/facility/team/image/".$id,
            "filename" 		=> "/facility/team/image/".$id
        );

        return response($response, 200);
    }

    /**
     * Show member avatar
     * @param $id
     * @return mixed
     */
    public function showMemberImage($id)
    {
        $file ='';
        $team = Team::find($id);
        $path = 'facility/'.$team->facility_id.'/team';

        $directories         = Storage::files($path);
        foreach($directories as $values){
            $split_folder_file = explode('/', $values);
            $splitted_file     = end($split_folder_file);
            $explode_filename  = explode('.', $splitted_file);
            $explode_name      = $explode_filename[0];
            $file_extension    = $explode_filename[1];
            if ($explode_name == $id) {
                switch( $file_extension ) {
                    case "gif": $ctype="image/gif"; break;
                    case "png": $ctype="image/png"; break;
                    case "jpeg":
                    case "jpg": $ctype="image/jpeg"; break;
                    default:
                }
                $file = Storage::get($path.'/'.$splitted_file);
            }
        }
        if($file=='') {
            $default_filename = 'profile.png';
            $explode_filename = explode('.', $default_filename);
            $file_extension = $explode_filename[1];
            switch ($file_extension) {
                case "gif":
                    $ctype = "image/gif";
                    break;
                case "png":
                    $ctype = "image/png";
                    break;
                case "jpeg":
                case "jpg":
                    $ctype = "image/jpeg";
                    break;
                default:
            }
            $file = public_path() . '/' . $default_filename;
        }
        return response($file, 200)->header('Content-Type', $ctype);
    }

    /**
     * Delete member avatar
     * @param $id
     */
    public function destroyMemberImage($id)
    {
        $team = Team::find($id);

        $path                = 'facility/'.$team->facility_id.'/team';
        $directories         = Storage::files($path);
        foreach($directories as $values)
        {
            $split_folder_file = explode('/', $values);
            $splitted_file     = end($split_folder_file);
            $explode_filename  = explode('.', $splitted_file);
            $explode_name      = $explode_filename[0];
            if ($explode_name == $id) {
                Storage::delete($path . '/' . $splitted_file);
            }
        }
    }

    /**
     * get member image name - for edit mode
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
                    $return = $image[0];
                }
            }
        }
        return $return;
    }
}
