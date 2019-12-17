<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meetingList()
    {
        return $this->belongsTo('App\MeetingList');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany('App\Task')->orderBy('is_completed', 'ASC')->orderBy('deadline', 'ASC')->orderBy('title', 'ASC');
    }
}
