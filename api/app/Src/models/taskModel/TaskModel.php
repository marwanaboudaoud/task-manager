<?php
/**
 * Created by PhpStorm.
 * User: Bpoul
 * Date: 11-4-2019
 * Time: 11:11
 */

namespace App\Src\models\taskModel;


use App\Src\models\categoryModel\CategoryModel;
use App\Src\models\meetingListModel\MeetingListModel;
use App\Src\models\userModels\UserModel;

class TaskModel
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $deadline;

    /**
     * @var UserModel
     */
    private $assignee;

    /**
     * @var CategoryModel
     */
    private $category;

    /**
     * @var MeetingListModel
     */
    private $meeting;

    /**
     * @var boolean
     */
    private $isCompleted;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return null|string
     */
    public function getDeadline(): ?string
    {
        return $this->deadline;
    }

    /**
     * @param null|string $deadline
     */
    public function setDeadline(?string $deadline): void
    {
        $this->deadline = $deadline;
    }

    /**
     * @return UserModel|null
     */
    public function getAssignee(): ?UserModel
    {
        return $this->assignee;
    }

    /**
     * @param UserModel|null $user
     */
    public function setAssignee(?UserModel $user): void
    {
        $this->assignee = $user;
    }

    /**
     * @return CategoryModel
     */
    public function getCategory(): CategoryModel
    {
        return $this->category;
    }

    /**
     * @param CategoryModel $category
     */
    public function setCategory(CategoryModel $category): void
    {
        $this->category = $category;
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

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->isCompleted;
    }

    /**
     * @param bool $isCompleted
     */
    public function setIsCompleted(bool $isCompleted): void
    {
        $this->isCompleted = $isCompleted;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

}