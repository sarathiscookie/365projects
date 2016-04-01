<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Search;
use App\Facility;
use App\Offer;
use App\Offerdate;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;


class SearchController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('search',[]);
    }

    /**
     * Do front-end search
     * @param SearchRequest $request
     */
    public function search(SearchRequest $request)
    {
        $response ='';
        $keyword  = explode(" ", $request->keyword);

        $keywords = "";
        foreach ($keyword AS $key => $value) {
            $keywords .= "+" . $value . " ";
        }

        $search = Search::where('project_id',1)->whereRaw("MATCH(searchtext) AGAINST(? IN BOOLEAN MODE)", array($keywords))->get();
        $data   = $this->getResults($search);

        if(count($search)>0) {
            foreach ($data AS $relation => $found) {
                foreach ($found AS $result) {
                    $title = $result["title"];
                    $display = $result["display"];
                    $response .= '<li class="list-unstyled"><a href="#" title="' . $title . '">' . $display . '</a></li>';
                }
            }
        }
        if ($response != '')
            print '<div class="block"><ul class="no-margin no-padding">'. $response .'</ul></div>';
        else
            print '';

    }

    /**
     * Prepare search out put array
     * @param $results
     * @return array
     */
    protected function getResults($results)
    {
        $data          = array();
        $data_facility = array();
        $data_offer    = array();
        foreach ($results as $row){
            if($row->relation=='facility'){
                $facility = Facility::find($row->parent_id);
                $data_facility[$facility->id]['title']   = $facility->title;
                $data_facility[$facility->id]['id']      = $facility->id;
                $data_facility[$facility->id]['display'] = title_case($row->relation).' - '.$facility->title;
            }
            elseif($row->relation=='offer') {
                $offer = Offer::find($row->parent_id);
                $price = ($offer->price>0)?' '.$offer->price.' EUR':'';
                $data_offer[$offer->id]['title']   = $offer->title;
                $data_offer[$offer->id]['id']      = $offer->id;
                $data_offer[$offer->id]['display'] = title_case($row->relation).' - '.$offer->title.(($offer->subtitle!='')? ' '.$offer->subtitle:'').$price;
            }
        }

        $data["facility"] = $data_facility;
        $data["offer"]    = $data_offer;

        return $data;
    }


    /**
     * Generate searchtext index from facility and offer tables.- Cron schedule
     *
     */
    public function generateSearchText()
    {
        $facilities  = Facility::get();
        if(count($facilities)>0) {
            foreach ($facilities as $facility) {
                $searchtext = ($facility->city != '') ? $facility->city . " " : '';
                $searchtext .= ($facility->postal != '') ? $facility->postal . " " : '';
                $searchtext .= ($facility->title != '') ? $facility->title . " " : '';
                $searchtext .= ($facility->content != '') ? strip_tags($facility->content) . " " : '';
                $searchtext .= ($facility->services != '') ? strip_tags($facility->services) . " " : '';
                $searchtext .= ($facility->terms != '') ? strip_tags($facility->terms) : '';

                $search_row = Search::where('parent_id', $facility->id)
                    ->where('relation', 'facility')
                    ->first();
                if (count($search_row) != 0) {
                    Search::destroy($search_row->id);

                    $search = new Search();
                    $search->project_id = $facility->project_id;
                    $search->parent_id = $facility->id;
                    $search->relation = 'facility';
                    $search->searchtext = $searchtext;
                    $search->save();
                } else {
                    $search = new Search();
                    $search->project_id = $facility->project_id;
                    $search->parent_id = $facility->id;
                    $search->relation = 'facility';
                    $search->searchtext = $searchtext;
                    $search->save();
                }
            }
        }
        $offers = Offer::get();
        if(count($offers)>0) {
            foreach ($offers as $offer) {
                $searchtext = $offer->title . " ";
                $searchtext .= ($offer->subtitle != '') ? $facility->subtitle . " " : '';
                $searchtext .= ($offer->description != '') ? strip_tags($offer->description) . " " : '';
                $searchtext .= ($offer->header != '') ? strip_tags($offer->header) . " " : '';
                $searchtext .= ($offer->footer != '') ? strip_tags($offer->footer) . " " : '';
                $searchtext .= ($offer->freetext1 != '') ? strip_tags($offer->freetext1) . " " : '';
                $searchtext .= ($offer->freetext2 != '') ? strip_tags($offer->freetext2) . " " : '';

                $parent_facility = Facility::find($offer->facility_id);
                $search_row = Search::where('parent_id', $offer->id)
                    ->where('relation', 'offer')
                    ->first();
                if (count($search_row) != 0) {
                    Search::destroy($search_row->id);

                    $search = new Search();
                    $search->project_id = $parent_facility->project_id;
                    $search->parent_id = $offer->id;
                    $search->relation = 'offer';
                    $search->searchtext = $searchtext;
                    $search->save();
                } else {
                    $search = new Search();
                    $search->project_id = $parent_facility->project_id;
                    $search->parent_id = $offer->id;
                    $search->relation = 'offer';
                    $search->searchtext = $searchtext;
                    $search->save();
                }
            }
        }
    }
}
