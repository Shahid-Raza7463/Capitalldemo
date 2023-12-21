<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Teammember;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;
use Log;
use DB;
class KnowledgebaseController extends Controller
{
  
    public function knowledgebaseList()
    {
            try {
              $result = DB::table('articles')
              ->leftjoin('knowledgebases','knowledgebases.id','articles.related_To')
              ->leftjoin('teammembers','teammembers.id','articles.created_by')
              ->select('articles.subject','articles.id','articles.description'
              ,'articles.date','articles.file','teammembers.team_member','knowledgebases.name')->get();
 
  foreach($result as $res)
              {
                $res->file = url('backEnd/image/article/'.$res->file);
               
              }
              
              if($result->isEmpty()){
             
                return response()->json(["msg"=>"data not found","code" =>"404","status" =>"false"]);
                          }
          else {
            return response()->json(["output" => $result,"status" =>"true","code" =>"10001"]);
          }
         

           } catch (\Exception $e) {
               $response['result'] = "failed";
               $response['msg'] = "Something went wrong ". $e->getMessage();
               $response['code'] = "500";
               Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
           }
        
           return response()->json($response);
        
            
          }
   
}
