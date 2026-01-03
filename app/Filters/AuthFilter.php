<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Check if user is logged in
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Check role if specified in arguments
        if ($arguments && count($arguments) > 0) {
            $requiredRole = $arguments[0];
            $userRole = $session->get('role');

            if ($userRole !== $requiredRole) {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
