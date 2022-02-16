<?php

namespace App\Http\Controllers\BackEnd;

use App\Blog;
use App\BlogCatrgory;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
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
     * Show Blog List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }

        $this->addMonitoring('Blog List');
        $params = [
            'nav'               => 'blog',
            'subNav'            => 'blog.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('blog.create'),
            'pageTitle'         => 'Blog List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.blog.table', $params);
    }

    /**
     * Create New Blog
     */
    public function create(){
        $this->addMonitoring('Create Blog');
        $blogCatrgory = BlogCatrgory::where('status', 'published')->orderBy('name', 'ASC')->get();
        return view('backEnd.blog.create',['blogCatrgory' => $blogCatrgory])->render();
    }

    /**
     * Store Idmin Information
     */
    public function store(Request $request){
        try{
            if( $request->slug == "0" ){
                $this->addMonitoring('Create Blog','Add');
                $data = new Blog();
                $data->created_by = Auth::guard('admin')->user()->id;
            }else{
                $this->addMonitoring('Create Blog','Update');
                $data = Blog::withTrashed()->where('slug', $request->slug)->first();
                $data->modified_by = Auth::guard('admin')->user()->id;                
            }
            
            $data->slug = $this->getSlug($request->title, $data, boolval($request->slug) );
            $data->title = $request->title;
            $data->blog_category_id  = $request->blog_category_id ;
            $data->description = $request->description;
            $data->meta_tag = $request->meta_tag;
            $data->meta_description = $request->meta_description;
            $data->status = $request->status;
            $data->image_path = $this->UploadImage($request, 'image_path', $this->images_dir, Null, 400, $data->image_path);
            // $data->image_64 = base64_encode( asset($data->image_path) );
            $data->save();
            $this->success('Blog Information Add Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit Blog Info
     */
    public function edit(Request $request){
        $this->addMonitoring('Edit Blog');
        $blogCatrgory = BlogCatrgory::where('status', 'published')->orderBy('name', 'ASC')->get();
        $data = Blog::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.blog.create',['data' => $data, 'blogCatrgory' => $blogCatrgory])->render();
    }

    /**
     * Blog Details view
     */
    public function view(Request $request){
        $this->addMonitoring('View news');
        $data = Blog::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.blog.view',['data' => $data])->render();
    }


    /**
     * Make the selected Blog As Archive
     */
    public function archive(Request $request){
        try{
            $this->addMonitoring('Blog List','Make Archive', 'active', 'archive');
            $data = Blog::withTrashed()->where('slug', $request->slug)->first();
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
            $this->addMonitoring('Blog Archive List', 'Make active', 'archive', 'active');
            $data = Blog::withTrashed()->where('slug', $request->slug)->first();
            $data->restore();
            $this->success('Blog Restore Successfully');
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
            $this->addMonitoring('Blog Archive List', 'Make active', 'archive', 'delete');
            $data = Blog::withTrashed()->where('slug', $request->slug)->first();
            $this->RemoveFile($data->image_path);
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
        
        $this->addMonitoring('Blog Archive List');
        $params = [
            'nav'               => 'Blog',
            'subNav'            => 'blog.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Blog Archive List',
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
            $data = Blog::orderBy('id', 'ASC')->get();
        }else{
            $data = Blog::onlyTrashed()->orderBy('id', 'ASC')->get();
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
                $li = '<a href="'.route('blog.view',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                $li .= '<a href="'.route('blog.edit',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    $li .= '<a href="'.route('blog.archive',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }else{
                    $li .= '<a href="'.route('blog.restore',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-warning"  title="undo delete"> <i class="fas fa-redo"></i> </a> ';
                    $li .= '<a href="'.route('blog.delete',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" title="Permanent Delete" > <i class="fa fa-trash"></i> </a> ';
                }
                return $li;
            })
            ->rawColumns(['action', 'link','image_path','status'])
            ->make(true);
    }
}
