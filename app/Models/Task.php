<?php

namespace App\Models;

use App\Traits\AddingCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class Task extends Model
{
    use AddingCompany;
    protected $fillable = [
        'date', 'description', 'created_by', 'updated_by', 'name', 'company_id', 'status', 'remarks', 'feedback'
    ];

    protected $dates = [
        'date'
    ];

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = flipDate($date);
    }

    public function status()
    {
        switch ($this->status){
            case 'pending':
                return $this->statusAttr('warning');
                break;
            case 'in-progress':
                return $this->statusAttr('info');
                break;
            case 'completed':
                return $this->statusAttr('teal');
                break;
            case 'canceled':
                return $this->statusAttr('danger');
                break;

        }

    }

    protected function statusAttr($textClass)
    {
        $signal = ucfirst($this->status);
        return new HtmlString("<span class=\"badge badge-default\"><i class='fa fa-check-circle text-$textClass'></i> $signal</span>");
    }


    public function calenderModal()
    {
        $signal = ucfirst($this->status);
        $taskName = "<h5><b>Task Name</b> : $this->name</h5>";
        $taskDescription = "<h5><b>Description</b> : $this->description</h5>";

        return new HtmlString($taskName.$taskDescription."<h5><b>Status</b> : $signal</h5> <hr> <a href=\'tasks\' class=\'btn btn-success\'>View Task</a>");
    }

    public function getUnixDateAttribute()
    {
        return mktime(
            0,
            0,
            0,
            $this->date->format('m'),
            $this->date->format('d'),
            $this->date->format('Y')
        );
    }
}
