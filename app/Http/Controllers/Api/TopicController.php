<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\User;
use App\Http\Requests\Api\TopicRequest;
use App\Http\Resources\TopicResource;
use App\Http\Queries\TopicQuery;



class TopicController extends Controller
{
    // 话题列表
    public function index(Request $request, Topic $topic, TopicQuery $query){
//        $query = $topic->query();
//        if ($categoryId = $request->category_id) {
//            $query->where('category_id', $categoryId);
//        }
//        $topics = $query->with('user','category')->withOrder($request->order)->paginate(2);

        // 使用 Include 机制进行查询
//        $topics = QueryBuilder::for(Topic::class)
//            ->allowedIncludes('user','category')
//            ->allowedFilters([
//                'title',
//                AllowedFilter::exact('category_id'),
//                AllowedFilter::scope('withOrder')->default('recentReplied'),
//            ])->paginate(2);

        // 封装 TopicQuery trait 后的调用
        $topics = $query->paginate(2);

        return TopicResource::collection($topics);
    }

    // 某个用户发布的话题
    public function userIndex(Request $request , User $user , TopicQuery $query){
        $topics = $query->whereUserId($user->id)->paginate(2);

        return TopicResource::collection($topics);
    }

    // 话题详情
    public function show($topicId , TopicQuery $query){

        $topics = $query->findOrFail($topicId);

        return new TopicResource($topics);
    }

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
        return response(null,204);
    }
    //
}
