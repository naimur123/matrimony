<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Religious;
use App\ReligiousCast;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReligiousCastController extends Controller
{
    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#','cast', 'religion', 'status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'name', 'religion', 'status', 'created_by', 'modified_by', 'action'];
        return $columns;
    }

    /**
     * Show religious List  without Archive
     */
    public function index(Request $request){
        if( $request->ajax() ){
            return $this->getDataTable();
        }

        //$this->addMonitoring('Religious Cast List');
        $params = [
            'nav'               => 'religious',
            'subNav'            => 'religious.cast.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('religious.cast.create'),
            'pageTitle'         => 'religious Cast List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.religious.table', $params);
    }

    /**
     * Create New religious
     */
    public function create(){
        //$this->addMonitoring('Create Religious cast');
        $prams['religions'] = Religious::where('status','published')->orderBy('name', 'ASC')->get();
        return view('backEnd.religious.cast.create', $prams)->render();
    }

    /**
     * Store Idmin Information
     */
    public function store(Request $request){
        try{
            if( $request->slug == "0" ){
                //$this->addMonitoring('Create religious cast','Add');
                $data = new ReligiousCast();
                $data->created_by = Auth::guard('admin')->user()->id;
            }else{
                //$this->addMonitoring('Create religious cast','Update');
                $data = ReligiousCast::withTrashed()->where('slug', $request->slug)->first();
                $data->modified_by = Auth::guard('admin')->user()->id;
            }
            $data->slug = $this->getSlug($request->name, $data, boolval($request->slug) );
            $data->religious_id = $request->religious_id;
            $data->name = $request->name;
            $data->status = $request->status;
            $data->save();
            $this->success('Religious Cast Information Add Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit religious Info
     */
    public function edit(Request $request){
        //$this->addMonitoring('Edit Religious cast');
        $prams['religions'] = Religious::where('status','published')->orderBy('name', 'ASC')->get();
        $prams['data'] = ReligiousCast::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.religious.cast.create', $prams)->render();
    }

    /**
     * religious Details view
     */
    public function view(Request $request){
        //$this->addMonitoring('View Religious Cast');
        $data = ReligiousCast::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.religious.view',['data' => $data])->render();
    }

    /**
     * Make the selected religious As Archive
     */
    public function archive(Request $request){
        try{
            //$this->addMonitoring('Religious Cast List','Make Archive', 'active', 'archive');
            $data = ReligiousCast::withTrashed()->where('slug', $request->slug)->first();
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
            //$this->addMonitoring('Religious Cast Archive List', 'Make active', 'archive', 'active');
            $data = ReligiousCast::withTrashed()->where('slug', $request->slug)->first();
            $data->restore();
            $this->success('Religious Cast Restore Successfully');
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
            //$this->addMonitoring('Religious Cast Archive List', 'Make active', 'archive', 'delete');
            $data = ReligiousCast::withTrashed()->where('slug', $request->slug)->first();
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

        //$this->addMonitoring('Religious Cast Archive List');
        $params = [
            'nav'               => 'religious',
            'subNav'            => 'religious.cast.archive_list',
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
            $data = ReligiousCast::orderBy('id', 'ASC')->get();
        }else{
            $data = ReligiousCast::onlyTrashed()->orderBy('id', 'ASC')->get();
        }

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('religion', function($row){ return $row->religion->name; })
            ->editColumn('created_by', function($row){ return $row->createdBy->name; })
            ->editColumn('modified_by', function($row){ return empty($row->modifiedBy) ? 'N/A' : $row->modifiedBy->name; })
            ->addColumn('status', function($row){
                return $row->status == 'published' ? '<span class="badge badge-success">'.$row->status.'</span>' : '<span class="badge badge-warning">'.$row->status.'</span>';
            })
            ->addColumn('action', function($row) use($type){
                $li = '<a href="'.route('religious.cast.edit',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    $li .= '<a href="'.route('religious.cast.archive',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }else{
                    $li .= '<a href="'.route('religious.cast.restore',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-warning"  title="undo delete"> <i class="fas fa-redo"></i> </a> ';
                }
                return $li;
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }

    /**
     * Get Religious Cast List By Id
     */
    public function getCastList(Request $request){
        $datas = ReligiousCast::where('religious_id', $request->id)->where('status','published')->orderBy('name','ASC')->get();
        return response()->json($datas);
    }
}
