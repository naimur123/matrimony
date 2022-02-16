<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\TermsRegulation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TramsRegulationController extends Controller
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
     * Show tramsRegulation List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }

        $this->addMonitoring('tramsRegulation List');
        $params = [
            'nav'               => 'tramsRegulation',
            'subNav'            => 'tramsRegulation.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('tramsRegulation.create'),
            'pageTitle'         => 'TramsRegulation List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.tramsRegulation.table', $params);
    }

    /**
     * Create New tramsRegulation
     */
    public function create(){
        $this->addMonitoring('Create tramsRegulation');
        return view('backEnd.tramsRegulation.create')->render();
    }

    /**
     * Store Idmin Information
     */
    public function store(Request $request){
        try{
            if( $request->slug == "0" ){
                $this->addMonitoring('Create tramsRegulation','Add');
                $data = new TermsRegulation();
                $data->created_by = Auth::guard('admin')->user()->id;
            }else{
                $this->addMonitoring('Create tramsRegulation','Update');
                $data = TermsRegulation::withTrashed()->where('slug', $request->slug)->first();
                $data->modified_by = Auth::guard('admin')->user()->id;            
            }
            $data->slug = $this->getSlug($request->title, $data, boolval($request->slug) );
            $data->title = $request->title;
            $data->description = $request->description;
            $data->status = $request->status;
            // $data->image_path = $this->UploadImage($request, 'image_path', $this->images_dir, Null, 400, $data->image_path);
            // $data->image_64 = base64_encode( asset($data->image_path) );
            $data->save();
            $this->success('Trams & Regulation Information Add Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit tramsRegulation Info
     */
    public function edit(Request $request){
        $this->addMonitoring('Edit tramsRegulation');
        $data = TermsRegulation::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.tramsRegulation.create',['data' => $data])->render();
    }

    /**
     * tramsRegulation Details view
     */
    public function view(Request $request){
        $this->addMonitoring('View tramsRegulation');
        $data = TermsRegulation::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.tramsRegulation.view',['data' => $data])->render();
    }

    /**
     * Make the selected tramsRegulation As Archive
     */
    public function archive(Request $request){
        try{
            $this->addMonitoring('tramsRegulation List','Make Archive', 'active', 'archive');
            $data = TermsRegulation::withTrashed()->where('slug', $request->slug)->first();
            $data->delete();
            $this->success('Make Archive Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected tramsRegulation As Active from Archive
     */
    public function restore(Request $request){
        try{
            $this->addMonitoring('tramsRegulation Archive List', 'Make active', 'archive', 'active');
            $data = TermsRegulation::withTrashed()->where('slug', $request->slug)->first();
            $data->restore();
            $this->success('Trams & Regulation Restore Successfully');
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
            $this->addMonitoring('tramsRegulation Archive List', 'Make active', 'archive', 'delete');
            $data = TermsRegulation::withTrashed()->where('slug', $request->slug)->first();
            $this->RemoveFile($data->image_path);
            $data->forceDelete();
            $this->success('Permanently Delete Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive tramsRegulation List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        $this->addMonitoring('tramsRegulation Archive List');
        $params = [
            'nav'               => 'tramsRegulation',
            'subNav'            => 'tramsRegulation.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'tramsRegulation Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.tramsRegulation.table', $params);
    }

    /**
     * Get tramsRegulation DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = TermsRegulation::orderBy('id', 'ASC')->get();
        }else{
            $data = TermsRegulation::onlyTrashed()->orderBy('id', 'ASC')->get();
        }
        
        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; }) 
            ->editColumn('created_by', function($row){ return $row->createdBy->name; })           
            ->editColumn('description', function($row){ return substr($row->description, 0 ,50 ).'...'; })           
            ->editColumn('modified_by', function($row){ return empty($row->modifiedBy) ? 'N/A' : $row->modifiedBy->name; })
            ->addColumn('status', function($row){
                return $row->status == 'published' ? '<span class="badge badge-success">'.$row->status.'</span>' : '<span class="badge badge-warning">'.$row->status.'</span>';
            })
            ->addColumn('action', function($row) use($type){ 
                $li = '<a href="'.route('tramsRegulation.view',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                $li .= '<a href="'.route('tramsRegulation.edit',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    $li .= '<a href="'.route('tramsRegulation.archive',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }else{
                    $li .= '<a href="'.route('tramsRegulation.restore',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-warning"  title="undo delete"> <i class="fas fa-redo"></i> </a> ';
                    $li .= '<a href="'.route('tramsRegulation.delete',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" title="Permanent Delete" > <i class="fa fa-trash"></i> </a> ';
                }
                return $li;
            })
            ->rawColumns(['action', 'link', 'status'])
            ->make(true);
    }
}
