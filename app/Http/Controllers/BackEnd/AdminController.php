<?php

namespace App\Http\Controllers\BackEnd;

use App\Admin;
use App\AdminMonitoring;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'name', 'email', 'phone', 'address', 'role', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'name', 'email', 'phone', 'address', 'role', 'created_by', 'modified_by', 'action'];
        return $columns;
    }

    /**
     * Show Admin List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }

        $this->addMonitoring('Admin List');
        $params = [
            'nav'               => 'admin',
            'subNav'            => 'admin.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('admin.create'),
            'pageTitle'         => 'Admin List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.admin.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(){
        $this->addMonitoring('Create Admin');
        return view('backEnd.admin.create')->render();
    }

    /**
     * Store Admin Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'email'         => ['required','email', 'unique:admins'],
                'phone'         => ['nullable','numeric'],
                'name'          => ['required','string','min:2', 'max:100']
            ]);
            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                $this->addMonitoring('Create Admin','Add');
                $data = new Admin();
                $data->created_by = Auth::guard('admin')->user()->name;
            }else{
                $this->addMonitoring('Create Admin','Update');
                $data = Admin::withTrashed()->find($request->id);
                $data->modified_by = Auth::guard('admin')->user()->name;
            }
            $data->name = $request->name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->address = $request->address;
            $data->password = !empty($request->password) ? bcrypt($request->password) : $data->password;
            $data->remember_token = empty($data->remember_token) ? Str::random(60) : $data->remember_token;
            $data->image = $this->UploadImage($request, 'image', $this->proPic_dir, Null, 80, $data->image);
            $data->save();
            $this->success('Admin Information Add Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit Admin Info
     */
    public function edit(Request $request){
        $this->addMonitoring('Edit Admin');
        $data = Admin::withTrashed()->find($request->id);
        return view('backEnd.admin.create',['data' => $data])->render();
    }

    /**
     * Show Admin Profile 
     */
    public function showProfile(Request $request){
        $this->addMonitoring('View Admin Profile');
        $data = Admin::withTrashed()->find($request->id);
        return view('backEnd.admin.profile',['data' => $data])->render();
    }

    /**
     * Make the selected admin As Archive
     */
    public function archive(Request $request){
        try{
            $this->addMonitoring('Admin List','Make Archive', 'active', 'archive');
            $data = Admin::withTrashed()->find($request->id);
            $data->delete();
            $this->success('Make Archive Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected admin As Active from Archive
     */
    public function restore(Request $request){
        try{
            $this->addMonitoring('Admin Archive List', 'Make active', 'archive', 'active');
            $data = Admin::withTrashed()->find($request->id);
            $data->restore();
            $this->success('Admin Restore Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Admin List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        $this->addMonitoring('Admin Archive List');
        $params = [
            'nav'               => 'admin',
            'subNav'            => 'admin.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Admin Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.admin.table', $params);
    }

    /**
     * Get Admin DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = Admin::orderBy('name', 'ASC')->get();
        }else{
            $data = Admin::onlyTrashed()->orderBy('name', 'ASC')->get();
        }

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })            
            ->addcolumn('role', function($row){ return ucfirst(str_replace('_',' ', $row->user_type)); })
            ->addColumn('action', function($row) use($type){ 
                $li = '<a href="'.route('admin.profile',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                $li .= '<a href="'.route('admin.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    $li .= '<a href="'.route('admin.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }else{
                    $li .= '<a href="'.route('admin.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
                }
                return $li;
            })
            ->rawColumns(['action', ])
            ->make(true);
    }

    /**
     * Admin Monitoring
     */
    public function monitoringList(Request $request){
        if( $request->ajax() ){
            return $this->getMonitoringDataTable('archive');
        }
        $params = [
            'nav'               => 'admin',
            'subNav'            => 'admin.monitoring',
            'tableColumns'      => $this->getMonitoringColumns(),
            'dataTableColumns'  => $this->getMonitoringDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Admin Monitoring',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.admin.table', $params);
    }

    /**
     * Get Monitoring Table Column List
     */
    private function getMonitoringColumns(){
        $columns = ['#', 'name', 'visit_page', 'action', 'from_status', 'to_status', 'time'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getMonitoringDataTableColumns(){
        $columns = ['index', 'name', 'active_page', 'action', 'from_status', 'to_status', 'created_at'];
        return $columns;
    }

    /**
     * Get Admin Monitoring DataTable
     */
    public function getMonitoringDataTable(){
        $data = AdminMonitoring::orderBy('id', 'desc')->get();
        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; }) 
            ->addColumn('name', function($row){ return $row->admin->name; })
            ->editColumn('created_at', function($row){ return Carbon::parse($row->created_at)->diffForHumans(); } )
            ->make(true);
    }
    
}
