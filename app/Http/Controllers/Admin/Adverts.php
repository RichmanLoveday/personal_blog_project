<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdvertsRequest;
use Illuminate\Http\Request;

class Adverts extends Controller
{
    public function index()
    {
        return view('admin.advert.index');
    }

    public function create()
    {
        return view('admin.advert.create');
    }

    public function store(StoreAdvertsRequest $request) {}

    public function edit($id) {}
}
