<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeetingList extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany('App\Category')->orderBy('name', 'ASC');
    }

    /**
     * This is the pivot relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attendees()
    {
        return $this->belongsToMany('App\User', 'meeting_list_member')
            ->as('attendees')
            ->withTimestamps();
    }

    /**
     * This is the user that created the table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'creator_id');
    }
}
