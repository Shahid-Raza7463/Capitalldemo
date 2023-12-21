<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Log;

class DiscussController extends Controller
{
 

    public function index(Request $request)
    {
      
        try {
            $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'teammember_id' => 'required',
        ]);
    
            if ($request->role_id == 11) {
                $discussDatas = DB::table('discuses')
        ->leftJoin('clients', 'clients.id', '=', 'discuses.related_ids')
        ->leftJoin('assignments', 'assignments.id', '=', 'discuses.related_id')
        ->leftJoin('discusswithteams', 'discuses.id', '=', 'discusswithteams.discuss_id')
        ->leftJoin('discusesteammebers', 'discusesteammebers.discuss_id', '=', 'discuses.id')
        ->leftJoin('teammembers', 'teammembers.id', '=', 'discusesteammebers.teammember_id')
		->leftJoin('teammembers AS created_by', 'created_by.id', '=', 'discuses.createdby') // Join for createdby field
      
        ->select(
            'discuses.id',
            'discuses.topic',
            'discuses.relatedto',
            'discuses.other',
            'clients.client_name',
            'assignments.assignment_name',
			'discuses.created_at',
			 'created_by.team_member AS createdby_name',
            DB::raw('GROUP_CONCAT(DISTINCT discusswithteams.teammember_ids) as teammember_ids'),
            DB::raw('GROUP_CONCAT(DISTINCT teammembers.team_member) as team_members','discuses.created_at')
        )
        ->groupBy('discuses.id','discuses.topic','discuses.relatedto','discuses.other','clients.client_name','assignments.assignment_name','createdby_name','discuses.created_at')
        ->get();
        
      } elseif (in_array($request->role_id, [13, 14, 16, 17, 18, 20])) {
    $discussDatas = DB::table('discuses')
        ->leftJoin('clients', 'clients.id', '=', 'discuses.related_ids')
        ->leftJoin('assignments', 'assignments.id', '=', 'discuses.related_id')
        ->leftJoin('discusswithteams', 'discuses.id', '=', 'discusswithteams.discuss_id')
        ->leftJoin('discusesteammebers', 'discusesteammebers.discuss_id', '=', 'discuses.id')
        ->leftJoin('teammembers', 'teammembers.id', '=', 'discusesteammebers.teammember_id')
        ->leftJoin('teammembers AS created_by', 'created_by.id', '=', 'discuses.createdby') // Join for createdby field
        ->where(function ($query) use ($request) {
            $query->where('discusesteammebers.teammember_id', $request->teammember_id)
                ->orWhere('discuses.createdby', $request->teammember_id);
        })
        ->select(
            'discuses.id',
            'discuses.topic',
            'discuses.relatedto',
            'discuses.other',
            'clients.client_name',
            'assignments.assignment_name',
            'discuses.created_at',
            'created_by.team_member AS createdby_name', // Select the createdby field and assign an alias
            DB::raw('GROUP_CONCAT(DISTINCT discusswithteams.teammember_ids) as teammember_ids'),
            DB::raw('GROUP_CONCAT(DISTINCT teammembers.team_member) as team_members')
        )
        ->groupBy('discuses.id', 'discuses.topic', 'discuses.relatedto', 'discuses.other', 'clients.client_name', 'assignments.assignment_name', 'discuses.created_at', 'createdby_name') // Update the grouping
        ->get();
}
 else {
                
                $discussDatas = DB::table('discuses')
        ->leftJoin('clients', 'clients.id', '=', 'discuses.related_ids')
        ->leftJoin('assignments', 'assignments.id', '=', 'discuses.related_id')
        ->leftJoin('discusswithteams', 'discuses.id', '=', 'discusswithteams.discuss_id')
        ->leftJoin('discusesteammebers', 'discusesteammebers.discuss_id', '=', 'discuses.id')
        ->leftJoin('teammembers', 'teammembers.id', '=', 'discusesteammebers.teammember_id')
		->leftJoin('teammembers AS created_by', 'created_by.id', '=', 'discuses.createdby') // Join for createdby field     
        ->where('discuses.createdby', $request->teammember_id)
        ->select(
            'discuses.id',
            'discuses.topic',
            'discuses.relatedto',
            'discuses.other',
            'clients.client_name',
            'assignments.assignment_name',
			'discuses.created_at',
			'created_by.team_member AS createdby_name',
            DB::raw('GROUP_CONCAT(DISTINCT discusswithteams.teammember_ids) as teammember_ids'),
            DB::raw('GROUP_CONCAT(DISTINCT teammembers.team_member) as team_members')
        )
        ->groupBy('discuses.id','discuses.topic','discuses.relatedto','discuses.other','clients.client_name','assignments.assignment_name','discuses.created_at','createdby_name')
        ->get();
    
                }
    
          $discussDataArray = [];
    
    foreach ($discussDatas as $discussData) {
        $teammemberIds = explode(',', $discussData->teammember_ids);
        $teammemberNames = explode(',', $discussData->team_members);
    
        $discussDataArray[] = [
            'id' => $discussData->id,
            'topic' => $discussData->topic,
            'relatedto'=> $discussData->relatedto,
            'other' => $discussData->other,
			'created_at'=>$discussData->created_at,
			'createdby_name'=>$discussData->createdby_name,
            'client_name' => $discussData->client_name,
            'assignments' => $discussData->assignment_name,
            'discusswith' => $teammemberNames,
            'participate' => $teammemberNames,
			
        ];
    }
    
