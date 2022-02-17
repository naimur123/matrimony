<?php

namespace App\Http\Controllers\BackEnd;

use App\BlogCatrgory;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BlogCategoryController extends Controller
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
     * Show Blog List  without Archive
     */
    public function index(Request $request){
        if( $request->ajax() ){
            return $this->getDataTable();
        }

        // $this->addMonitoring('Blog List');
        $params = [
            'nav'               => 'blog',
            'subNav'            => 'blog.category.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('blog.category.create'),
            'pageTitle'         => 'Blog Category List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.blog.table', $params);
    }

    /**
     * Create New Blog
     */
    public function create(){
        // $this->addMonitoring('Create Blog Category');
        return view('backEnd.blog.categoryCreate')->render();
    }

    /**
     * Store Idmin Information
     */
    public function store(Request $request){
        try{
            if( $request->slug == "0" ){
                // $this->addMonitoring('Create Blog Category','Add');
                $data = new BlogCatrgory();
                $data->created_by = Auth::guard('admin')->user()->id;
            }else{
                // $this->addMonitoring('Create Blog Category','Update');
                $data = BlogCatrgory::withTrashed()->where('slug', $request->slug)->first();
                $data->modified_by = Auth::guard('admin')->user()->id;
            }
            $data->slug = $this->getSlug($request->name, $data, boolval($request->slug) );
            $data->name = $request->name;
            $data->status = $request->status;
            $data->save();
            $this->success('Blog Category Add Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit Blog Info
     */
    public function edit(Request $request){
        // $this->addMonitoring('Edit Blog Category');
        $data = BlogCatrgory::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.Blog.categoryCreate',['data' => $data])->render();
    }


    /**
     * Make the selected Blog As Archive
     */
    public function archive(Request $request){
        try{
            // $this->addMonitoring('Blog Category List','Make Archive', 'active', 'archive');
            $data = BlogCatrgory::withTrashed()->where('slug', $request->slug)->first();
            $data->delete();
            $this->success('Make Archive Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected Blog As Active from Archive
     */
    public function restore(Request $request){
        try{
            // $this->addMonitoring('Blog Category Archive List', 'Make active', 'archive', 'active');
            $data = BlogCatrgory::withTrashed()->where('slug', $request->slug)->first();
            $data->restore();
            $this->success('Blog Category Restore Successfully');
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
            // $this->addMonitoring('Blog Category Archive List', 'Make active', 'archive', 'delete');
            $data = BlogCatrgory::withTrashed()->where('slug', $request->slug)->first();
            // $this->RemoveFile($data->image_path);
            $data->forceDelete();
            $this->success('Permanently Delete Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Blog List
     */
    public function archiveList(Request $request){

        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }

        // $this->addMonitoring('Blog Archive List');
        $params = [
            'nav'               => 'blog',
            'subNav'            => 'blog.category.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Blog Category Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.blog.table', $params);
    }

    /**
     * Get Blog DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = BlogCatrgory::orderBy('id', 'ASC')->get();
        }else{
            $data = BlogCatrgory::onlyTrashed()->orderBy('id', 'ASC')->get();
        }

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->editColumn('created_by', function($row){ return $row->createdBy->name; })
            ->editColumn('modified_by', function($row){ return empty($row->modifiedBy) ? 'N/A' : $row->modifiedBy->name; })
            ->addColumn('status', function($row){
                return $row->status == 'published' ? '<span class="badge badge-success">'.$row->status.'</span>' : '<span class="badge badge-warning">'.$row->status.'</span>';
            })
            ->addColumn('action', function($row) use($type){
                // $li = '<a href="'.route('blog.profile',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                $li = '<a href="'.route('blog.category.edit',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    $li .= '<a href="'.route('blog.category.archive',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }else{
                    $li .= '<a href="'.route('blog.category.restore',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
                    // $li .= '<a href="'.route('blog.category.delete',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" title="Permanent Delete" > <i class="fa fa-trash"></i> </a> ';
                }
                return $li;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
}
