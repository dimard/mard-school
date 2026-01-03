<?php

namespace App\Controllers;

use App\Models\NewsModel;
use App\Models\SliderModel;
use App\Models\SettingModel;
use App\Models\StaffModel;
use App\Models\NavigationLinkModel;
use App\Models\HomepageSectionModel;
use App\Models\HomepageFeatureModel;

class Home extends BaseController
{
    public function index(): string
    {
        $newsModel = new NewsModel();
        $sliderModel = new SliderModel();
        $settingModel = new SettingModel();
        $navLinkModel = new NavigationLinkModel();
        $sectionModel = new HomepageSectionModel();
        $staffModel = new StaffModel();
        $testimonialModel = new \App\Models\TestimonialModel();
        $featureModel = new HomepageFeatureModel();

        $data = [
            'sliders' => $sliderModel->getActiveSliders(),
            'news' => $newsModel->getPublishedNews(6),
            'settings' => $settingModel->getAllSettings(),
            'nav_links' => $navLinkModel->getActiveLinks(),
            'about_section' => $sectionModel->getSectionByKey('about'),
            'staff' => $staffModel->getActiveStaff(),
            'testimonials' => $testimonialModel->orderBy('created_at', 'DESC')->findAll(),
            'features' => $featureModel->getActiveFeatures()
        ];

        return view('home/index', $data);
    }

    public function newsDetail($slug)
    {
        $newsModel = new NewsModel();
        $settingModel = new SettingModel();
        $navLinkModel = new NavigationLinkModel();

        $news = $newsModel->getNewsBySlug($slug);

        if (!$news) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Increment view count
        $newsModel->incrementViews($news['id']);

        // Get recent news (excluding current news)
        $recentNews = $newsModel
            ->select('news.*, users.full_name as author_name')
            ->join('users', 'users.id = news.author_id')
            ->where('news.id !=', $news['id'])
            ->where('news.is_published', 1)
            ->orderBy('news.published_at', 'DESC')
            ->limit(5)
            ->findAll();

        $data = [
            'news' => $news,
            'recent_news' => $recentNews,
            'settings' => $settingModel->getAllSettings(),
            'nav_links' => $navLinkModel->getActiveLinks()
        ];

        return view('home/news_detail', $data);
    }
}