    return response()->json(['data' => $discussDataArray], 200);
      } catch (\Exception $e) {
            $response['result'] = "failed";
            $response['msg'] = "Something went wrong: " . $e->getMessage();
            $response['code'] = "500";
            Log::info(json_encode(["Error in Member Transaction API-----", $e->getMessage()]));
    
            return response()->json($response, 500);
        }
    }
	
	public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'title' => 'required',
          'discuss_with_id' => 'required',
          'relatedto' => 'required',
          'description' => 'required',
        ]);

  
        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
        
            return  response()->json($response);
        }
            try {
              
              $id = DB::table('discuses')->insertGetId([
                'topic' => $request->input('title'),
                'description' => $request->input('description'),
                'relatedto' => $request->input('relatedto'),
                'related_id' => $request->input('assignment_id'),
                'related_ids' => $request->input('related_ids'),
                'client_id' => $request->input('client_id'),
                'other' => $request->input('other'),
                'status' => $request->input('status'),
                'createdby' => $request->input('createdby'),
                'created_at' => now(),
            ]);
    
      //	dd($data );
            if ($request->has('participate_id')) {
                foreach ($request->input('participate_id') as $teammember) {
                    DB::table('discusesteammebers')->insert([
                        'discuss_id' => $id,
                        'teammember_id' => $teammember,
                        'created_at' => now(),
                    ]);
                }
            }
    
            if ($request->has('discuss_with_id')) {
                foreach ($request->input('discuss_with_id') as $teammembers) {
                    DB::table('discusswithteams')->insert([
                        'discuss_id' => $id,
                        'teammember_ids' => $teammembers,
                        'created_at' => now(),
                    ]);
                }
            }
                  if($id){
					  $discuses = DB::table('discuses')->where('id', $id)->first();
            $output = ['msg' => 'insert successfully'];
            return response()->json(['data' => $output, 'discuses' => $discuses, 'code' => '10001']);
                          }
          else {
			  
                    return response()->json(["msg" => "data not found", "code" => "404", "status" => "false"]);
        
              }
         

           } catch (\Exception $e) {
               $response['result'] = "failed";
               $response['msg'] = "Something went wrong ". $e->getMessage();
               $response['code'] = "500";
               Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
           }
        
           return response()->json($response);
        
            
          }
   
public function show(Request $request)
{
    $discuss = DB::table('discuses')
    ->leftJoin('clients', 'clients.id', '=', 'discuses.client_id')
     ->leftJoin('teammembers', 'teammembers.id', '=', 'discuses.createdby')
    ->where('discuses.id', $request->id)
    ->select('discuses.id','discuses.topic','discuses.other','teammembers.team_member','clients.client_name','discuses.created_at')
    ->first();
 // dd($discuss);
    $discusswith = DB::table('discusswithteams')
    ->leftJoin('teammembers', 'teammembers.id', '=', 'discusswithteams.teammember_ids')
    ->where('discusswithteams.discuss_id', $request->id)
    ->select('teammembers.team_member')
    ->get();
    $discussparticipate = DB::table('discusesteammebers')
    ->leftJoin('teammembers', 'teammembers.id', '=', 'discusesteammebers.teammember_id')
    ->where('discusesteammebers.discuss_id', $request->id)
    ->select('teammembers.team_member')
    ->get();
    $discusstopic = DB::table('discusstopics')
    ->leftJoin('teammembers', 'teammembers.id', '=', 'discusstopics.createdby')
    ->where('discuss_id', $request->id)
    ->select('discusstopics.discuss_topic','teammembers.team_member','teammembers.created_at')
    ->get();
    $discussDataArray = [];
    $discussDataArray[] = [
                'id' => $discuss->id,
                'topic' => $discuss->topic,
                'other' => $discuss->other,
				'created_at'=>$discuss->created_at,
                 'team_member' => $discuss->team_member,
                 'client_name' => $discuss->client_name,
                'discusstopic' => $discusstopic,
                'discusswith' => $discusswith,
                'participate' => $discussparticipate,
            ];

    return response()->json(['discuss' => $discussDataArray], 200);
}	
	
	public function discussupdate(Request $request)
{
    try {
        $ids = DB::table('discusstopics')->insertGetId([
            'discuss_id' => $request->input('discuss_id'),
            'discuss_topic' => $request->input('discuss_topic'),
            'createdby' => $request->input('createdby'),
            'updated_at' => now()
        ]);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('backEnd/image/discuss/', $filename);
            $attachment = $filename;
        } else {
            $attachment = '';
        }

        DB::table('discussattachements')->insert([
            'discuss_id' => $request->input('discuss_id'),
            'topic_id' => $ids,
            'attachment' => $attachment,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $output = array('msg' => 'Updated Successfully');
        return response()->json($output, 200);
    } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return response()->json($output, 500);
    }
}
	public function discussDelete(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id' => 'required',
    ]);

    if ($validator->fails()) {
        $response['msg'] = $validator->errors();
        $response['status'] = 0;

        return response()->json($response, 400);
    }

    try {
       
        DB::table('discusstopics')->where('id', $request->id)->delete();

        DB::table('discussattachements')->where('topic_id', $request->id)->delete();
        
        $output = ['msg' => 'Deleted Successfully'];
        return response()->json(['success' => true, 'message' => $output]);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = ['msg' => $e->getMessage()];
        return response()->json(['success' => false, 'error' => $output], 500);
    }
}
public function editUpdate(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['success' => false, 'errors' => $errors], 400);
        }

        DB::table('discusstopics')->where('id', $request->id)->update([
            'discuss_topic' => $request->description
        ]);

        $output = ['msg' => 'Submit Successfully'];
        return response()->json(['success' => true, 'message' => $output]);
    } catch (\Exception $e) {
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = ['msg' => $e->getMessage()];
        return response()->json(['success' => false, 'error' => $output], 500);
    }
}
}
