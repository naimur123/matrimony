<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Package;
use App\SystemInfo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PackageController extends Controller
{
    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'image', 'title', 'duration', 'regular_fee', 'current_fee', 'status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'image_path', 'title', 'duration', 'regular_fee', 'current_fee', 'status', 'created_by', 'modified_by', 'action'];
        return $columns;
    }

    /**
     * Show package List  without Archive
     */
    public function index(Request $request){
        if( $request->ajax() ){
            return $this->getDataTable();
        }

        //$this->addMonitoring('package List');
        $params = [
            'nav'               => 'package',
            'subNav'            => 'package.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('package.create'),
            'pageTitle'         => 'package List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.package.table', $params);
    }

    /**
     * Create New package
     */
    public function create(){
        //$this->addMonitoring('Create package');
        return view('backEnd.package.create')->render();
    }

    /**
     * Store Idmin Information
     */
    public function store(Request $request){
        try{
            if( $request->slug == "0" ){
                //$this->addMonitoring('Create package','Add');
                $data = new package();
                $data->created_by = Auth::guard('admin')->user()->id;
            }else{
                //$this->addMonitoring('Create package','Update');
                $data = Package::withTrashed()->where('slug', $request->slug)->first();
                $data->modified_by = Auth::guard('admin')->user()->id;
            }
            $data->slug = $this->getSlug($request->title, $data, boolval($request->slug) );
            $data->title = $request->title;
            $data->duration = $request->duration;
            $data->duration_type = $request->duration_type;
            $data->profile_view = $request->profile_view;
            $data->contact_details = $request->contact_details;
            $data->total_proposal = $request->total_proposal;
            $data->daily_proposal = $request->daily_proposal;
            // $data->total_send_message = $request->total_send_message;
            // $data->daily_send_message = $request->daily_send_message;
            $data->block_profile = $request->block_profile;
            $data->accept_proposal = $request->accept_proposal;
            // $data->decline_proposal = $request->decline_proposal;
            $data->post_photo = $request->post_photo;
            $data->regular_fee = $request->regular_fee;
            $data->discount_percentage = $request->discount_percentage;
            $data->current_fee = $request->current_fee;

            $data->description = $request->description;
            $data->status = $request->status;
            $data->image_path = $this->UploadImage($request, 'image_path', $this->images_dir, Null, 400, $data->image_path);
            $data->save();
            $this->success('package Information Add Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit package Info
     */
    public function edit(Request $request){
        //$this->addMonitoring('Edit package');
        $data = Package::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.package.create',['data' => $data])->render();
    }

    /**
     * package Details view
     */
    public function view(Request $request){
        //$this->addMonitoring('View package');
        $data = Package::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.package.view',['data' => $data])->render();
    }

    /**
     * Make the selected package As Archive
     */
    public function archive(Request $request){
        try{
            //$this->addMonitoring('package List','Make Archive', 'active', 'archive');
            $data = Package::withTrashed()->where('slug', $request->slug)->first();
            $data->delete();
            $this->success('Make Archive Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected package As Active from Archive
     */
    public function restore(Request $request){
        try{
            //$this->addMonitoring('package Archive List', 'Make active', 'archive', 'active');
            $data = Package::withTrashed()->where('slug', $request->slug)->first();
            $data->restore();
            $this->success('package Restore Successfully');
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
            //$this->addMonitoring('package Archive List', 'Make active', 'archive', 'delete');
            $data = Package::withTrashed()->where('slug', $request->slug)->first();
            $this->RemoveFile($data->image_path);
            $data->forceDelete();
            $this->success('Permanently Delete Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive package List
     */
    public function archiveList(Request $request){

        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }

        //$this->addMonitoring('package Archive List');
        $params = [
            'nav'               => 'package',
            'subNav'            => 'package.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'package Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.package.table', $params);
    }

    /**
     * Get package DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = Package::orderBy('id', 'ASC')->get();
        }else{
            $data = Package::onlyTrashed()->orderBy('id', 'ASC')->get();
        }
        $system = SystemInfo::first();

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->editColumn('created_by', function($row){ return $row->createdBy->name; })
            ->editColumn('modified_by', function($row){ return empty($row->modifiedBy) ? 'N/A' : $row->modifiedBy->name; })
            ->editColumn('duration', function($row){ return $row->duration .' '. ucfirst($row->duration_type); })
            ->editColumn('current_fee', function($row) use ($system){ return $row->current_fee .' '.$system->currency; })
            ->editColumn('regular_fee', function($row) use ($system){ return $row->regular_fee .' '.$system->currency; })
            ->editcolumn('image_path', function($row){ return '<img src="'.asset($row->image_path).'" height="60" alt="N/A">'; })
            ->addColumn('status', function($row){
                return $row->status == 'published' ? '<span class="badge badge-success">'.$row->status.'</span>' : '<span class="badge badge-warning">'.$row->status.'</span>';
            })
            ->addColumn('action', function($row) use($type){
                $li = '<a href="'.route('package.view',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                $li .= '<a href="'.route('package.edit',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    $li .= '<a href="'.route('package.archive',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }else{
                    $li .= '<a href="'.route('package.restore',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-warning"  title="undo delete"> <i class="fas fa-redo"></i> </a> ';
                    $li .= '<a href="'.route('package.delete',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" title="Permanent Delete" > <i class="fa fa-trash"></i> </a> ';
                }
                return $li;
            })
            ->rawColumns(['action', 'link','image_path','status'])
            ->make(true);
    }
}
