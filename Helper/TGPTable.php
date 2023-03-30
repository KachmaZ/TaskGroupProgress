<?php

namespace Kanboard\Plugin\TaskGroupProgress\Helper;

use Kanboard\Core\Base;

class TGPTable extends Base
{
    public function create($data, $categoryId, $columns, $tagIds, $projectId)
    {
        $tags = [];

        foreach ($tagIds as $id) {
            $newTag = $this->tagModel->getById($id);
            unset($newTag['project_id']);
            $tags[] = $newTag;
        }

        $html = '';
        if ((bool) $columns & (bool) $tags) {
            $html .= "<h2>{$this->categoryModel->getNameById($categoryId)}</h2> <table>";
            $html .= $this->tableHead($columns);
            $html .= $this->tableBody($data, $tags, $columns, $categoryId, $projectId);
            $html .= '</table>';
        }
        return $html;
    }

    private function tableHead($columns)
    {
        $html = "<thead><th>Tags</th><th>Total</th>";
        foreach ($columns as $column) {
            $html .= "<th>{$column}</th>";
        }
        $html .= "<th>Progress</th></thead>";
        return $html;
    }

    private function tableBody($data, $tags, $columns, $categoryId, $projectId)
    {
        $sortedTasks = [];
        foreach ($tags as $tag) {
            $tasksByTag = [];
            foreach ($data as $task) {
                if (in_array($tag, $this->taskTagModel->getTagsByTask($task['id']))) {
                    $tasksByTag[] = $task;
                }
            }
            $sortedTasks[$tag['name']] = $tasksByTag;
        }
        $html = "<tbody>";
        foreach ($tags as $tag) {
            $html .= $this->tableRow($tag, $sortedTasks, $columns, $projectId);
        }
        $html .= "</tbody>";
        return $html;
    }

    private function tableRow($tag, $sortedTasks, $columns, $projectId)
    {
        $html = "<tr><td>{$tag['name']}</td><td>"
            . sizeof($sortedTasks[$tag['name']])
            . '</td>';
        foreach ($columns as $column) {
            $html .= '<td>'
                . sizeof(array_filter(
                    $sortedTasks[$tag['name']],
                    fn ($task) => $task['column_id'] == $this->columnModel->getColumnIdByTitle($projectId, $column)
                ))
                . '</td>';
        }

        $html .= $this->calcPercent($tag, $sortedTasks, $projectId);

        return $html;
    }

    private function calcPercent($tag, $sortedTasks, $projectId)
    { 
        $total = $sortedTasks[$tag['name']];
        $done = array_filter($total, fn ($task) => $task['column_id'] == $this->columnModel->getColumnIdByTitle($projectId, 'Done'));
        if (sizeof($total) != 0) {
            $progress = sizeof($done) / sizeof($total) * 100;
        }
        else {
            $progress = 0;
        }
        return '<td>' . floor($progress * 100) / 100 . '%</td>';
    }
}
