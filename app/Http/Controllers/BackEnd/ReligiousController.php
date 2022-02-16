<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Religious;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReligiousController extends Controller
{
    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'name', 'short_name', 'status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'name', 'short_name', 'status', 'created_by', 'modified_by', 'action'];
        return $columns;
    }

    /**
     * Show religious List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }

        $this->addMonitoring('Religious List');
        $params = [
            'nav'               => 'religious',
            'subNav'            => 'religious.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('religious.create'),
            'pageTitle'         => 'religious List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.religious.table', $params);
    }

    /**
     * Create New religious
     */
    public function create(){
        $this->addMonitoring('Create religious');
        return view('backEnd.religious.create')->render();
    }

    /**
     * Store Idmin Information
     */
    public function store(Request $request){
        try{
            if( $request->slug == "0" ){
                $this->addMonitoring('Create religious','Add');
                $data = new Religious();
                $data->created_by = Auth::guard('admin')->user()->id;
            }else{
                $this->addMonitoring('Create religious','Update');
                $data = Religious::withTrashed()->where('slug', $request->slug)->first();
                $data->modified_by = Auth::guard('admin')->user()->id;            
            }
            $data->slug = $this->getSlug($request->name, $data, boolval($request->slug) );
            $data->name = $request->name;
            $data->short_name = $request->short_name;
            $data->status = $request->status;
            // $data->image_path = $this->UploadImage($request, 'image_path', $this->images_dir, Null, 400, $data->image_path);
            // $data->image_64 = base64_encode( asset($data->image_path) );
            $data->save();
            $this->success('Religious Information Add Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit religious Info
     */
    public function edit(Request $request){
        $this->addMonitoring('Edit Religious');
        $data = Religious::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.religious.create',['data' => $data])->render();
    }

    /**
     * religious Details view
     */
    public function view(Request $request){
        $this->addMonitoring('View Religious');
        $data = Religious::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.religious.view',['data' => $data])->render();
    }

    /**
     * Make the selected religious As Archive
     */
    public function archive(Request $request){
        try{
            $this->addMonitoring('Religious List','Make Archive', 'active', 'archive');
            $data = Religious::withTrashed()->where('slug', $request->slug)->first();
            $data->delete();
            $this->success('Make Archive Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected religious As Active from Archive
     */
    public function restore(Request $request){
        try{
            $this->addMonitoring('Religious Archive List', 'Make active', 'archive', 'active');
            $data = Religious::withTrashed()->where('slug', $request->slug)->first();
            $data->restore();
            $this->success('Religious Restore Successfully');
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
            $this->addMonitoring('Religious Archive List', 'Make active', 'archive', 'delete');
            $data = Religious::withTrashed()->where('slug', $request->slug)->first();
            $this->RemoveFile($data->image_path);
            $data->forceDelete();
            $this->success('Permanently Delete Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Religious List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        $this->addMonitoring('Religious Archive List');
        $params = [
            'nav'               => 'religious',
            'subNav'            => 'religious.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'religious Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.religious.table', $params);
    }

    /**
     * Get religious DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = Religious::orderBy('id', 'ASC')->get();
        }else{
            $data = Religious::onlyTrashed()->orderBy('id', 'ASC')->get();
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
                // $li = '<a href="'.route('religious.view',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                $li = '<a href="'.route('religious.edit',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    $li .= '<a href="'.route('religious.archive',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }else{
                    $li .= '<a href="'.route('religious.restore',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-warning"  title="undo delete"> <i class="fas fa-redo"></i> </a> ';
                    // $li .= '<a href="'.route('religious.delete',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" title="Permanent Delete" > <i class="fa fa-trash"></i> </a> ';
                }
                return $li;
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }
}
