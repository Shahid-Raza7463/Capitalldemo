<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Knowledgebase;
use Illuminate\Http\Request;
use App\Models\Teammember;
use DB;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function __construct()
    {
        $this->middleware('auth');
    }
    public function articleIndex($id)
    {
        $articleDatas=DB::table('articles')
        ->join('knowledgebases','knowledgebases.id','articles.related_to')
        ->join('teammembers','teammembers.id','articles.created_by')
        ->where('articles.related_to',$id)
        ->select('articles.*','teammembers.team_member','knowledgebases.name')->get();
        return view('backEnd.article.index',compact('articleDatas','id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function articleCreate($id)
    {
        $knowledgebase = Knowledgebase::where('id',$id)->first();
        return view('backEnd.article.create',compact('id','knowledgebase'));
    }
    public function articleView($id)
    {
        //echo $id;die;
       $article = DB::table('articles')
       ->join('knowledgebases','knowledgebases.id','articles.related_to')->
       where('articles.id',$id)->first();
       //echo $article;die;
        return view('backEnd.article.view',compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
         // $request->validate([
         //     'title' => "required",
         //     'team_member' => "required"
         // ]);
 
         try {
               $authid = auth()->user()->teammember_id;
              // dd($authid );
             $data=$request->except(['_token']);
             $data['created_by'] = $authid;
             $data['updated_by'] = $authid;
             $data['date'] =   date('Y-m-d H:i:s');
             if($request->hasFile('file'))
             {
                $file=$request->file('file');
                  $filename = $file->getClientOriginalName();
                 $file->move('backEnd/image/article/',$filename);
                 $data['file']=$filename;
             }
            Article::create($data);
              
             $output = array('msg' => 'Create Successfully');
             return back()->with('success', $output);
         } catch (Exception $e) {
             DB::rollBack();
             Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
             report($e);
             $output = array('msg' => $e->getMessage());
             return back()->withErrors($output)->withInput();
         }
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        $article = Article::where('id', $id)->first();
        return view('backEnd.article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
       // dd($id);
        try {
            $authid = auth()->user()->teammember_id;
          $data=$request->except(['_token']);
          $article_id=	DB::table('articles')->where('id',$id)->update([			
              'subject'         => $request->subject,
              'related_to'   =>$request->related_to,
              'description'         => $request->description,
               'created_by'  => $authid,
               'updated_by'  => $authid,
               'date'                     =>    date('Y-m-d H:i:s'),
              'created_at'			    =>	   date('Y-m-d H:i:s'),
              'updated_at'               =>    date('Y-m-d H:i:s'),
              ]);
           
          $output = array('msg' => 'updated Successfully');
          return back()->with('success', $output);
      } catch (Exception $e) {
          DB::rollBack();
          Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
          report($e);
          $output = array('msg' => $e->getMessage());
          return back()->withErrors($output)->withInput();
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      //  dd($id);
        try {
            Article::destroy($id);
            $output = array('msg' => 'Deleted Successfully');
            return back()->with('statuss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
}
