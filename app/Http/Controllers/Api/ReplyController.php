<?php

namespace App\Http\Controllers\Api;

use App\Http\Queries\ReplyQuery;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Topic;
use App\Http\Requests\Api\ReplyRequest;
use App\Http\Resources\ReplyResource;



class ReplyController extends Controller
{
    //某个话题的回复列表
    public function index($topicId,ReplyQuery $query){
        $replies = $query->whereTopicId($topicId)->paginate(2);

        return ReplyResource::collection($replies);
    }


    //某个用户回复列表
    public function userIndex($userId,ReplyQuery $query){
        $replies = $query->where('user_id',$userId)->paginate(10);

        return ReplyResource::collection($replies);
    }


    // 创建回复
    public function store(ReplyRequest $request,Topic $topic,Reply $reply){
        $reply->content = $request->content;
        $reply->topic()->associate($topic);
        $reply->user()->associate($request->user());
        $reply->save();
        return new ReplyResource($reply);
    }

    //删除回复
    public function destroy(Topic $topic,Reply $reply){
        if ($reply->topic_id != $topic->id){
            abort(404);
        }
        try{
            $this->authorize('destroy',$reply);
        }catch(\Exception $e){
            abort(403,'没有操作权项');
            //throw new AuthenticationException('没有操作权项');
        }
        $reply->delete();
        return response(null,204);
    }
}
