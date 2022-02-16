<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\OurService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OurServiceController extends Controller
{
    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'title', 'status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'title', 'status', 'created_by', 'modified_by', 'action'];
        return $columns;
    }

    /**
     * Show Our Service List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }

        $this->addMonitoring('Our Service List');
        $params = [
            'nav'               => 'ourservice',
            'subNav'            => 'ourservice.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('ourservice.create'),
            'pageTitle'         => 'Our Service List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.ourservice.table', $params);
    }

    /**
     * Create New Our Service
     */
    public function create(){
        $this->addMonitoring('Create Our Service');
        return view('backEnd.ourservice.create')->render();
    }

    /**
     * Store Idmin Information
     */
    public function store(Request $request){
        try{
            if( $request->slug == "0" ){
                $this->addMonitoring('Create Our Service','Add');
                $data = new OurService();
                $data->created_by = Auth::guard('admin')->user()->id;
            }else{
                $this->addMonitoring('Create Our Service','Update');
                $data = OurService::withTrashed()->where('slug', $request->slug)->first();
                $data->modified_by = Auth::guard('admin')->user()->id;            
            }
            $data->slug = $this->getSlug($request->title, $data, boolval($request->slug) );
            $data->title = $request->title;
            $data->meta_tag = $request->meta_tag;
            $data->meta_description = $request->meta_description;
            $data->description = $request->description;
            $data->status = $request->status;
            // $data->image_path = $this->UploadImage($request, 'image_path', $this->images_dir, Null, 400, $data->image_path);
            // $data->image_64 = base64_encode( asset($data->image_path) );
            $data->save();
            $this->success('Our Service Information Add Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit Our Service Info
     */
    public function edit(Request $request){
        $this->addMonitoring('Edit Our Service');
        $data = OurService::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.ourservice.create',['data' => $data])->render();
    }

    /**
     * Our Service Details view
     */
    public function view(Request $request){
        $this->addMonitoring('View Our Service');
        $data = OurService::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.ourservice.view',['data' => $data])->render();
    }

    /**
     * Make the selected Our Service As Archive
     */
    public function archive(Request $request){
        try{
            $this->addMonitoring('Our Service List','Make Archive', 'active', 'archive');
            $data = OurService::withTrashed()->where('slug', $request->slug)->first();
            $data->delete();
            $this->success('Make Archive Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected Our Service As Active from Archive
     */
    public function restore(Request $request){
        try{
            $this->addMonitoring('Our Service Archive List', 'Make active', 'archive', 'active');
            $data = OurService::withTrashed()->where('slug', $request->slug)->first();
            $data->restore();
            $this->success('Our Service Restore Successfully');
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
            $this->addMonitoring('Our Service Archive List', 'Make active', 'archive', 'delete');
            $data = OurService::withTrashed()->where('slug', $request->slug)->first();
            // $this->RemoveFile($data->image_path);
            $data->forceDelete();
            $this->success('Permanently Delete Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Our Service List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        $this->addMonitoring('Our Service Archive List');
        $params = [
            'nav'               => 'ourservice',
            'subNav'            => 'ourservice.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Our Service Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.ourservice.table', $params);
    }

    /**
     * Get Our Service DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = OurService::orderBy('id', 'ASC')->get();
        }else{
            $data = OurService::onlyTrashed()->orderBy('id', 'ASC')->get();
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
                $li = '<a href="'.route('ourservice.view',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                $li .= '<a href="'.route('ourservice.edit',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    $li .= '<a href="'.route('ourservice.archive',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }else{
                    $li .= '<a href="'.route('ourservice.restore',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-warning"  title="undo delete"> <i class="fas fa-redo"></i> </a> ';
                    $li .= '<a href="'.route('ourservice.delete',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" title="Permanent Delete" > <i class="fa fa-trash"></i> </a> ';
                }
                return $li;
            })
            ->rawColumns(['action', 'link','image_path','status'])
            ->make(true);
    }
}
