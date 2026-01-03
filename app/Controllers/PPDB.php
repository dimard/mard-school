<?php

namespace App\Controllers;

use App\Models\PPDBSettingModel;
use App\Models\PPDBRegistrationModel;
use App\Models\NavigationLinkModel;
use App\Models\SettingModel;

class PPDB extends BaseController
{
    protected $ppdbSettingModel;
    protected $ppdbRegistrationModel;

    public function __construct()
    {
        $this->ppdbSettingModel = new PPDBSettingModel();
        $this->ppdbRegistrationModel = new PPDBRegistrationModel();
        helper(['form', 'filesystem']);
    }

    /**
     * Display PPDB registration page
     */
    public function index()
    {
        // Load settings for navbar
        $navLinkModel = new NavigationLinkModel();
        $settingModel = new SettingModel();

        $data = [
            'nav_links' => $navLinkModel->getActiveLinks(),
            'settings' => $settingModel->getAllSettings(),
            'ppdb_info' => $this->ppdbSettingModel->getRegistrationPeriod(),
            'ppdb_flow' => $this->ppdbSettingModel->getFlowSteps(),
            'ppdb_requirements' => $this->ppdbSettingModel->getRequirements(),
            'is_open' => $this->ppdbSettingModel->isPPDBOpen(),
            'is_full' => $this->ppdbRegistrationModel->isQuotaFull(),
        ];

        return view('ppdb/index', $data);
    }

    /**
     * Handle registration submission
     */
    public function register()
    {
        // Check if PPDB is open
        if (!$this->ppdbSettingModel->isPPDBOpen()) {
            return redirect()->back()->with('error', 'Pendaftaran PPDB sedang ditutup.');
        }

        // Check quota
        if ($this->ppdbRegistrationModel->isQuotaFull()) {
            return redirect()->back()->with('error', 'Kuota pendaftaran sudah penuh.');
        }

        // Validation rules
        $rules = [
            'full_name' => 'required|min_length[3]|max_length[255]',
            'nik' => 'required|numeric|min_length[16]|max_length[16]',
            'birth_place' => 'required',
            'birth_date' => 'required|valid_date',
            'gender' => 'required|in_list[L,P]',
            'email' => 'required|valid_email',
            'phone' => 'required|numeric',
            'address' => 'required',
            'parent_name' => 'required',
            'parent_phone' => 'required|numeric',
            'previous_school' => 'required',
            'photo' => 'uploaded[photo]|max_size[photo,2048]|is_image[photo]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Generate registration number
        $regNumber = $this->ppdbRegistrationModel->generateRegNumber();

        // Prepare data
        $data = [
            'registration_number' => $regNumber,
            'full_name' => $this->request->getPost('full_name'),
            'nik' => $this->request->getPost('nik'),
            'birth_place' => $this->request->getPost('birth_place'),
            'birth_date' => $this->request->getPost('birth_date'),
            'gender' => $this->request->getPost('gender'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'parent_name' => $this->request->getPost('parent_name'),
            'parent_phone' => $this->request->getPost('parent_phone'),
            'parent_occupation' => $this->request->getPost('parent_occupation'),
            'previous_school' => $this->request->getPost('previous_school'),
            'status' => 'pending',
        ];

        // Handle file uploads
        $uploadPath = WRITEPATH . '../public/uploads/ppdb/' . $regNumber . '/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Upload photo
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid()) {
            $photoName = 'photo_' . $photo->getRandomName();
            $photo->move($uploadPath, $photoName);
            $data['photo'] = $regNumber . '/' . $photoName;
        }

        // Upload optional documents
        if ($ijazah = $this->request->getFile('document_ijazah')) {
            if ($ijazah->isValid()) {
                $ijazahName = 'ijazah_' . $ijazah->getRandomName();
                $ijazah->move($uploadPath, $ijazahName);
                $data['document_ijazah'] = $regNumber . '/' . $ijazahName;
            }
        }

        if ($kk = $this->request->getFile('document_kk')) {
            if ($kk->isValid()) {
                $kkName = 'kk_' . $kk->getRandomName();
                $kk->move($uploadPath, $kkName);
                $data['document_kk'] = $regNumber . '/' . $kkName;
            }
        }

        if ($akta = $this->request->getFile('document_akta')) {
            if ($akta->isValid()) {
                $aktaName = 'akta_' . $akta->getRandomName();
                $akta->move($uploadPath, $aktaName);
                $data['document_akta'] = $regNumber . '/' . $aktaName;
            }
        }

        // Save to database
        if ($this->ppdbRegistrationModel->insert($data)) {
            session()->setFlashdata('success', 'Pendaftaran berhasil!');
            session()->setFlashdata('registration_number', $regNumber);
            return redirect()->to('/ppdb/success');
        }

        return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
    }

    /**
     * Success page after registration
     */
    public function success()
    {
        $regNumber = session()->getFlashdata('registration_number');

        if (!$regNumber) {
            return redirect()->to('/ppdb');
        }

        // Load settings for navbar
        $navLinkModel = new NavigationLinkModel();
        $settingModel = new SettingModel();

        $data = [
            'nav_links' => $navLinkModel->getActiveLinks(),
            'settings' => $settingModel->getAllSettings(),
            'registration_number' => $regNumber,
        ];

        return view('ppdb/success', $data);
    }

    /**
     * Check registration status
     */
    public function checkStatus()
    {
        // Handle POST request (AJAX)
        if ($this->request->isAJAX() || $this->request->getMethod() === 'post') {
            $json = $this->request->getJSON(true);
            $regNumber = $json['registration_number'] ?? $this->request->getPost('registration_number');

            if (!$regNumber) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Nomor registrasi harus diisi'
                ]);
            }

            $registration = $this->ppdbRegistrationModel
                ->where('registration_number', $regNumber)
                ->first();

            if (!$registration) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Nomor registrasi tidak ditemukan'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => [
                    'registration_number' => $registration['registration_number'],
                    'full_name' => $registration['full_name'],
                    'email' => $registration['email'],
                    'status' => $registration['status'],
                    'admin_notes' => $registration['admin_notes'] ?? '',
                    'created_at' => $registration['created_at']
                ]
            ]);
        }

        // Handle GET request (direct access) - redirect to main page
        return redirect()->to(base_url('ppdb'))->with('info', 'Silakan masukkan nomor registrasi Anda');
    }
}
