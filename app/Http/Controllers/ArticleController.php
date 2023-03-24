<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
  public function store(Request $request)
  {
    DB::beginTransaction();

    $request->validate(
    [
        'title' => ['required', 'string', 'max:255'],
        'content' => ['required', 'string'],
    ]);

    $data = new Articles;
    $data->title = $request->title;
    $data->content = $request->content;
    
    try{
      $data->save();
      DB::commit();
      return response()->json(['message'=> 'Successfully Saved']);
    }
    catch(\Error $th){
      return response()->json(['message'=> $th->getMessage()], 422);
    }
  }

  public function update(Request $request)
  {
    DB::beginTransaction();

    $request->validate(
    [
        'title' => ['required', 'string', 'max:255'],
        'content' => ['required', 'string'],
    ]);

    $data = Articles::find($request->id);
    $data->title = $request->title;
    $data->content = $request->content;
    
    try{
      $data->save();
      DB::commit();
      return response()->json(['message'=> 'Successfully Saved']);
    }
    catch(\Error $th){
      return response()->json(['message'=> $th->getMessage()], 422);
    }
  }

  public function show()
  {
    $res = [];
    $data = Articles::all();
    foreach ($data as $v) {
        $res[] = [
            'id' => $v->id,
            'creator' => $v->creator,
            'title' => $v->title,
            'content' => $v->content,
            'likes' => $v->likes,
            'unlikes' => $v->unlikes,
            'created_at' => Date('M-d-Y h:i a', strtotime($v->created_at)),
        ];
    }
    return response()->json($res);
  }

  public function delete(Request $request)
  {
    $data = Articles::where($request->id)->delete();
    return response()->json($data);
  }


  
  public function likeArticle(Request $request)
  {
    DB::beginTransaction();

    $data = Articles::find($request->id);

    if($data->likes == null )
    {
        $likes = 0;
    }
    else{
        $likes = $data->likes;
    }
    $data->likes = (int)$likes + 1;
    try{
      $data->save();
      DB::commit();
      return response()->json(['message'=> 'Successfully Saved']);
    }
    catch(\Error $th){
      return response()->json(['message'=> $th->getMessage()], 422);
    }
  }

  public function unlikeArticle(Request $request)
  {
    DB::beginTransaction();

    $data = Articles::find($request->id);
    $data->unlikes = (int)$data->unlikes - 1;
    try{
      $data->save();
      DB::commit();
      return response()->json(['message'=> 'Successfully Saved']);
    }
    catch(\Error $th){
      return response()->json(['message'=> $th->getMessage()], 422);
    }
  }



}
