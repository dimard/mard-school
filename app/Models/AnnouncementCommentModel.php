<?php

namespace App\Models;

use CodeIgniter\Model;

class AnnouncementCommentModel extends Model
{
    protected $table = 'announcement_comments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['announcement_id', 'user_id', 'comment'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';

    /**
     * Get all comments for a specific announcement with user info
     */
    public function getByAnnouncement($announcementId)
    {
        return $this->select('announcement_comments.*, users.full_name, users.role')
            ->join('users', 'users.id = announcement_comments.user_id')
            ->where('announcement_id', $announcementId)
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }

    /**
     * Count comments for an announcement
     */
    public function countByAnnouncement($announcementId)
    {
        return $this->where('announcement_id', $announcementId)->countAllResults();
    }
}
