<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubUserRequest;
use App\Http\Requests\UpdateSubUserRequest;
use Illuminate\Http\Request;
use App\Models\Team;

class SubUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sub-users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate(
        //     $request,
        //     [
        //         'name' => 'required',
        //         'email' => 'required|email|unique:users,email',
        //         'avatar' => 'required|min:8|confirmed',
        //     ],
        //     [
        //         'name.required' => 'Nama tidak boleh kosong',
        //         'email.required' => 'Email tidak boleh kosong',
        //         'email.email' => 'Email tidak valid',
        //         'email.unique' => 'Email sudah terdaftar',
        //         'avatar.required' => 'Avatar tidak boleh kosong',
        //     ]
        // );

        try {

            if (request()->has('avatar')) {
                $avatar = request()->file('avatar');
                $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatarPath = public_path('images/avatars/');
                $avatar->move($avatarPath, $avatarName);
            }

            $user = auth()->user();
            $subUser = new Team();
            $subUser->name = $request->name;
            $subUser->email = $request->email;
            $subUser->avatar = $request->avatar;
            $subUser->user_id = $user->id;
            $subUser->save();

            return redirect()->route('profile.index')->with(['type' => 'success', 'message' => 'Sub user berhasil ditambahkan']);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['type' => 'danger', 'message' => $e->getMessage() ?? 'Terjadi kesalahan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubUser  $subUser
     * @return \Illuminate\Http\Response
     */
    public function show(Team $subUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubUser  $subUser
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $subUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubUserRequest  $request
     * @param  \App\Models\SubUser  $subUser
     * @return \Illuminate\Http\Response
     */
    public function update(Team $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubUser  $subUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        //
    }
}
