<?php 
function _get($param) {
    return isset($_GET[$param]) ? $_GET[$param] : '';
}

function generateBurndownData($sprint) {
    if (!$sprint->issues)
        return [];


    $startDate = new DateTime($sprint->start);
    $endDate = new DateTime($sprint->end);
    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($startDate, $interval, $endDate);

    $labels = [];
    $data = [];

    foreach ($period as $date) {
        $labels[] = $date->format('Y-m-d');
        $data[$date->format('Y-m-d')] = 0;
    }

    foreach ($sprint->issues as $issue) {
        
        if (isset($issue->closed_on)) {
            $closedDate = new DateTime($issue->closed_on);
            $closedDateStr = $closedDate->format('Y-m-d');
            if (isset($data[$closedDateStr])) {
                $data[$closedDateStr] += 1;
            }
        }
    }

    $cumulativeData = [];
    $totalIssues = $linearIssueCount = count($sprint->issues);

    foreach ($labels as $label) {
        $burndownLinear[] = $linearIssueCount;
        $cumulativeData[] = $totalIssues;

        $totalIssues -= $data[$label];
        
        if ($linearIssueCount > 0)
            $linearIssueCount--;
        
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
                'label' => 'Burndown Linear',
                'data' => $burndownLinear,
                'fill' => false,
                'borderColor' => 'rgb(100, 100, 192)',
                'tension' => 0.1
            ]
        ]
    ];
}

function generateBurnupData($sprint) {
    if (!$sprint->issues)
        return [];


    $startDate = new DateTime($sprint->start);
    $endDate = new DateTime($sprint->end);
    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($startDate, $interval, $endDate);

    $labels = [];
    $data = [];

    foreach ($period as $date) {
        $labels[] = $date->format('Y-m-d');
        $data[$date->format('Y-m-d')] = 0;
    }

    foreach ($sprint->issues as $issue) {
        
        if (isset($issue->closed_on)) {
            $closedDate = new DateTime($issue->closed_on);
            $closedDateStr = $closedDate->format('Y-m-d');
            if (isset($data[$closedDateStr])) {
                $data[$closedDateStr] += 1;
            }
        }
    }

    $cumulativeData = [];
    $totalIssues = $linearIssueCount = 0;

    foreach ($labels as $label) {
        $burndownLinear[] = $linearIssueCount;
        $cumulativeData[] = $totalIssues;
        
        $totalIssues += $data[$label];

        if ($linearIssueCount <= count($sprint->issues))
            $linearIssueCount++;
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
                'label' => 'Burndown Linear',
                'data' => $burndownLinear,
                'fill' => false,
                'borderColor' => 'rgb(100, 100, 192)',
                'tension' => 0.1
            ]
        ]
    ];
}
?>