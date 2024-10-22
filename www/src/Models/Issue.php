<?php 
namespace Opt\RedmineReports\Models;

use DateTime;
use Opt\RedmineReports\Controllers\SprintController;
use Opt\RedmineReports\Models\Sprint;
use Opt\RedmineReports\Services\RedMine;

class Issue {
    
    public $id;
    public $project;
    public $tracker;
    public $status;
    public $priority;
    public $author;
    public $assigned_to;
    public $fixed_version;
    public $subject;
    public $description;
    public $start_date;
    public $due_date;
    public $done_ratio;
    public $is_private;
    public $estimated_hours;
    public $total_estimated_hours;
    public $custom_fields;
    public $created_on;
    public $updated_on;
    public $closed_on;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->project = $data['project'];
        $this->tracker = $data['tracker'];
        $this->status = $data['status'];
        $this->priority = $data['priority'];
        $this->author = $data['author'];
        $this->assigned_to = $data['assigned_to'];
        $this->fixed_version = $data['fixed_version'];
        $this->subject = $data['subject'];
        $this->description = $data['description'];
        $this->start_date = $data['start_date'];
        $this->due_date = $data['due_date'];
        $this->done_ratio = $data['done_ratio'];
        $this->is_private = $data['is_private'];
        $this->estimated_hours = $data['estimated_hours'];
        $this->total_estimated_hours = $data['total_estimated_hours'];
        $this->custom_fields = $data['custom_fields'];
        $this->created_on = $data['created_on'];
        $this->updated_on = $data['updated_on'];
        $this->closed_on = $data['closed_on'];
    }

    public static function fromSprint(Sprint $sprint) {
        $query = "project_id=$sprint->project_id&" . $sprint->id ? "sort=closed_on" : "status_id=open"; 
        $response = (new RedMine())->issues($query); 
        $reserved = [];
        
        if (!$sprint->id) {
            foreach (SprintController::listAll() as $createdSprint) {
                foreach ($createdSprint->getIssuesId() as $issueId) {
                    $reserved[$issueId] = $issueId;
                }
            }
        }

        foreach ($response as $issue) {
            if ($sprint->id && $sprint->hasIssue($issue->id)) {
                yield new self((array) $issue);
                continue;
            }

            if (in_array($issue->id, $reserved))
                yield new self((array) $issue);
        }
    }

    public function getAuthorName() {
        if (isset($this->author->name))
            return $this->author->name;

        return '';
    }

    public function getResponsibleName() {
        if (isset($this->assigned_to->name))
            return $this->assigned_to->name;

        return '';
    }

    public function getClosedOn() {
        return new DateTime($this->closed_on);
    }

    public function getDueDate() {
        return new DateTime($this->due_date);
    }
}

?>