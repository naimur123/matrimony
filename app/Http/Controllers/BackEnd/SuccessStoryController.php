<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\SuccessStory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SuccessStoryController extends Controller
{
    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'title', 'image', 'status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'title', 'image_path', 'status', 'created_by', 'modified_by', 'action'];
        return $columns;
    }

    /**
     * Show successStory List  without Archive
     */
    public function index(Request $request){
        if( $request->ajax() ){
            return $this->getDataTable();
        }

        //$this->addMonitoring('Success Story List');
        $params = [
            'nav'               => 'successStory',
            'subNav'            => 'successStory.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('successStory.create'),
            'pageTitle'         => 'Success Story List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.successStory.table', $params);
    }

    /**
     * Create New successStory
     */
    public function create(){
        //$this->addMonitoring('Create successStory');
        return view('backEnd.successStory.create')->render();
    }

    /**
     * Store Information
     */
    public function store(Request $request){
        try{
            if( $request->slug == "0" ){
                //$this->addMonitoring('Create successStory','Add');
                $data = new SuccessStory();
                $data->created_by = Auth::guard('admin')->user()->id;
            }else{
                //$this->addMonitoring('Create successStory','Update');
                $data = SuccessStory::withTrashed()->where('slug', $request->slug)->first();
                $data->modified_by = Auth::guard('admin')->user()->id;
            }
            $data->slug = $this->getSlug($request->title, $data, boolval($request->slug) );
            $data->title = $request->title;
            $data->meta_tag = $request->meta_tag;
            $data->meta_description = $request->meta_description;
            $data->description = $request->description;
            $data->status = $request->status;
            $data->image_path = $this->UploadImage($request, 'image_path', $this->images_dir, Null, 400, $data->image_path);
            // $data->image_64 = base64_encode( asset($data->image_path) );
            $data->save();
            $this->success('Success Story Information Add Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit successStory Info
     */
    public function edit(Request $request){
        //$this->addMonitoring('Edit Success Story');
        $data = SuccessStory::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.successStory.create',['data' => $data])->render();
    }

    /**
     * successStory Details view
     */
    public function view(Request $request){
        //$this->addMonitoring('View news');
        $data = SuccessStory::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.successStory.view',['data' => $data])->render();
    }


    /**
     * Make the selected successStory As Archive
     */
    public function archive(Request $request){
        try{
            //$this->addMonitoring('successStory List','Make Archive', 'active', 'archive');
            $data = SuccessStory::withTrashed()->where('slug', $request->slug)->first();
            $data->delete();
            $this->success('Make Archive Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected successStory As Active from Archive
     */
    public function restore(Request $request){
        try{
            //$this->addMonitoring('successStory Archive List', 'Make active', 'archive', 'active');
            $data = SuccessStory::withTrashed()->where('slug', $request->slug)->first();
            $data->restore();
            $this->success('successStory Restore Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Permanently delete
     */
    public function delete(Request $request){
        try{
            //$this->addMonitoring('successStory Archive List', 'Make active', 'archive', 'delete');
            $data = SuccessStory::withTrashed()->where('slug', $request->slug)->first();
            $this->RemoveFile($data->image_path);
            $data->forceDelete();
            $this->success('Permanently Delete Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive successStory List
     */
    public function archiveList(Request $request){

        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }

        //$this->addMonitoring('successStory Archive List');
        $params = [
            'nav'               => 'successStory',
            'subNav'            => 'successStory.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'successStory Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.successStory.table', $params);
    }

    /**
     * Get successStory DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = SuccessStory::orderBy('id', 'ASC')->get();
        }else{
            $data = SuccessStory::onlyTrashed()->orderBy('id', 'ASC')->get();
        }

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->editColumn('created_by', function($row){ return $row->createdBy->name; })
            ->editColumn('modified_by', function($row){ return empty($row->modifiedBy) ? 'N/A' : $row->modifiedBy->name; })
            ->editcolumn('image_path', function($row){ return '<img src="'.asset($row->image_path).'" height="60">'; })
            ->addColumn('status', function($row){
                return $row->status == 'published' ? '<span class="badge badge-success">'.$row->status.'</span>' : '<span class="badge badge-warning">'.$row->status.'</span>';
            })
            ->addColumn('action', function($row) use($type){
                $li = '<a href="'.route('successStory.view',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                $li .= '<a href="'.route('successStory.edit',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    $li .= '<a href="'.route('successStory.archive',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }else{
                    $li .= '<a href="'.route('successStory.restore',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-warning"  title="undo delete"> <i class="fas fa-redo"></i> </a> ';
                    $li .= '<a href="'.route('successStory.delete',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" title="Permanent Delete" > <i class="fa fa-trash"></i> </a> ';
                }
                return $li;
            })
            ->rawColumns(['action', 'link','image_path','status'])
            ->make(true);
    }
}
