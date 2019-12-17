<?php

namespace App\Src\models\meetingListModel;

use App\Src\models\categoryModel\CategoryModel;
use App\Src\models\userModels\UserModel;
use Illuminate\Support\Collection;

class MeetingListModel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var UserModel
     */
    private $creator;

    /**
     * @var Collection
     */
    private $categories;

    /**
     * @var bool
     */
    private $isArchived;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var Collection
     */
    private $attendees;

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
     * @return UserModel
     */
    public function getCreator(): UserModel
    {
        return $this->creator;
    }

    /**
     * @param UserModel $creator
     */
    public function setCreator(UserModel $creator): void
    {
        $this->creator = $creator;
    }

    /**
     * @return bool
     */
    public function isArchived(): bool
    {
        return $this->isArchived;
    }

    /**
     * @param bool $isArchived
     */
    public function setIsArchived(bool $isArchived): void
    {
        $this->isArchived = $isArchived;
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

    /**
     * @return Collection
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @param Collection $categories
     */
    public function setCategories(Collection $categories): void
    {
        $this->categories = $categories;
    }

    /**inb
     * @return Collection
     */
    public function getAttendees(): Collection
    {
        return $this->attendees;
    }

    /**
     * @param Collection $attendees
     */
    public function setAttendees(Collection $attendees): void
    {
        $this->attendees = $attendees;
    }
}
