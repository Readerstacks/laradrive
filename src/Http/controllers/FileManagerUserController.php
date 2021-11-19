<?php

namespace Readerstacks\Drive\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;   
use File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Session;
use DB;
use Auth;
use Config;


class FileManagerUserController extends Controller
{

    protected $model;
    protected $title;
    protected $pmodule;
    protected $view_folder;
    protected  $mTable;

    public function __construct()
    {
        $this->model = 'file-manager-user';
        $this->title = 'File Manager User';
        $this->pmodule = 'file-manager-user';
        $this->view_folder = 'Drive::file_manager_user';
        $this->mTable = 'Readerstacks\Drive\Models\FileManagerUser';   
    } 



    

    public function index()
    {

        //dd( SMSApi::bulkSms('pushpendra hello',"726063958"));
       
        try{
            $title= $this->title; 
            $model= $this->model;
           
            $breadcum = [ ];
           
            $pmodule = $this->pmodule;
            $mTable =  $this->mTable;
            
             
            {

                // $nestedData['storage'] = "Storage : ".$list->storage_real." ".$list->storage_unit.
                // " <br>Used : ".number_format((float)$list->storage_used/1024, 2, '.', '')." MB <br>Documents : ".(\App\Models\FileManager::whereUserId($list->user_id)->withTrashed()->count());
                $stats=$this->mTable::selectRaw("sum(storage) as total_storage,sum(storage_used) as used")->first();
                
                $stats->total_storage=$this->calculateReadableStorage($stats->total_storage);
                $stats->used=$this->calculateReadableStorage($stats->used);
                
                return view(  'Drive::file_manager_user.index',compact('title','breadcum','pmodule','model','mTable','stats'));
            }
           
            
        }
        catch(\Exception $e)
        {
           echo $msg = $e->getMessage();
        //    Session::flash('warning', $msg);
        //    return redirect()->back();
        }

    }
    public function decimalTwo($val){
        return number_format((float)$val, 2, '.', '');
        } 
    public function calculateReadableStorage($storage){
        $returnable="0 KB";
       
        if($storage>=1024*1024){
          
            $returnable             = $this->decimalTwo($storage/(1024*1024))." GB"; 
        }
        else if($storage>=1024 ){
            $returnable             = $this->decimalTwo($storage/1024)." MB"; 
             
        }
        else{
            $returnable             = $this->decimalTwo($storage)." KB"; 
        }
        return $returnable;

    }
    /* User datatable listing load by ajax */

