<?php

namespace Kanboard\Plugin\TaskGroupProgress\Helper;

use Kanboard\Core\Base;

class TGPFilter extends Base
{
    /**
     * 
     *
     * @access public
     * @param array
     * @param array 
     */
    public function getData($projectId, $categoryId, $tags)
    {
        $data = $this->taskFinderModel->getAll($projectId);

        foreach ($data as $key => $task) {
            if (!$this->hasCategory($task, $categoryId) || 
            !$this->hasTag($task, $tags)) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * 
     *
     * @access private
     * @param 
     * @param 
     */
    private function hasCategory($task, $categoryId)
    {
        if ($task['category_id'] == $categoryId) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 
     *
     * @access private
     * @param 
     * @param 
     */
    private function hasTag($task, $tagIds)
    {
        $taskTags = $this->taskTagModel->getTagsByTask($task['id']);

        $filterTags = [];
        foreach ($tagIds as $tagId) {
            $filterTags[] = $this->tagModel->getById($tagId);
        }
        
        if ($this->tagCheck($filterTags, $taskTags)) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * Method for detecting tasks and filter tags intersection
     *
     * @access private
     * @param array $filterTags
     * @param array $taskTags
     */
    private function tagCheck($filterTags, $taskTags) {
        $checkArray = array_merge($filterTags, $taskTags);
        $checkArray = array_map(fn($item)=>$item['id'], $checkArray);
        
        if (sizeof($checkArray) == sizeof(array_unique($checkArray))){
            return false;
        }
        else {
            return true;
        }
    }
}
