<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\LifeStyle;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class LifeStyleController extends Controller
{
    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'name', 'status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'name', 'status', 'created_by', 'modified_by', 'action'];
        return $columns;
    }

    /**
     * Show life_style List  without Archive
     */
    public function index(Request $request){
        if( $request->ajax() ){
            return $this->getDataTable();
        }

        //$this->addMonitoring('Life Style List');
        $params = [
            'nav'               => 'life_style',
            'subNav'            => 'life_style.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('life_style.create'),
            'pageTitle'         => 'life_style List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.lifeStyle.table', $params);
    }

    /**
     * Create New life_style
     */
    public function create(){
        //$this->addMonitoring('Create life_style');
        return view('backEnd.lifeStyle.create')->render();
    }

    /**
     * Store Idmin Information
     */
    public function store(Request $request){
        try{
            if( $request->slug == "0" ){
                //$this->addMonitoring('Create life_style','Add');
                $data = new LifeStyle();
                $data->created_by = Auth::guard('admin')->user()->id;
            }else{
                //$this->addMonitoring('Create life_style','Update');
                $data = LifeStyle::withTrashed()->where('slug', $request->slug)->first();
                $data->modified_by = Auth::guard('admin')->user()->id;
            }
            $data->slug = $this->getSlug($request->name, $data, boolval($request->slug) );
            $data->name = $request->name;
            $data->status = $request->status;
            // $data->image_path = $this->UploadImage($request, 'image_path', $this->images_dir, Null, 400, $data->image_path);
            // $data->image_64 = base64_encode( asset($data->image_path) );
            $data->save();
            $this->success('Life Style Information Add Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit life_style Info
     */
    public function edit(Request $request){
        //$this->addMonitoring('Edit Life Style');
        $data = LifeStyle::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.lifeStyle.create',['data' => $data])->render();
    }

    /**
     * life_style Details view
     */
    public function view(Request $request){
        //$this->addMonitoring('View Life Style');
        $data = LifeStyle::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.lifeStyle.view',['data' => $data])->render();
    }

    /**
     * Make the selected life_style As Archive
     */
    public function archive(Request $request){
        try{
            //$this->addMonitoring('Life Style List','Make Archive', 'active', 'archive');
            $data = LifeStyle::withTrashed()->where('slug', $request->slug)->first();
            $data->delete();
            $this->success('Make Archive Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected life_style As Active from Archive
     */
    public function restore(Request $request){
        try{
            //$this->addMonitoring('Life Style Archive List', 'Make active', 'archive', 'active');
            $data = LifeStyle::withTrashed()->where('slug', $request->slug)->first();
            $data->restore();
            $this->success('Life Style Restore Successfully');
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
            //$this->addMonitoring('Life Style Archive List', 'Make active', 'archive', 'delete');
            $data = LifeStyle::withTrashed()->where('slug', $request->slug)->first();
            $this->RemoveFile($data->image_path);
            $data->forceDelete();
            $this->success('Permanently Delete Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Life Style List
     */
    public function archiveList(Request $request){

        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }

        //$this->addMonitoring('Life Style Archive List');
        $params = [
            'nav'               => 'life_style',
            'subNav'            => 'life_style.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'life_style Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.lifeStyle.table', $params);
    }

    /**
     * Get life_style DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = LifeStyle::orderBy('id', 'ASC')->get();
        }else{
            $data = LifeStyle::onlyTrashed()->orderBy('id', 'ASC')->get();
        }

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->editColumn('created_by', function($row){ return $row->createdBy->name; })
            ->editColumn('modified_by', function($row){ return empty($row->modifiedBy) ? 'N/A' : $row->modifiedBy->name; })
            // ->editcolumn('image_path', function($row){ return '<img src="'.asset($row->image_path).'" height="60">'; })
            ->addColumn('status', function($row){
                return $row->status == 'published' ? '<span class="badge badge-success">'.$row->status.'</span>' : '<span class="badge badge-warning">'.$row->status.'</span>';
            })
            ->addColumn('action', function($row) use($type){
                // $li = '<a href="'.route('life_style.view',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                $li = '<a href="'.route('life_style.edit',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    $li .= '<a href="'.route('life_style.archive',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }else{
                    $li .= '<a href="'.route('life_style.restore',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-warning"  title="undo delete"> <i class="fas fa-redo"></i> </a> ';
                    // $li .= '<a href="'.route('life_style.delete',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" title="Permanent Delete" > <i class="fa fa-trash"></i> </a> ';
                }
                return $li;
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }
}
