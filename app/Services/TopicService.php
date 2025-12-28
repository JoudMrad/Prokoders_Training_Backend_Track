<?php

namespace App\Services;

use App\Models\Topic;
use Illuminate\Support\Str;
use App\Http\Resources\TopicResource;
use App\Http\Resources\TopicCollection;

class TopicService
{
    
    public function getAllTopics(int $perPage = 10): TopicCollection
    {
        $topics = Topic::withCount('posts')->paginate($perPage);
        return new TopicCollection($topics);
    }
    
    public function getTopic(Topic $topic): TopicResource
    {
        $topic->load('posts');
        return new TopicResource($topic);
    }

    public function createTopic(array $data): TopicResource
    {
        $data['slug'] = Str::slug($data['name']);
        $topic = Topic::create($data);
        return new TopicResource($topic);
    }
    
    public function updateTopic(Topic $topic, array $data): TopicResource
    {
        if (isset($data['name']) && $data['name'] !== $topic->name) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        $topic->update($data);
        return new TopicResource($topic);
    }
    
    public function deleteTopic(Topic $topic): void
    {
        $topic->delete();
    }
    
    public function attachPostToTopic(Topic $topic, int $postId): TopicResource
    {
        $topic->posts()->syncWithoutDetaching([$postId]);
        $topic->load('posts');
        return new TopicResource($topic);
    }
    
    public function detachPostFromTopic(Topic $topic, int $postId): TopicResource
    {
        $topic->posts()->detach($postId);
        $topic->load('posts');
        return new TopicResource($topic);
    }
}