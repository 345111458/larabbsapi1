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
    //
}
