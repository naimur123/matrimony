<?php

namespace App\Http\Controllers\BackEnd;

use App\Banner;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{
    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'image', 'link', 'status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'image_path', 'link', 'status', 'created_by', 'modified_by', 'action'];
        return $columns;
    }

    /**
     * Show Banner List  without Archive
     */
    public function index(Request $request){
        if( $request->ajax() ){
            return $this->getDataTable();
        }

        // $this->addMonitoring('Banner List');
        $params = [
            'nav'               => 'banner',
            'subNav'            => 'banner.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('banner.create'),
            'pageTitle'         => 'Banner List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.banner.table', $params);
    }

    /**
     * Create New Banner
     */
    public function create(){
        // $this->addMonitoring('Create Banner');
        return view('backEnd.banner.create')->render();
    }

    /**
     * Store Idmin Information
     */
    public function store(Request $request){
        try{
            if( $request->slug == "0" ){
                // $this->addMonitoring('Create Banner','Add');
                $data = new Banner();
                $data->created_by = Auth::guard('admin')->user()->id;
            }else{
                // $this->addMonitoring('Create Banner','Update');
                $data = Banner::withTrashed()->where('slug', $request->slug)->first();
                $data->modified_by = Auth::guard('admin')->user()->id;
            }
            $data->slug = $this->getSlug();
            $data->link = $request->link;
            $data->status = $request->status;
            $data->image_path = $this->UploadImage($request, 'image_path', $this->banner_dir, 1000, Null, $data->image_path);
            // $data->image_64 = base64_encode( asset($data->image_path) );
            $data->save();
            $this->success('Banner Information Add Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit Banner Info
     */
    public function edit(Request $request){
        // $this->addMonitoring('Edit Banner');
        $data = Banner::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.Banner.create',['data' => $data])->render();
    }

    /**
     * Show Banner Profile
     */
    public function showProfile(Request $request){
        // $this->addMonitoring('View Banner Profile');
        $data = Banner::withTrashed()->where('slug', $request->slug)->first();
        return view('backEnd.Banner.profile',['data' => $data])->render();
    }

    /**
     * Make the selected Banner As Archive
     */
    public function archive(Request $request){
        try{
            // $this->addMonitoring('Banner List','Make Archive', 'active', 'archive');
            $data = Banner::withTrashed()->where('slug', $request->slug)->first();
            $data->delete();
            $this->success('Make Archive Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected Banner As Active from Archive
     */
    public function restore(Request $request){
        try{
            // $this->addMonitoring('Banner Archive List', 'Make active', 'archive', 'active');
            $data = Banner::withTrashed()->where('slug', $request->slug)->first();
            $data->restore();
            $this->success('Banner Restore Successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Banner List
     */
    public function archiveList(Request $request){

        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }

        // $this->addMonitoring('Banner Archive List');
        $params = [
            'nav'               => 'banner',
            'subNav'            => 'banner.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Banner Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.Banner.table', $params);
    }

    /**
     * Get Banner DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = Banner::orderBy('id', 'ASC')->get();
        }else{
            $data = Banner::onlyTrashed()->orderBy('id', 'ASC')->get();
        }

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->editColumn('created_by', function($row){ return $row->createdBy->name; })
            ->editColumn('modified_by', function($row){ return empty($row->modifiedBy) ? 'N/A' : $row->modifiedBy->name; })
            ->editcolumn('link', function($row){ return empty($row->link) ? 'N/A' : '<a href="'.$row->link.'" target="_blank"> Link </a>'; })
            ->editcolumn('image_path', function($row){ return '<img src="'.asset($row->image_path).'" height="60">'; })
            ->addColumn('status', function($row){
                return $row->status == 'published' ? '<span class="badge badge-success">'.$row->status.'</span>' : '<span class="badge badge-warning">'.$row->status.'</span>';
            })
            ->addColumn('action', function($row) use($type){
                // $li = '<a href="'.route('Banner.profile',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                $li = '<a href="'.route('banner.edit',['slug' => $row->slug]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    $li .= '<a href="'.route('banner.archive',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }else{
                    $li .= '<a href="'.route('banner.restore',['slug' => $row->slug]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
                }
                return $li;
            })
            ->rawColumns(['action', 'link','image_path','status'])
            ->make(true);
    }
}
