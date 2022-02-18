<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\MaritalStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MaritalStatusController extends Controller
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

        //$this->addMonitoring('Marital Status List');
        $params = [
            'nav'               => 'marital_status',
            'subNav'            => 'marital_status.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('marital_status.create'),
            'pageTitle'         => 'marital_status List',
            'modalSizeClass'    => 'modal-md',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New life_style
     */
    public function create(){
        //$this->addMonitoring('Create Marital Status');
        return view('backEnd.maritalStatus.create')->render();
    }

    /**
     * Store Idmin Information
     */
    public function store(Request $request){
        try{
            if( $request->slug == "0" ){
                //$this->addMonitoring('Create life_style','Add');
                $data = new MaritalStatus();
                $data->created_by = Auth::guard('admin')->user()->id;
            }else{
                //$this->addMonitoring('Create life_style','Update');
                $data = MaritalStatus::withTrashed()->where('slug', $request->slug)->first();
                $data->modified_by = Auth::guard('admin')->user()->id;
            }
            $data->slug = $this->getSlug($request->name, $data, boolval($request->slug) );
            $data->name = $request->name;
            $data->status = $request->status;
            $data->save();
            $this->success('Marital Status Information Add Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit life_style Info
     */
    public function edit(Request $request){
        //$this->addMonitoring('Edit Marital Status');
        $data = MaritalStatus::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.maritalStatus.create',['data' => $data])->render();
    }

    /**
     * life_style Details view
     */
    public function view(Request $request){
        //$this->addMonitoring('View Marital Status');
        $data = MaritalStatus::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.maritalStatus.view',['data' => $data])->render();
    }

    /**
     * Make the selected life_style As Archive
     */
    public function archive(Request $request){
        try{
            //$this->addMonitoring('Marital Status List','Make Archive', 'active', 'archive');
            $data = MaritalStatus::withTrashed()->where('slug', $request->slug)->first();
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
            //$this->addMonitoring('Marital Status Archive List', 'Make active', 'archive', 'active');
            $data = MaritalStatus::withTrashed()->where('slug', $request->slug)->first();
            $data->restore();
            $this->success('Marital Status Restore Successfully');
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
            //$this->addMonitoring('Marital Status Archive List', 'Make active', 'archive', 'delete');
            $data = MaritalStatus::withTrashed()->where('slug', $request->slug)->first();
            $this->RemoveFile($data->image_path);
            $data->forceDelete();
            $this->success('Permanently Delete Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Marital Status List
     */
    public function archiveList(Request $request){

        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }

        //$this->addMonitoring('Marital Status Archive List');
        $params = [
            'nav'               => 'life_style',
            'subNav'            => 'life_style.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'life_style Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Get life_style DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = MaritalStatus::orderBy('id', 'ASC')->get();
        }else{
            $data = MaritalStatus::onlyTrashed()->orderBy('id', 'ASC')->get();
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
                // $li = '<a href="'.route('marital_status.view',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                $li = '<a href="'.route('marital_status.edit',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                // if($type == 'list'){
                //     $li .= '<a href="'.route('marital_status.archive',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                // }else{
                //     $li .= '<a href="'.route('marital_status.restore',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-warning"  title="undo delete"> <i class="fas fa-redo"></i> </a> '
                // }
                return $li;
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }
}
