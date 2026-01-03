<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'title',
        'slug',
        'content',
        'excerpt',
        'thumbnail',
        'category',
        'author_id',
        'views',
        'is_published',
        'published_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'title' => 'required|min_length[5]|max_length[255]',
        'slug' => 'required|alpha_dash|is_unique[news.slug,id,{id}]',
        'content' => 'required',
        'author_id' => 'required|integer'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Judul berita harus diisi'
        ],
        'slug' => [
            'required' => 'Slug harus diisi',
            'is_unique' => 'Slug sudah digunakan'
        ]
    ];

    /**
     * Get published news with author info
     */
    public function getPublishedNews($limit = 10)
    {
        return $this->select('news.*, users.full_name as author_name')
            ->join('users', 'users.id = news.author_id')
            ->where('news.is_published', 1)
            ->orderBy('news.published_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Get news by slug with author
     */
    public function getNewsBySlug($slug)
    {
        return $this->select('news.*, users.full_name as author_name, users.email as author_email')
            ->join('users', 'users.id = news.author_id')
            ->where('news.slug', $slug)
            ->first();
    }

    /**
     * Increment views counter
     */
    public function incrementViews($id)
    {
        return $this->set('views', 'views + 1', false)->where('id', $id)->update();
    }
}
