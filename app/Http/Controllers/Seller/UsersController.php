<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $user;

    public function  __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user->latest()->get();

        return view('seller.users.index')->with('users', $users);
    }
}
