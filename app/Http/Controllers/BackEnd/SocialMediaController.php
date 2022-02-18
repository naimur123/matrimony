<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SocialMedia;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SocialMediaController extends Controller
{
    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'icon', 'position', 'status', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index','icon','position', 'publication_status', 'action'];
        return $columns;
    }

    /**
     * Show religious List  without Archive
     */
    public function index(Request $request){
        if( $request->ajax() ){
            return $this->getDataTable();
        }

        $params = [
            'nav'               => 'social_media',
            'subNav'            => Null,
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('social_media.create'),
            'pageTitle'         => 'Social Media list',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.religious.table', $params);
    }

    /**
     * Create or Add Social Media
     */
    public function create(){
        return view('backEnd.socialMedia.createSocialIcon')->render();
    }

    //Save Or Update Social Media info
    public function store(Request $request) {

        if($request->id == 0){
            $validate = Validator::make($request->all(),[
                'icon' => 'required|unique:social_media'
            ]);
            if($validate->fails()){
                $this->message = $this->getValidationError($validate);
                return $this->output();
            }
            $icon = new SocialMedia();
        }else{
            $icon = SocialMedia::find($request->id);
        }
        try{
            DB::beginTransaction();
            $icon->icon = $request->icon;
            $icon->link = $request->link;
            $icon->position = $request->position;
            $icon->publication_status = $request->publication_status;
            $icon->save();
            DB::commit();
            $this->success('Information Add Successfully');
        } catch (Exception $e) {
            DB::rollback();
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    //Edit Social Media info
    public function edit($id) {
        $data = SocialMedia::find($id);
        return view('backEnd.socialMedia.createSocialIcon', ['data' => $data ])->render();
    }

    //Delete Social Media Icon
    public function delete($id) {
        try{
            $icon = SocialMedia::find($id);
            $icon->delete();
            $this->success('Icon Delete Successfully');
            return response()->json($this->output());
        }catch(Exception $e){
            $this->message = $this->getError($e);
            return response()->json($this->output());
        }

    }

    /**
     * Get religious DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        $datas = SocialMedia::orderBy('position','ASC')->get();
            return DataTables::of($datas)
            ->addColumn('index',function(){
                return ++$this->index;
            })
            ->editColumn('publication_status', function($row){
                return $row->publication_status == 1 ?'<span class="badge badge-success">Published</span>' : '<span class="badge badge-danger">Unpublished</span>';
            })
            ->editColumn('icon', function($row){
                return '<span class="'.$row->icon.' fa-2x"></span>';
            })
            ->addColumn('action', function($row){
                $li = '<a href="'. url('social-media/'.$row->id.'/edit') .'" class="btn btn-info btn-sm ajax-click-page" ><span class="fa fa-edit"></span> Edit </a>';
                $li .= '<a href="'.url('social-media/'.$row->id.'/delete').'" class="btn btn-danger btn-sm ajax-click" ><span class="fa fa-trash"></span> Delete</a>';
                return $li;
            })
            ->rawColumns(['action', 'icon', 'publication_status'])
            ->make(true);
    }
}
