<?php

namespace App\Models;

use CodeIgniter\Model;

class AnnouncementModel extends Model
{
    protected $table = 'class_announcements';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['class_id', 'sub_class_id', 'is_general', 'user_id', 'title', 'content'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get all announcements for a specific class
     */
    public function getByClass($classId)
    {
        return $this->select('class_announcements.*, users.full_name as author_name')
            ->join('users', 'users.id = class_announcements.user_id')
            ->where('class_id', $classId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get announcement with author info
     */
    public function getWithAuthor($id)
    {
        return $this->select('class_announcements.*, users.full_name as author_name, users.role as author_role')
            ->join('users', 'users.id = class_announcements.user_id')
            ->where('class_announcements.id', $id)
            ->first();
    }

    /**
     * Get announcement with comment count
     */
    public function getByClassWithCommentCount($classId)
    {
        return $this->select('class_announcements.*, users.full_name as author_name, COUNT(announcement_comments.id) as comment_count')
            ->join('users', 'users.id = class_announcements.user_id')
            ->join('announcement_comments', 'announcement_comments.announcement_id = class_announcements.id', 'left')
            ->where('class_id', $classId)
            ->groupBy('class_announcements.id')
            ->orderBy('class_announcements.created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get announcements for a specific sub class
     */
    public function getBySubClass($subClassId)
    {
        return $this->select('class_announcements.*, users.full_name as author_name')
            ->join('users', 'users.id = class_announcements.user_id')
            ->where('sub_class_id', $subClassId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get general announcements for a main class
     */
    public function getGeneralByClass($classId)
    {
        return $this->select('class_announcements.*, users.full_name as author_name')
            ->join('users', 'users.id = class_announcements.user_id')
            ->where('class_id', $classId)
            ->where('is_general', 1)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get sub class announcements with comment count
     */
    public function getBySubClassWithCommentCount($subClassId)
    {
        return $this->select('class_announcements.*, users.full_name as author_name, COUNT(announcement_comments.id) as comment_count')
            ->join('users', 'users.id = class_announcements.user_id')
            ->join('announcement_comments', 'announcement_comments.announcement_id = class_announcements.id', 'left')
            ->where('sub_class_id', $subClassId)
            ->groupBy('class_announcements.id')
            ->orderBy('class_announcements.created_at', 'DESC')
            ->findAll();
    }
}
