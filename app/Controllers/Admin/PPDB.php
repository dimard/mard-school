<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PPDBSettingModel;
use App\Models\PPDBRegistrationModel;

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
     * List all registrations
     */
    public function index()
    {
        $status = $this->request->getGet('status') ?? 'all';
        $search = $this->request->getGet('search');

        if ($search) {
            $registrations = $this->ppdbRegistrationModel->search($search);
        } else {
            $registrations = $this->ppdbRegistrationModel->getRegistrations($status);
        }

        $data = [
            'registrations' => $registrations,
            'statistics' => $this->ppdbRegistrationModel->getStatistics(),
            'current_status' => $status,
        ];

        return view('admin/ppdb/index', $data);
    }

    /**
     * View registration detail
     */
    public function view($id)
    {
        $registration = $this->ppdbRegistrationModel->find($id);

        if (!$registration) {
            return redirect()->to('/admin/ppdb')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'registration' => $registration,
        ];

        return view('admin/ppdb/view', $data);
    }

    /**
     * Update registration status
     */
    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');
        $notes = $this->request->getPost('admin_notes');
        $userId = session()->get('user_id');

        if ($this->ppdbRegistrationModel->updateStatus($id, $status, $notes, $userId)) {
            return redirect()->back()->with('success', 'Status berhasil diupdate');
        }

        return redirect()->back()->with('error', 'Gagal mengupdate status');
    }

    /**
     * Delete registration
     */
    public function delete($id)
    {
        if ($this->ppdbRegistrationModel->delete($id)) {
            return redirect()->to('/admin/ppdb')->with('success', 'Data berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gagal menghapus data');
    }

    /**
     * PPDB Settings page
     */
    public function settings()
    {
        $data = [
            'ppdb_settings' => $this->ppdbSettingModel->getAllSettings(),
            'flow_steps' => $this->ppdbSettingModel->getFlowSteps(),
            'requirements' => $this->ppdbSettingModel->getRequirements(),
        ];

        return view('admin/ppdb/settings', $data);
    }

    /**
     * Update PPDB settings
     */
    public function updateSettings()
    {
        $this->ppdbSettingModel->setSetting('ppdb_status', $this->request->getPost('ppdb_status'));
        $this->ppdbSettingModel->setSetting('ppdb_year', $this->request->getPost('ppdb_year'));
        $this->ppdbSettingModel->setSetting('ppdb_quota', $this->request->getPost('ppdb_quota'));
        $this->ppdbSettingModel->setSetting('ppdb_start_date', $this->request->getPost('ppdb_start_date'));
        $this->ppdbSettingModel->setSetting('ppdb_end_date', $this->request->getPost('ppdb_end_date'));

        // Update flow steps - handle array and convert to JSON
        $flowSteps = $this->request->getPost('flow_steps');
        if ($flowSteps && is_array($flowSteps)) {
            // Re-index array to remove gaps from deleted items
            $flowSteps = array_values($flowSteps);
            // Re-number steps
            foreach ($flowSteps as $index => &$step) {
                $step['step'] = $index + 1;
            }
            $this->ppdbSettingModel->setSetting('ppdb_flow_steps', json_encode($flowSteps));
        }

        // Update requirements - handle array and convert to JSON
        $requirements = $this->request->getPost('requirements');
        if ($requirements && is_array($requirements)) {
            // Remove empty values and re-index
            $requirements = array_values(array_filter($requirements, function ($val) {
                return !empty(trim($val));
            }));
            $this->ppdbSettingModel->setSetting('ppdb_requirements', json_encode($requirements));
        }

        return redirect()->back()->with('success', 'Settings berhasil diupdate');
    }

    /**
     * Export registrations to Excel
     */
    public function export()
    {
        $registrations = $this->ppdbRegistrationModel->findAll();

        // Simple CSV export
        $filename = 'ppdb_registrations_' . date('Y-m-d') . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Headers
        fputcsv($output, [
            'No. Registrasi',
            'Nama Lengkap',
            'NIK',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Email',
            'No. HP',
            'Alamat',
            'Nama Orang Tua',
            'No. HP Orang Tua',
            'Asal Sekolah',
            'Status',
            'Tanggal Daftar'
        ]);

        // Data
        foreach ($registrations as $reg) {
            fputcsv($output, [
                $reg['registration_number'],
                $reg['full_name'],
                $reg['nik'],
                $reg['birth_place'],
                $reg['birth_date'],
                $reg['gender'] == 'L' ? 'Laki-laki' : 'Perempuan',
                $reg['email'],
                $reg['phone'],
                $reg['address'],
                $reg['parent_name'],
                $reg['parent_phone'],
                $reg['previous_school'],
                ucfirst($reg['status']),
                $reg['created_at'],
            ]);
        }

        fclose($output);
        exit;
    }
}
