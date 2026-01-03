<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NavigationLinkModel;
use App\Models\SliderModel;
use App\Models\HomepageSectionModel;
use App\Models\SettingModel;
use App\Models\HomepageFeatureModel;

class Homepage extends BaseController
{
    protected $navLinkModel;
    protected $sliderModel;
    protected $sectionModel;
    protected $settingModel;
    protected $featureModel;

    public function __construct()
    {
        $this->navLinkModel = new NavigationLinkModel();
        $this->sliderModel = new SliderModel();
        $this->sectionModel = new HomepageSectionModel();
        $this->settingModel = new SettingModel();
        $this->featureModel = new HomepageFeatureModel();
    }

    /**
     * Homepage management dashboard
     */
    public function index()
    {
        $data = [
            'nav_links' => $this->navLinkModel->getAllLinks(),
            'sliders' => $this->sliderModel->findAll(),
            'about_section' => $this->sectionModel->getSectionByKey('about'),
            'features' => $this->featureModel->getAllFeatures(),
            'footer_settings' => $this->settingModel->getMultiple([
                'site_name',
                'site_tagline',
                'school_address',
                'contact_email',
                'contact_phone'
            ])
        ];

        return view('admin/homepage/index', $data);
    }

    // ==================== Navigation Links ====================

    /**
     * Add navigation link
     */
    public function addNavLink()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'label' => 'required|max_length[100]',
            'url' => 'required|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'target' => 'permit_empty|in_list[_self,_blank]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'label' => $this->request->getPost('label'),
            'url' => $this->request->getPost('url'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'target' => $this->request->getPost('target') ?? '_self',
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        if ($this->navLinkModel->insert($data)) {
            return redirect()->to('admin/homepage')->with('message', 'Navigation link added successfully');
        }

        return redirect()->back()->with('error', 'Failed to add navigation link');
    }

    /**
     * Update navigation link
     */
    public function updateNavLink($id)
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'label' => 'required|max_length[100]',
            'url' => 'required|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'target' => 'permit_empty|in_list[_self,_blank]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'label' => $this->request->getPost('label'),
            'url' => $this->request->getPost('url'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'target' => $this->request->getPost('target') ?? '_self',
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        if ($this->navLinkModel->update($id, $data)) {
            return redirect()->to('admin/homepage')->with('message', 'Navigation link updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update navigation link');
    }

    /**
     * Delete navigation link
     */
    public function deleteNavLink($id)
    {
        if ($this->navLinkModel->delete($id)) {
            return redirect()->to('admin/homepage')->with('message', 'Navigation link deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete navigation link');
    }

    // ==================== About Section ====================

    /**
     * Update about section
     */
    public function updateAbout()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'title' => 'required|max_length[255]',
            'subtitle' => 'required|max_length[255]',
            'content' => 'required',
            'button_text' => 'permit_empty|max_length[100]',
            'button_url' => 'permit_empty|max_length[255]',
            'about_image' => 'permit_empty|uploaded[about_image]|max_size[about_image,2048]|is_image[about_image]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'subtitle' => $this->request->getPost('subtitle'),
            'content' => $this->request->getPost('content'),
            'button_text' => $this->request->getPost('button_text'),
            'button_url' => $this->request->getPost('button_url'),
            'is_active' => 1
        ];

        // Handle image upload
        $image = $this->request->getFile('about_image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/homepage', $newName);
            $data['image_path'] = $newName;
        }

        // Store additional data as JSON
        $data['extra_data'] = [
            'feature1' => $this->request->getPost('feature1'),
            'feature2' => $this->request->getPost('feature2'),
            'feature3' => $this->request->getPost('feature3'),
            'feature4' => $this->request->getPost('feature4')
        ];

        if ($this->sectionModel->updateSection('about', $data)) {
            return redirect()->to('admin/homepage')->with('message', 'About section updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update about section');
    }

    // ==================== Footer Settings ====================

    /**
     * Update footer settings
     */
    public function updateFooter()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'site_name' => 'required|max_length[100]',
            'site_tagline' => 'required|max_length[255]',
            'school_address' => 'required',
            'contact_email' => 'required|valid_email',
            'contact_phone' => 'required|max_length[50]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $settings = [
            'site_name' => $this->request->getPost('site_name'),
            'site_tagline' => $this->request->getPost('site_tagline'),
            'school_address' => $this->request->getPost('school_address'),
            'contact_email' => $this->request->getPost('contact_email'),
            'contact_phone' => $this->request->getPost('contact_phone')
        ];

        $success = true;
        foreach ($settings as $key => $value) {
            if (!$this->settingModel->updateSetting($key, $value)) {
                $success = false;
            }
        }

        if ($success) {
            return redirect()->to('admin/homepage')->with('message', 'Footer settings updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update some footer settings');
    }

    // ==================== Features Management ====================

    /**
     * Add feature
     */
    public function addFeature()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'icon_class' => 'required|max_length[100]',
            'title' => 'required|max_length[255]',
            'description' => 'required',
            'sort_order' => 'permit_empty|integer'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'icon_class' => $this->request->getPost('icon_class'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        if ($this->featureModel->insert($data)) {
            return redirect()->to('admin/homepage')->with('message', 'Feature added successfully');
        }

        return redirect()->back()->with('error', 'Failed to add feature');
    }

    /**
     * Update feature
     */
    public function updateFeature($id)
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'icon_class' => 'required|max_length[100]',
            'title' => 'required|max_length[255]',
            'description' => 'required',
            'sort_order' => 'permit_empty|integer'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'icon_class' => $this->request->getPost('icon_class'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        if ($this->featureModel->update($id, $data)) {
            return redirect()->to('admin/homepage')->with('message', 'Feature updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update feature');
    }

    /**
     * Delete feature
     */
    public function deleteFeature($id)
    {
        if ($this->featureModel->delete($id)) {
            return redirect()->to('admin/homepage')->with('message', 'Feature deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete feature');
    }
}
