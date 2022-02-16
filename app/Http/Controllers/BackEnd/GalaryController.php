<?php

namespace App\Http\Controllers\BackEnd;

use App\Galary;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class GalaryController extends Controller
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
     * Show Galary List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }

        $this->addMonitoring('Galary List');
        $params = [
            'nav'               => 'galary',
            'subNav'            => 'galary.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('galary.create'),
            'pageTitle'         => 'Galary List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.galary.table', $params);
    }

    /**
     * Create New Galary
     */
    public function create(){
        $this->addMonitoring('Create Galary');
        return view('backEnd.galary.create')->render();
    }

    /**
     * Store Idmin Information
     */
    public function store(Request $request){
        try{
            if( $request->slug == "0" ){
                $this->addMonitoring('Create Galary','Add');
                $data = new Galary();
                $data->created_by = Auth::guard('admin')->user()->id;
            }else{
                $this->addMonitoring('Create Galary','Update');
                $data = Galary::withTrashed()->where('slug', $request->slug)->first();
                $data->modified_by = Auth::guard('admin')->user()->id;                
            }
            $data->slug = $this->getSlug($request->title, $data, boolval($request->slug) );
            $data->title = $request->title;
            $data->status = $request->status;
            $data->image_path = $this->UploadImage($request, 'image_path', $this->galary_dir, Null, 400, $data->image_path);
            // $data->image_64 = base64_encode( asset($data->image_path) );
            $data->save();
            $this->success('Galary Information Add Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit Galary Info
     */
    public function edit(Request $request){
        $this->addMonitoring('Edit Galary');
        $data = Galary::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.galary.create',['data' => $data])->render();
    }


    /**
     * Make the selected Galary As Archive
     */
    public function archive(Request $request){
        try{
            $this->addMonitoring('Galary List','Make Archive', 'active', 'archive');
            $data = Galary::withTrashed()->where('slug', $request->slug)->first();
            $data->delete();
            $this->success('Make Archive Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected Galary As Active from Archive
     */
    public function restore(Request $request){
        try{
            $this->addMonitoring('Galary Archive List', 'Make active', 'archive', 'active');
            $data = Galary::withTrashed()->where('slug', $request->slug)->first();
            $data->restore();
            $this->success('Galary Restore Successfully');
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
            $this->addMonitoring('Galary Archive List', 'Make active', 'archive', 'delete');
            $data = Galary::withTrashed()->where('slug', $request->slug)->first();
            $this->RemoveFile($data->image_path);
            $data->forceDelete();
            $this->success('Permanently Delete Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Galary List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        $this->addMonitoring('Galary Archive List');
        $params = [
            'nav'               => 'galary',
            'subNav'            => 'galary.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Galary Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.Galary.table', $params);
    }

    /**
     * Get Galary DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = Galary::orderBy('id', 'ASC')->get();
        }else{
            $data = Galary::onlyTrashed()->orderBy('id', 'ASC')->get();
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
                // $li = '<a href="'.route('Galary.profile',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                $li = '<a href="'.route('galary.edit',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    $li .= '<a href="'.route('galary.archive',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }else{
                    $li .= '<a href="'.route('galary.restore',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-warning"  title="undo delete"> <i class="fas fa-redo"></i> </a> ';
                    $li .= '<a href="'.route('galary.delete',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" title="Permanent Delete" > <i class="fa fa-trash"></i> </a> ';
                }
                return $li;
            })
            ->rawColumns(['action', 'link','image_path','status'])
            ->make(true);
    }
}
