<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class Settings extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        $settings = $this->settingModel->findAll();
        $formattedSettings = [];
        foreach ($settings as $setting) {
            $formattedSettings[$setting['setting_key']] = $setting['setting_value'];
        }

        $data = [
            'settings' => $formattedSettings
        ];

        return view('admin/settings/index', $data);
    }

    public function update()
    {
        $postData = $this->request->getPost();

        foreach ($postData as $key => $value) {
            // Check if exists
            $exists = $this->settingModel->where('setting_key', $key)->first();
            if ($exists) {
                $this->settingModel->where('setting_key', $key)->set(['setting_value' => $value])->update();
            } else {
                $this->settingModel->insert(['setting_key' => $key, 'setting_value' => $value]);
            }
        }

        return redirect()->back()->with('message', 'Settings updated successfully');
    }

    public function uploadSlider()
    {
        $sliderModel = new \App\Models\SliderModel();

        $image = $this->request->getFile('slider_image');

        // Debug: Check if file was received
        if (!$image) {
            return redirect()->back()->with('error', 'No file uploaded. Please select an image.');
        }

        // Debug: Check file validity
        if (!$image->isValid()) {
            $error = $image->getErrorString() . ' (' . $image->getError() . ')';
            return redirect()->back()->with('error', 'Invalid file: ' . $error);
        }

        // Debug: Check if already moved
        if ($image->hasMoved()) {
            return redirect()->back()->with('error', 'File has already been moved.');
        }

        // Validate file size (max 2MB)
        if ($image->getSize() > 2097152) {
            return redirect()->back()->with('error', 'Image size must be less than 2MB');
        }

        $newName = $image->getRandomName();

        // Try to move file
        try {
            $image->move(FCPATH . 'uploads/sliders', $newName);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to move file: ' . $e->getMessage());
        }

        // Get next sort order
        $nextOrder = $sliderModel->getNextSortOrder();

        // Try to insert into database
        $inserted = $sliderModel->insert([
            'image_url' => $newName,
            'sort_order' => $nextOrder,
            'is_active' => 1
        ]);

        // Check if insert was successful
        if (!$inserted) {
            $errors = $sliderModel->errors();
            $errorMsg = !empty($errors) ? implode(', ', $errors) : 'Unknown database error';
            return redirect()->back()->with('error', 'Database insert failed: ' . $errorMsg);
        }

        return redirect()->back()->with('message', 'Slider uploaded successfully');
    }

    public function deleteSlider($id)
    {
        $sliderModel = new \App\Models\SliderModel();

        $slider = $sliderModel->find($id);
        if ($slider) {
            // Delete file from filesystem
            $filePath = FCPATH . 'uploads/sliders/' . $slider['image_url'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete database record
            $sliderModel->delete($id);

            return redirect()->back()->with('message', 'Slider deleted successfully');
        }

        return redirect()->back()->with('error', 'Slider not found');
    }
}
