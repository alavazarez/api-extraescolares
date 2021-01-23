<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\FormacionIntegralRepository;

class FormacionIntegralController extends Controller
{
    protected $FormacionIntegralRepository;
    public function __construct() {
        $this->FormacionIntegralRepository = new FormacionIntegralRepository ();
    }

    public function find($no_de_control)
    {
        return $this->FormacionIntegralRepository->find($no_de_control);
    }
}
