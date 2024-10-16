<?php 
namespace Opt\RedmineReports\Models;

use DateInterval;
use DatePeriod;
use DateTime;
use Opt\RedmineReports\Models\Issue;

class Sprint {
    
    public  $id;
    public  $start;
    public  $end;
    public  $issues;
    public  $project_id;

    const SPRINTS = [
        ['id' => 0, 'project_id' => 8, 'desc' => 'Sprint 1 - Credenciamento', 'start' => '2024-03-22', 'end' => '2024-04-05'],
        ['id' => 1, 'project_id' => 8, 'desc' => 'Sprint 2 - Correções e Ajustes', 'start' => '2024-04-10', 'end' => '2024-04-18'],
        ['id' => 2, 'project_id' => 8, 'desc' => 'Sprint 3 - Inscrição, Submissão e Homologação', 'start' => '2024-04-22', 'end' => '2024-05-17'],
        ['id' => 3, 'project_id' => 8, 'desc' => 'Sprint 4 - Ajustes para Implantação', 'start' => '2024-05-20', 'end' => '2024-06-07'],
    ];

    public function __construct($attributes = []) {
        $this->id = $attributes['id'];
        $this->start = $attributes['start'];
        $this->end = $attributes['end'];
        $this->project_id = $attributes['project_id'];
    }

    public static function id($id = 0) {
        return new Self(self::SPRINTS[$id]);
    }

    public function getDuration() {
        $start = new \DateTime($this->start);
        $end = new \DateTime($this->end);
        return $start->diff($end)->format('%a days');
    }

    public function loadIssues() {
        foreach (Issue::fromSprint($this) as $issue) {
            $this->issues[] = $issue;
        }
    }

    function burndownData() {
        if (!$this->issues)
            return [];

        $startDate = new DateTime($this->start);
        $endDate = new DateTime($this->end);
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($startDate, $interval, $endDate);
    
        $labels = [];
        $data = [];
        $totalIssues = count($this->issues);
    
        foreach ($period as $date) {    
            $labels[] = $date->format('Y-m-d');
            $data[$date->format('Y-m-d')] = 0;
        }
    
        foreach ($this->issues as $issue) {
            if (isset($issue->closed_on)) {
                $closedDate = new DateTime($issue->closed_on);
                $closedDateStr = $closedDate->format('Y-m-d');
                if (isset($data[$closedDateStr])) {
                    $data[$closedDateStr] += 1;
                }
            }
        }
    
        $cumulativeData = [];
        $totalRemaining = $totalIssues;
    
        foreach ($labels as $label) {
            $totalRemaining -= $data[$label];
            $cumulativeData[] = $totalRemaining;
        }
    
        // Calculate linear burndown
        $daysCount = count($labels);
        $linearBurndown = [];
        $linearStep = $totalIssues / ($daysCount - 1);
    
        for ($i = 0; $i < $daysCount; $i++) {
            $linearBurndown[] = $totalIssues - $linearStep * $i;
        }
    
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Burndown',
                    'data' => $cumulativeData,
                    'fill' => false,
                    'borderColor' => 'rgb(75, 192, 192)',
                    'tension' => 0.1
                ],
                [
                    'label' => 'Linear Burndown',
                    'data' => $linearBurndown,
                    'fill' => false,
                    'borderColor' => 'rgb(255, 99, 132)',
                    'borderDash' => [5, 5],
                    'tension' => 0.1
                ]
            ]
        ];
    }

    function burnupData() {
        if (!$this->issues)
            return [];
        
        $startDate = new DateTime($this->start);
        $endDate = new DateTime($this->end);
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($startDate, $interval, $endDate);
    
        $labels = [];
        $data = [];
        $totalIssues = count($this->issues);
    
        foreach ($period as $date) {
            $labels[] = $date->format('Y-m-d');
            $data[$date->format('Y-m-d')] = 0;
        }
    
        foreach ($this->issues as $issue) {
            if (isset($issue->closed_on)) {
                $closedDate = new DateTime($issue->closed_on);
                $closedDateStr = $closedDate->format('Y-m-d');
                if (isset($data[$closedDateStr])) {
                    $data[$closedDateStr] += 1;
                }
            }
        }
    
        $cumulativeData = [];
        $totalCompleted = 0;
    
        foreach ($labels as $label) {
            $totalCompleted += $data[$label];
            $cumulativeData[] = $totalCompleted;
        }
    
        // Calculate linear burnup
        $daysCount = count($labels);
        $linearBurnup = [];
        $linearStep = $totalIssues / ($daysCount - 1);
    
        for ($i = 0; $i < $daysCount; $i++) {
            $linearBurnup[] = $linearStep * $i;
        }
    
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Burnup',
                    'data' => $cumulativeData,
                    'fill' => false,
                    'borderColor' => 'rgb(75, 192, 192)',
                    'tension' => 0.1
                ],
                [
                    'label' => 'Linear Burnup',
                    'data' => $linearBurnup,
                    'fill' => false,
                    'borderColor' => 'rgb(255, 99, 132)',
                    'borderDash' => [5, 5],
                    'tension' => 0.1
                ]
            ]
        ];
    }
}

?>