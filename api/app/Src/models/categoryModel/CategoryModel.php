<?php

namespace App\Src\models\categoryModel;

use App\Src\models\meetingListModel\MeetingListModel;
use Illuminate\Support\Collection;

class CategoryModel
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Collection
     */
    private $tasks;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var MeetingListModel
     */
    private $meeting;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Collection
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    /**
     * @param Collection $tasks
     */
    public function setTasks(Collection $tasks): void
    {
        $this->tasks = $tasks;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return MeetingListModel
     */
    public function getMeeting(): MeetingListModel
    {
        return $this->meeting;
    }

    /**
     * @param MeetingListModel $meeting
     */
    public function setMeeting(MeetingListModel $meeting): void
    {
        $this->meeting = $meeting;
    }
}