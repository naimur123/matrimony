<?php

namespace App\Http\Controllers\BackEnd;

use App\EducationLevel;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class EducationLevelController extends Controller
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
     * Show education_level List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }

        ////$this->addMonitoring('Education level List');
        $params = [
            'nav'               => 'education_level',
            'subNav'            => 'education_level.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('education_level.create'),
            'pageTitle'         => 'education_level List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.educationLevel.table', $params);
    }

    /**
     * Create New education_level
     */
    public function create(){
        //$this->addMonitoring('Create education_level');
        return view('backEnd.educationLevel.create')->render();
    }

    /**
     * Store Idmin Information
     */
    public function store(Request $request){
        try{
            if( $request->slug == "0" ){
                //$this->addMonitoring('Create education_level','Add');
                $data = new EducationLevel();
                $data->created_by = Auth::guard('admin')->user()->id;
            }else{
                //$this->addMonitoring('Create education_level','Update');
                $data = EducationLevel::withTrashed()->where('slug', $request->slug)->first();
                $data->modified_by = Auth::guard('admin')->user()->id;            
            }
            $data->slug = $this->getSlug($request->name, $data, boolval($request->slug) );
            $data->name = $request->name;
            $data->status = $request->status;
            // $data->image_path = $this->UploadImage($request, 'image_path', $this->images_dir, Null, 400, $data->image_path);
            // $data->image_64 = base64_encode( asset($data->image_path) );
            $data->save();
            $this->success('Education level Information Add Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit education_level Info
     */
    public function edit(Request $request){
        //$this->addMonitoring('Edit Education level');
        $data = EducationLevel::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.educationLevel.create',['data' => $data])->render();
    }

    /**
     * education_level Details view
     */
    public function view(Request $request){
        //$this->addMonitoring('View Education level');
        $data = EducationLevel::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.educationLevel.view',['data' => $data])->render();
    }

    /**
     * Make the selected education_level As Archive
     */
    public function archive(Request $request){
        try{
            //$this->addMonitoring('Education level List','Make Archive', 'active', 'archive');
            $data = EducationLevel::withTrashed()->where('slug', $request->slug)->first();
            $data->delete();
            $this->success('Make Archive Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected education_level As Active from Archive
     */
    public function restore(Request $request){
        try{
            //$this->addMonitoring('Education level Archive List', 'Make active', 'archive', 'active');
            $data = EducationLevel::withTrashed()->where('slug', $request->slug)->first();
            $data->restore();
            $this->success('Education level Restore Successfully');
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
            //$this->addMonitoring('Education level Archive List', 'Make active', 'archive', 'delete');
            $data = EducationLevel::withTrashed()->where('slug', $request->slug)->first();
            $this->RemoveFile($data->image_path);
            $data->forceDelete();
            $this->success('Permanently Delete Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Education level List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        //$this->addMonitoring('Education level Archive List');
        $params = [
            'nav'               => 'education_level',
            'subNav'            => 'education_level.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'education_level Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.educationLevel.table', $params);
    }

    /**
     * Get education_level DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = EducationLevel::orderBy('id', 'ASC')->get();
        }else{
            $data = EducationLevel::onlyTrashed()->orderBy('id', 'ASC')->get();
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
                // $li = '<a href="'.route('education_level.view',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                $li = '<a href="'.route('education_level.edit',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    $li .= '<a href="'.route('education_level.archive',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }else{
                    $li .= '<a href="'.route('education_level.restore',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-warning"  title="undo delete"> <i class="fas fa-redo"></i> </a> ';
                    // $li .= '<a href="'.route('education_level.delete',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" title="Permanent Delete" > <i class="fa fa-trash"></i> </a> ';
                }
                return $li;
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }
}
