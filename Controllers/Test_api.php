<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\Request;

class Test_api extends ResourceController
{
    // fungsi untuk mengambil data
    public function get_data()
    {
        // mengambil header username dan password
        $headers = apache_request_headers();

        // pengecekan apakah user dan pass sudah diisi
        if (!isset($headers['x-username']) || !isset($headers['x-password'])) {
            return $this->respond([
                "metadata" => [
                    "message" => "Username atau password belum dimasukkan",
                    "code" => 400
                ]
            ], 400);
        }

        // pengecekan apakah user dan pass benar
        if($headers['x-username'] == 'admin' && $headers['x-password'] == 'admin')
        {
            // jika data ditemukan
            return $this->respond([
                "metadata" => [
                    "message" => "success",
                    "code" => 200,
                ]
            ], 200);

        }

        // jika user atau pass salah
        return $this->respond([
            "metadata" => [
                "message" => "Username atau password salah",
                "code" => 400
            ]
        ], 400);
    }

    public function insert_data()
    {
        // mengambil header username dan password
        $headers = apache_request_headers();

        // mendapatkan request user
        $request = json_decode(json_encode($this->request->getVar()),true);

        $validation = \Config\Services::validation();
        $validation->setRules($this->rules_insert());

        // pengecekan apakah user dan pass sudah diisi
        if (!isset($headers['x-username']) || !isset($headers['x-password'])) {
            return $this->respond([
                "metadata" => [
                    "message" => "Username atau password belum dimasukkan",
                    "code" => 400
                ]
            ], 400);
        }

        // pengecekan apakah user dan pass benar
        if($headers['x-username'] == 'admin' && $headers['x-password'] == 'admin')
        {
            // pengecekan apakah ada request yang terlewat
            $isValid = $validation->withRequest($this->request)->run();
            if ($isValid == false) {
                $get_error = $validation->getErrors();
                // assosiative array to normal array
                $error = array_values($get_error);
                return $this->respond([
                    "metadata" => [
                        "message" => $error[0],
                        "code" => 201
                    ]
                ], 201);
            }

            
            // respon ketika berhasil
            return $this->respond([
                "metadata" => [
                    "message" => "success",
                    "code" => 200,
                    "request" => $request
                ]
            ], 200); 

        }

        // jika user atau pass salah
        return $this->respond([
            "metadata" => [
                "message" => "Username atau password salah",
                "code" => 400
            ]
        ], 400);   
    }

    // rules untuk proses insert
    private function rules_insert()
    {
        $rules = 
        [
            'no_induk' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'no_induk tidak boleh kosong',
                    'integer' => 'no_induk harus berupa angka'
                ]
            ],
            'tanggal' => [
                'rules' => 'required|valid_date[Y-m-d]',
                'errors' => [
                    'required' => 'tanggal tidak boleh kosong',
                    'valid_date' => 'format tanggal harus berupa Y-m-d'
                ]
            ],
            'nama' => [
                'rules' => 'required|alpha_space',
                'errors' => [
                    'required' => 'nama tidak boleh kosong',
                    'alpha_space' => 'tidak boleh ada selain huruf dan spasi'
                ]
            ],
        ];

        return $rules;
    }

    public function not_found()
    {
        // ketika url tidak sesuai dengan yang ada pada halaman config/routes
        return $this->respond([
            "metadata" => [
                "message" => "Url tidak tersedia",
                "code" => 404
            ]
        ], 404);   
    }
}
