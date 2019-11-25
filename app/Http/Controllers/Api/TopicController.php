<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Http\Requests\Api\TopicRequest;
use App\Http\Resources\TopicResource;



class TopicController extends Controller
{
    //发布话题；
    public function store(TopicRequest $request , Topic $topic){

        $topic->fill($request->all());
        $topic->user_id = $request->user()->id;
        $topic->save();

        return new TopicResource($topic);
    }

    // 修改话题
    public function update(TopicRequest $request,Topic $topic){
        $this->authorize('update',$topic);

        $topic->update($request->all());
        return new TopicResource($topic);
    }

    // 删除话题
    public function destroy(Topic $topic){
        $this->authorize('update',$topic);

        $topic->delete();
        return new response($topic,203);
    }
    //
}
