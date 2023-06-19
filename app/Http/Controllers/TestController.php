<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{
    protected $mc, $exam, $student, $user;
    public function __construct()
    {

    }

    public function index()
    {
        echo Hash::make("Admin");
    }

}
