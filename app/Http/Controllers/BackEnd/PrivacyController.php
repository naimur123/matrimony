<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\PrivacyPolicy;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PrivacyController extends Controller
{
    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'title', 'description', 'status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'title', 'description', 'status', 'created_by', 'modified_by', 'action'];
        return $columns;
    }

    /**
     * Show privacy List  without Archive
     */
    public function index(Request $request){
        if( $request->ajax() ){
            return $this->getDataTable();
        }

        //$this->addMonitoring('privacy List');
        $params = [
            'nav'               => 'privacy',
            'subNav'            => 'privacy.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('privacy.create'),
            'pageTitle'         => 'privacy List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.privacy.table', $params);
    }

    /**
     * Create New privacy
     */
    public function create(){
        //$this->addMonitoring('Create privacy');
        return view('backEnd.privacy.create')->render();
    }

    /**
     * Store Idmin Information
     */
    public function store(Request $request){
        try{
            if( $request->slug == "0" ){
                //$this->addMonitoring('Create privacy','Add');
                $data = new PrivacyPolicy();
                $data->created_by = Auth::guard('admin')->user()->id;
            }else{
                //$this->addMonitoring('Create privacy','Update');
                $data = PrivacyPolicy::withTrashed()->where('slug', $request->slug)->first();
                $data->modified_by = Auth::guard('admin')->user()->id;
            }
            $data->slug = $this->getSlug($request->title, $data, boolval($request->slug) );
            $data->title = $request->title;
            $data->description = $request->description;
            $data->status = $request->status;
            // $data->image_path = $this->UploadImage($request, 'image_path', $this->images_dir, Null, 400, $data->image_path);
            // $data->image_64 = base64_encode( asset($data->image_path) );
            $data->save();
            $this->success('privacy Information Add Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit privacy Info
     */
    public function edit(Request $request){
        //$this->addMonitoring('Edit privacy');
        $data = PrivacyPolicy::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.privacy.create',['data' => $data])->render();
    }

    /**
     * privacy Details view
     */
    public function view(Request $request){
        //$this->addMonitoring('View privacy');
        $data = PrivacyPolicy::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.privacy.view',['data' => $data])->render();
    }

    /**
     * Make the selected privacy As Archive
     */
    public function archive(Request $request){
        try{
            //$this->addMonitoring('privacy List','Make Archive', 'active', 'archive');
            $data = PrivacyPolicy::withTrashed()->where('slug', $request->slug)->first();
            $data->delete();
            $this->success('Make Archive Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected privacy As Active from Archive
     */
    public function restore(Request $request){
        try{
            //$this->addMonitoring('privacy Archive List', 'Make active', 'archive', 'active');
            $data = PrivacyPolicy::withTrashed()->where('slug', $request->slug)->first();
            $data->restore();
            $this->success('privacy Restore Successfully');
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
            //$this->addMonitoring('privacy Archive List', 'Make active', 'archive', 'delete');
            $data = PrivacyPolicy::withTrashed()->where('slug', $request->slug)->first();
            $this->RemoveFile($data->image_path);
            $data->forceDelete();
            $this->success('Permanently Delete Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive privacy List
     */
    public function archiveList(Request $request){

        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }

        //$this->addMonitoring('privacy Archive List');
        $params = [
            'nav'               => 'privacy',
            'subNav'            => 'privacy.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'privacy Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.privacy.table', $params);
    }

    /**
     * Get privacy DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = PrivacyPolicy::orderBy('id', 'ASC')->get();
        }else{
            $data = PrivacyPolicy::onlyTrashed()->orderBy('id', 'ASC')->get();
        }

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->editColumn('created_by', function($row){ return $row->createdBy->name; })
            ->editColumn('description', function($row){ return substr($row->description, 0 ,50 ) . ' ...'; })
            ->editColumn('modified_by', function($row){ return empty($row->modifiedBy) ? 'N/A' : $row->modifiedBy->name; })
            ->addColumn('status', function($row){
                return $row->status == 'published' ? '<span class="badge badge-success">'.$row->status.'</span>' : '<span class="badge badge-warning">'.$row->status.'</span>';
            })
            ->addColumn('action', function($row) use($type){
                $li = '<a href="'.route('privacy.view',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                $li .= '<a href="'.route('privacy.edit',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    $li .= '<a href="'.route('privacy.archive',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }else{
                    $li .= '<a href="'.route('privacy.restore',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-warning"  title="undo delete"> <i class="fas fa-redo"></i> </a> ';
                    $li .= '<a href="'.route('privacy.delete',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" title="Permanent Delete" > <i class="fa fa-trash"></i> </a> ';
                }
                return $li;
            })
            ->rawColumns(['action', 'link','image_path','status'])
            ->make(true);
    }
}
