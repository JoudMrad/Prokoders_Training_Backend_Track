<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Http\Requests\AttachPostRequest;
use App\Services\TopicService;
use Illuminate\Http\Request;
use App\Models\Topic; 

class TopicController extends Controller
{
    protected $topicService;

    public function __construct(TopicService $topicService)
    {
        $this->topicService = $topicService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        return $this->topicService->getAllTopics($perPage);
    }

    public function store(StoreTopicRequest $request)
    {
        return $this->topicService->createTopic($request->validated());
    }

    public function show(Topic $topic) 
    {
        return $this->topicService->getTopic($topic);
    }

    public function update(UpdateTopicRequest $request, Topic $topic) 
    {
        return $this->topicService->updateTopic($topic, $request->validated());
    }

    public function destroy(Topic $topic) 
    {
        $this->topicService->deleteTopic($topic);
        return response()->json(null, 204);
    }

    public function attachPost(AttachPostRequest $request, Topic $topic) 
    {
        $topic = $this->topicService->attachPostToTopic($topic, $request->post_id);
        
        return response()->json([
            'message' => 'تم ربط المقال بالموضوع بنجاح', 
            'topic' => $topic
        ]);
    }

    public function detachPost(AttachPostRequest $request, Topic $topic) 
    {
        $topic = $this->topicService->detachPostFromTopic($topic, $request->post_id);
        
        return response()->json([
            'message' => 'تم فصل المقال عن الموضوع بنجاح', 
            'topic' => $topic
        ]);
    }
}