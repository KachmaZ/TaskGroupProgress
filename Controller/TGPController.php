<?php

namespace Kanboard\Plugin\TaskGroupProgress\Controller;

use Kanboard\Controller\AnalyticController;

class TGPController extends AnalyticController
{
    function getProgress()
    {
        $projectId = $this->request->getStringParam('project_id');

        $projectCategories = $this->categoryModel->getList($projectId);
        $projectTags = $this->tagModel->getAllByProject($projectId);

        foreach ($this->tagModel->getAllByProject($projectId) as $tag) {
            $projectTagNames[] = $tag['name'];
        }

        $columns = $this->columnModel->getList($projectId);

        $requestParams = $this->request->getValues();

        if (
            array_key_exists('tags', $requestParams) &
            array_key_exists('category', $requestParams)
        ) {
            [
                'category' => $chosenCategory,
                'tags' => $chosenTags,
                // 'from' => $from,
                // 'to' => $to
            ] = $requestParams;
        } else {
            $chosenCategory = '';
            $chosenTags = [];

            // $from = date('d-m-Y');
            // $to = date('d-m-Y');
        }

        $data = $this->helper->filter->getData($projectId, $chosenCategory, $chosenTags);

        $this->response->html($this->helper->layout->analytic('taskGroupProgress:task_group_progress', array(
            'project' => $this->getProject($projectId),
            'title' => t('Progress'),

            'categories' => $projectCategories,
            'tags' => $projectTags,
            'tagNames' => $projectTagNames,
            // 'values' => array(
            //     $from,
            //     $to,
            // ),

            'data' => $data,
            'columns' => $columns,
            'chosenCategory' => $chosenCategory,
            'chosenTags' => $chosenTags
        )));
    }
}
