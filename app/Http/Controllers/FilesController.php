<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use \App\Mail\BudgetApprovalRequest;
use Illuminate\Support\Facades\DB;
use ZipArchive;
use DataTables;

use App\Models\files;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created file in storage.
     */
    public function store(){
        $user_id = auth()->user()->id;

        $validatedData = request()->validate([
            'file_note' => 'required|max:1000',
            'upload_files.*' => 'required|mimes:jpeg,jpg,png,svg,txt,htm,html,php,css,mp3,pdf,psd,doc,docx,xls,xlsx,ppt,pptx|max:8000',
            'upload_files' => 'required|min:1|max:5'
        ]);
        //return filesize (request()->upload_files[0]);

        //save the images
        if (request()->hasFile('upload_files')) {
            foreach (request()->upload_files as $file) {
                
                $file_name = $file->getClientOriginalName();
                $newName = $file_name."-filruser".$user_id;
                $extension = $file->getClientOriginalExtension();

                //$file_data = file_get_contents($file);
                //$file_data = base64_encode(file_get_contents($file));
                //get file contents
                // $data = fopen ($file, 'rb');
                 $size = filesize ($file);
                // $contents = fread ($data, $size);
                // fclose ($data);

                //move the file to the right folder
                if($file->move(base_path('public/uploads/'), $newName)){
                    //save the file
                    $imageId = DB::table('files')
                        ->insertGetId(array('user_id' => $user_id, 
                            'file_data' => $file_name,'file_size' => $size, 'file_name' => $newName,
                            'note' => $validatedData['file_note'], 'content_type' => $extension, 
                            'created_at' => date('Y-m-d H:i:s')));

                }
            }

            if($imageId){
                return response()->json(['success'=>'File successfully saved.']);
            }else {

                return response()->json(['error'=>'Ooops! An error occured during image upload.']);
            }

        }else{
            return response()->json(['error'=>'File(s) not found.']);
        }
    }

    //to check file size
    function formatBytes($bytes, $precision = 2) { 
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
    
        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 
    
        // Uncomment one of the following alternatives
        // $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow)); 

        //return round($bytes, $precision) . ' ' . $units[$pow]; 
    
        return round($bytes, $precision); 
    } 

    /**
     * save edit to a file's note
     */
    public function saveNoteEdit(){
        $user_id = auth()->user()->id;

        $validatedData = request()->validate([
            'edit_file_note' => 'required|max:1000',
            'edit_file_id' => 'required'
        ]);

        $res = DB::table('files')
        ->where('files.id', '=', $validatedData['edit_file_id']) 
        ->update(array('note' => $validatedData['edit_file_note'], 
            'updated_at' => date('Y-m-d H:i:s')));

        if($res){
            return response()->json(['success'=>'Note edited successfully.']);
        }else {

            return response()->json(['error'=>'Ooops! An error occured during note update.']);
        }
    }

    /**
     * Display the user's files in the table.
     */
    public function show(){
        $user_id = auth()->user()->id;
        if (request()->ajax()) {
                $data = DB::table('files')
                ->select('files.id','files.file_name','files.file_data',
                'files.note','files.created_at','files.file_size')
                ->where([
                    ['files.user_id', '=', $user_id]
                        ]) 
                ->orderBy('files.created_at','desc')
                ->get();
            
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){

                $action = '<div class="btn-toolbar"> <div> 
                        <button class="btn btn-xs btn-outline-info btn-icon" data-toggle="tooltip" data-placement="bottom" onclick="onDownloadFileClick('.$row->id.')" title="Download" id="download-file" data-id='.$row->id.'><i class="fas fa-download"></i></button>
                        <button class="btn btn-xs btn-outline-primary btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Note" onclick="onEditFileClick('.$row->id.')"  id="edit-file" data-id='.$row->id.'> <i class="fas fa-edit"></i></button> 
                        <button class="btn btn-xs btn-outline-danger btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete" onclick="onDeleteFileClick('.$row->id.')"  id="delete-file" data-id='.$row->id.'> <i class="fas fa-trash"></i></button> 
                        </div></div>';

            return $action;

            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    //download the file for viewing
    public function downloadFile($file_id){
        $file_name = DB::table('files')
            ->select('file_name','user_id')
            ->where('id', '=', $file_id)
            ->first();

        if(!$file_name){
            return response()->json(['error'=>'The file could not be found.']);
        }

        $headers = [
            'Content-Type' => 'application/pdf',
         ];

        $originalName = substr($file_name->file_name, 0, strpos($file_name->file_name, '-filruser'.$file_name->user_id));

        $file_path = base_path('public/uploads/' . $file_name->file_name);

        return response()->download($file_path, $originalName);
    }

    public function downloadFileV($file_id){
        $file_name = DB::table('files')
            ->select('file_name','file_data','content_type')
            ->where('id', '=', $file_id)
            ->first();

        if(!$file_name){
            return response()->json(['error'=>'The file could not be found.']);
        }

        $decoded = base64_decode($file_name->file_data);
        //$bytesWriten = file_put_contents($file_name->file_name, $file_name->file_data);

        return response($decoded)
            ->header('Cache-Control', 'no-cache private')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', $file_name->content_type)
            ->header('Content-length', strlen($decoded))//strlen($decoded)
            ->header('Content-Disposition', 'attachment; filename=' . $file_name->file_name)
            ->header('Content-Transfer-Encoding', 'binary');
            
            
         //file_put_contents(base_path('public/uploads/' . $file_name->file_name), $decoded);

        // $headers = [
        //     'Content-Type' => 'application/pdf',
        //  ];

        // $file_path = base_path('public/uploads/' . $file_name->file_name);

        // return response()->download($file_path, $file_name->file_name);
    }

    //calculate the size of all the user's file uploads
    public function totalUploadsSize(){
        $user_id = auth()->user()->id;

        return DB::table('files')
                ->select(DB::raw("COALESCE(SUM(file_size),0) AS total_size"))
                ->distinct()
                ->where([
                    ['files.user_id', '=', $user_id]
                ])
                ->first();
    }
    /**
     * Delete a file.
     */
    function destroy(){
        $fileId = request()->input('file_id');

        $file_name = DB::table('files')
            ->select('file_name')
            ->where('id', '=', $fileId)
            ->first();

        if(!$file_name){
            return response()->json(['error'=>'The file could not be found.']);
        }

        if(empty($file_name->file_name)){
            //no file was attached, just delete the record
            $itemsDeleted = DB::table('files')
                ->where('id', '=', $fileId)
                ->delete();
            return ($itemsDeleted == 1) ? 
            response()->json(['success'=>'File deleted successfully.']) : 
            response()->json(['error'=>'Ooops! File not deleted. Something went wrong.']);
        }else{
            $file_path = base_path('public/uploads/' . $file_name->file_name);
            if (unlink($file_path)) {
                //if file has been unlinked/deleted, remove the record from the db too
                
                $itemsDeleted = DB::table('files')
                    ->where('id', '=', $fileId)
                    ->delete();
                return ($itemsDeleted == 1) ? 
                response()->json(['success'=>'File deleted successfully.']) : 
                response()->json(['error'=>'Ooops! File not deleted. Something went wrong.']);
            }
        }
        
        return response()->json(['error'=>'Ooops! File not deleted. Something went wrong.']);
        
    }

    //get a single file to edit its note
    public function getSingleFile($file_id){
        return DB::table('files')
            ->select('files.id','files.file_name','files.file_data',
            'files.note','files.created_at','files.file_size')
            ->where('id', '=', $file_id)
            ->first();

    }
}