    public function datatables(Request $request)
    {
        $pmodule = $this->pmodule;
        $columns = ['id','user', 'storage','storage_user','created_at','updated_at','action'];
        $permission =  getMyAllPermissions();
        $totalData= $this->mTable::where('id','>','0')->count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if(empty($request->input('search.value')))
        {            
            $posts =  $this->mTable::where('id','>','0')->offset($start)
                ->limit($limit);
           
            $posts =  $posts->orderBy($order,$dir)
                ->get();
        }
        else
        {
            $search = $request->input('search.value'); 
            $posts = $this->mTable::where('id','>','0')->where(function($query) use ($search){
                            $query->where('id','LIKE',"%{$search}%")
                            
                            ->orWhere('email','LIKE',"%{$search}%")
                            ;
                           
                            
                        });
            
            $posts =   $posts->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
                  
            $totalFiltered = $this->mTable::where('id','>','0')->where(function($query) use ($search){
                            $query->where('id','LIKE',"%{$search}%")
                            ->orWhere('email','LIKE',"%{$search}%")
                            ;
                        });
            
            $totalFiltered =    $totalFiltered->count();
        }
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $list)
            {
                $nestedData['id'] = $list->id;
                
                $nestedData['storage'] = "Storage : ".$list->storage_real." ".$list->storage_unit.
                " <br>Used : ".$this->calculateReadableStorage($list->storage_used)." <br>Documents : ".(\App\Models\FileManager::whereUserId($list->user_id)->withTrashed()->count());
                $nestedData['user'] = \App\Models\User::find($list->user_id)->email;
                $nestedData['created_at'] =  "<p>".getHumanReadabledateWithTime($list->created_at)."</p>";
                  $nestedData['updated_at'] = "<p>".getHumanReadabledateWithTime($list->updated_at)."</p>";
              
                $nestedData['action'] = '';
                $nestedData['status'] = '';

               

               
                $nestedData['action'] .= '<div class="list-actions">';
                if(isset($permission[$this->pmodule.'___edit']) || $permission == 'superadmin')
                {
                   $nestedData['action'] .= getActionButtons([['key'=>'edit','url'=>route($this->model.'.edit',$list->id)]]);
                }

                 if(isset($permission[$this->pmodule.'___delete']) || $permission == 'superadmin')
                    {
                        $nestedData['action'] .= getActionButtons([['key'=>'delete','url'=>route($this->model.'.delete',$list->id)]]);
                    }
               

                
                $nestedData['action'] .= '</div>';
                $data[] = $nestedData;
            }
        }

        $json_data = array(
                "draw"            => intval($request->input('draw')),  
                "recordsTotal"    => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data"            => $data   
                );
        echo json_encode($json_data); 
    }

    /* User create form method */

    public function create()
    {
        try
        {
   
            
                $title = $this->title;
                $model = $this->model;
               $breadcum = '';
                return view($this->view_folder.'.create',compact('title','model','breadcum'));
             
        }
        catch(\Exception $e)
        {
           $msg = $e->getMessage();
           Session::flash('warning', $msg);
           return redirect()->back()->withInput();
        }     
    }

    

    public function store(Request $request)
    {
        try
        {
            $customMessages = [
                
            ];
            $validator = Validator::make($request->all(), [
                'user' => 'required|unique:file_manager_users,user_id',
                'storage' => 'required|unique:file_manager_users',
                'storage_unit' => 'required',
              
               
                ],$customMessages);

            if ($validator->fails()) 
            {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }
            else
            {
                $FileManagerUser = new $this->mTable();
                 
                $FileManagerUser->user_id=$request->user;
                if($request->storage_unit=='MB'){
                  $storgeSize= $request->storage*1024;
                }
                else if($request->storage_unit=='GB'){
                   $storgeSize= $request->storage*1024*1024;
                }
                else{
                   $storgeSize= $request->storage;
                }
                $FileManagerUser->storage=$storgeSize;
                $FileManagerUser->storage_real=$request->storage;
                $FileManagerUser->storage_unit=$request->storage_unit;
                $FileManagerUser->storage_used=0;
                $FileManagerUser->client_key="test";
                $FileManagerUser->client_secret="test";
                $FileManagerUser->email=\App\Models\User::find($request->user)->email;
                $FileManagerUser->save();
                
               
                
                Session::flash('success', __('messages.store'));
                return redirect()->route($this->model.'.index'); 
            } 
        }
        catch(\Exception $e)
        {
           $msg = $e->getMessage();
           Session::flash('warning', $msg);
           return redirect()->back()->withInput();
        }
    }


    /* Edit the user data */

    public function edit($slug)
    {
        try
        {
            $permission =  getMyAllPermissions();
            if(isset($permission[$this->pmodule.'___edit']) || $permission == 'superadmin')
            {
                $row =  $this->mTable::whereId($slug)->first();
                if($row)
                {
                    $title = $this->title;
                   
                    $model =$this->model;
                     $breadcum = [$title=>route($model.'.index'),getBreadCrumSetting('update')=>'',$row->title=>''];
                    return view($this->view_folder.'.edit',compact('title','model','breadcum','row')); 
                }
                else
                {
                    Session::flash('warning', getErrorMessages());
                    return redirect()->back();
                }
            }
            else
            {
                Session::flash('warning', getErrorMessages());
                return redirect()->back();
            }
        }
        catch(\Exception $e)
        {
           $msg = $e->getMessage();
           Session::flash('warning', $msg);
           return redirect()->back();
        }
    }

    /* Update the user data */
    
    public function update(Request $request, $slug)
    {
        try
        {
            $row =  $this->mTable::whereId($slug)->first();
           $customMessages = [
               
            ];
            $validator = Validator::make($request->all(), [
                 
                'storage' => 'required',
                
                ],$customMessages);
            if ($validator->fails()) 
            {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }
            else
            {
                $previous_row = $row;
                if($request->storage_unit=='MB'){
                    $storgeSize= $request->storage*1024;
                  }
                  else if($request->storage_unit=='GB'){
                     $storgeSize= $request->storage*1024*1024;
                  }
                  else{
                     $storgeSize= $request->storage;
                  }
                  $row->storage=$storgeSize;
                  $row->storage_real=$request->storage;
                  $row->storage_unit=$request->storage_unit;

                $row->save();
                Session::flash('success', __('messages.update'));
                return redirect()->route($this->model.'.index');
            }
           
        }
        catch(\Exception $e)
        {
           $msg = $e->getMessage();
           Session::flash('warning', $msg);
           return redirect()->back()->withInput();
        }
    }

    /* Delete the user data */

    public function delete($slug)
    {
        try
        {
            
            $permission =  getMyAllPermissions();
            if(isset($permission[$this->pmodule.'___delete']) || $permission == 'superadmin')
            {
                $row = $this->mTable::where('id',$slug)->first();
                if($row)
                {
                    $row ->delete();
                        Session::flash('success', 'Row deleted successfully');
                    
                } 
                else
                {
                    Session::flash('warning', getErrorMessages());
                }
                
                return redirect()->back();
            }
            else
            {
                Session::flash('warning', getErrorMessages());
                return redirect()->back(); 
            }
        }
        catch(\Exception $e)
        {
           // dd($e->errorInfo);
           $msg = $e->getMessage();
           Session::flash('warning', $msg);
           return redirect()->back();
        }
        
    }

    /*
    * Reset user status
    */
    public function changeStatus($slug)
    {
        try
        {
            $permission =  getMyAllPermissions();
            if(isset($permission[$this->pmodule.'___status']) || $permission == 'superadmin')
            {
                $row = $this->mTable::where('slug',$slug)->first();
                if($row)
                {
                    $row->status = $row->status=='1'?'0':'1';
                    $row->save();
                    Session::flash('success', __('messages.status'));
                    return redirect()->back();
                }
                else
                {
                    Session::flash('warning', getErrorMessages());
                    return redirect()->back();
                }
            }
            else
            {
                Session::flash('warning', getErrorMessages());
                return redirect()->back(); 
            }
        }
        catch(\Exception $e)
        {

           $msg = $e->getMessage();
           Session::flash('warning', $msg);
           return redirect()->back();
        }
        
    }

    /* Import csv */
    public function import(Request $request){
       
        $message = "";
        $status = false;
        $validatorData  = $this->importExcelValidationRules($request);
        $requestData    = $validatorData['data'];
        $rules          = $validatorData['rules'];
        $customMessages = $validatorData['messages'];

        $validator = Validator::make($requestData,$rules,$customMessages);

        if ($validator->fails()) 
        {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        else
        {
            if($request->file('import_excel'))
            {
                $data =  \Excel::toArray(new $this->mTable, request()->file('import_excel')); 

                $data = $data[0];
                if(in_array("Counties",$data[0])){

                    $insertedData   = [];
                    $title_key = array_search('Counties', $data[0]);
                    unset($data[0]);
                    
                    $i = 1;
                    $j = 0;
                    $totalRowCount = count($data);

                    foreach ($data as $key => $value) {
                        $insertedData['title']           = ($value[$title_key])?$value[$title_key]:null;

                        $rules = [
                            'title'          => 'required|max:255',
                        ];

                        $validator = Validator::make($insertedData,$rules,[]);

                        if ($validator->fails()) 
                        {   
                            //$status = false;
                            foreach($validator->errors()->all() as $key=>$error){
                                $message .= "row_$i"."_".$error."<br>";
                            }
                            //Session::flash('warning', $message);
                        }
                        else
                        {
                            $row = $this->mTable::where('title',$insertedData['title'])->first();
                            if(empty($row))
                            {
                                $row = new $this->mTable();
                                $row->title  = $insertedData['title'];
                                $row->save();
                                $j++;
                                //Session::flash('success', __('messages.store'));
                            }
                            $status = true;
                        }

                        $i++;
                    }

                    if($status){
                        Session::flash('success', __("Your upload was successful, all $j out of $totalRowCount rows uploaded"));
                    }
                   // Session::flash('success', __('messages.store'));
                }else{
                    Session::flash('warning',__('Please upload a valid CSV.') );
                }
                return redirect()->back(); 
            }
        }
    }

    public function getAllUserForEmail(Request $request,$role = "BACKEND")
    {
        $search              = $request->querystr;

        $authUser = Auth::guard('web')->user();
        $rows = \App\Models\User::select('id','email','preferred_name','first_name','last_name','national_id');

        if($role=="BACKEND")
        {
           
            

            $rows = $rows->where(function($qq) use($search)
            {
                $qq->where('preferred_name','LIKE',"%{$search}%")
                    ->whereRaw(DB::raw("CONCAT(first_name,' ',last_name)  LIKE '%{$search}%'"))
                    ->orWhere('email','LIKE',"%{$search}%")
                    ->orWhereRaw(DB::raw("CONCAT('+',country_code,'-',mobile)  LIKE '%{$search}%'"))
                    ->orWhereRaw(DB::raw("CONCAT('+',country_code,mobile)  LIKE '%{$search}%'"))
                    ->orWhere('national_id','LIKE',"%{$search}%");
            });

            $rows=$rows->whereHas('getUserRoles',function($q){
                        return $q->whereNotIn('role_id',[
                        Config::get('constants.roles.Anonymous'),
                        Config::get('constants.roles.Verified'),
                        Config::get('constants.roles.Not_Verified')



                        ])->whereHas("getRole",function($rr){
                        $rr->where("can_login_in_backend","1");
                        });
                        })->orderBy("email");
        }
        else
        {
            $rows= $rows->where("id","!=",$authUser->id);
        }

        $rows = $rows->limit(10)->get();

        $dataArr = [];
        if($rows && count($rows)>0)
        {
          foreach($rows as $row)
          {
            $dataArr[$row->id] = $row->first_name.' '.$row->last_name.' ('.$row->email.')';
          }
        }
      return $dataArr;
    }

}
