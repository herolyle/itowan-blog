<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\UserRepository;

class UserController extends Controller
{
    private $user;

    public function __construct(UserRepository $user) {
        $this->user = $user;
    }

    public function index() {
        return 123;
        return \Response::json($this->user->all());
    }
}
