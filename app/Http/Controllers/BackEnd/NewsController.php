<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\News;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
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
     * Show news List  without Archive
     */
    public function index(Request $request){
        if( $request->ajax() ){
            return $this->getDataTable();
        }

        //$this->addMonitoring('news List');
        $params = [
            'nav'               => 'news',
            'subNav'            => 'news.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('news.create'),
            'pageTitle'         => 'news List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.news.table', $params);
    }

    /**
     * Create New news
     */
    public function create(){
        //$this->addMonitoring('Create news');
        return view('backEnd.news.create')->render();
    }

    /**
     * Store Idmin Information
     */
    public function store(Request $request){
        try{
            if( $request->slug == "0" ){
                //$this->addMonitoring('Create news','Add');
                $data = new News();
                $data->created_by = Auth::guard('admin')->user()->id;
            }else{
                //$this->addMonitoring('Create news','Update');
                $data = News::withTrashed()->where('slug', $request->slug)->first();
                $data->modified_by = Auth::guard('admin')->user()->id;
            }

            $data->slug = $this->getSlug($request->title, $data, boolval($request->slug) );
            $data->title = $request->title;
            $data->meta_tag = $request->meta_tag;
            $data->meta_description = $request->meta_description;
            $data->description = $request->description;
            $data->status = $request->status;
            $data->image_path = $this->UploadImage($request, 'image_path', $this->images_dir, Null, 400, $data->image_path);
            // $data->image_64 = base64_encode( asset($data->image_path) );
            $data->save();
            $this->success('news Information Add Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit news Info
     */
    public function edit(Request $request){
        //$this->addMonitoring('Edit news');
        $data = News::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.news.create',['data' => $data])->render();
    }

    /**
     * News Details view
     */
    public function view(Request $request){
        //$this->addMonitoring('View news');
        $data = News::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.news.view',['data' => $data])->render();
    }

    /**
     * Make the selected news As Archive
     */
    public function archive(Request $request){
        try{
            //$this->addMonitoring('News List','Make Archive', 'active', 'archive');
            $data = News::withTrashed()->where('slug', $request->slug)->first();
            $data->delete();
            $this->success('Make Archive Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected news As Active from Archive
     */
    public function restore(Request $request){
        try{
            //$this->addMonitoring('News Archive List', 'Make active', 'archive', 'active');
            $data = News::withTrashed()->where('slug', $request->slug)->first();
            $data->restore();
            $this->success('news Restore Successfully');
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
            //$this->addMonitoring('news Archive List', 'Make active', 'archive', 'delete');
            $data = News::withTrashed()->where('slug', $request->slug)->first();
            $this->RemoveFile($data->image_path);
            $data->forceDelete();
            $this->success('Permanently Delete Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive news List
     */
    public function archiveList(Request $request){

        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }

        //$this->addMonitoring('news Archive List');
        $params = [
            'nav'               => 'news',
            'subNav'            => 'news.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'news Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.news.table', $params);
    }

    /**
     * Get news DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = News::orderBy('id', 'ASC')->get();
        }else{
            $data = News::onlyTrashed()->orderBy('id', 'ASC')->get();
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
                $li = '<a href="'.route('news.view',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                $li .= '<a href="'.route('news.edit',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    $li .= '<a href="'.route('news.archive',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }else{
                    $li .= '<a href="'.route('news.restore',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-warning"  title="undo delete"> <i class="fas fa-redo"></i> </a> ';
                    $li .= '<a href="'.route('news.delete',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" title="Permanent Delete" > <i class="fa fa-trash"></i> </a> ';
                }
                return $li;
            })
            ->rawColumns(['action', 'link','image_path','status'])
            ->make(true);
    }
}
