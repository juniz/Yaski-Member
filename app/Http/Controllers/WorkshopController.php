<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workshops = Workshop::all();
        return view('workshops.index', compact('workshops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('workshops.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'title' => 'required',
                'start' => 'required',
                'end' => 'required',
                'image' => 'required',
            ],
            [
                'title.required' => 'Judul tidak boleh kosong',
                'start.required' => 'Start date is required',
                'end.required' => 'End date is required',
                'image.required' => 'Image is required',
            ]
        );

        try {
            if (request()->has('image')) {
                $image = request()->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = public_path('/images/workshops/');
                $image->move($imagePath, $imageName);
            }

            $workshop = new Workshop();
            $workshop->title = $request->title;
            $workshop->description = $request->description;
            $workshop->start = $request->start;
            $workshop->end = $request->end;
            $workshop->image = $imageName;
            $workshop->save();

            return redirect()->route('workshops.index')->with(['message' => 'Workshop berhasil ditambahkan', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage() ?? 'Terjadi kesalahan', 'type' => 'danger']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function show(Workshop $workshop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function edit(Workshop $workshop)
    {
        return view('workshops.edit', compact('workshop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Workshop $workshop)
    {
        $this->validate(
            $request,
            [
                'title' => 'required',
                'start' => 'required',
                'end' => 'required',
            ],
            [
                'title.required' => 'Judul tidak boleh kosong',
                'start.required' => 'Start date is required',
                'end.required' => 'End date is required',
            ]
        );

        try {
            if (request()->has('image')) {
                $image = request()->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = public_path('/images/workshops/');
                $image->move($imagePath, $imageName);
                $prevImage = public_path('/images/workshops/' . $workshop->image);
                if (file_exists($prevImage)) {
                    unlink($prevImage);
                }
            }

            $workshop->title = $request->title;
            $workshop->description = $request->description;
            $workshop->start = $request->start;
            $workshop->end = $request->end;
            $workshop->image = $imageName ?? $workshop->image;
            $workshop->save();

            return redirect()->route('workshops.index')->with(['message' => 'Workshop berhasil diubah', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage() ?? 'Terjadi kesalahan', 'type' => 'danger']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workshop $workshop)
    {
        try {
            $workshop->delete();
            $prevImage = public_path('/images/workshops/' . $workshop->image);
            if (file_exists($prevImage)) {
                unlink($prevImage);
            }
            return redirect()->route('workshops.index')->with(['message' => 'Workshop berhasil dihapus', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage() ?? 'Terjadi kesalahan', 'type' => 'danger']);
        }
    }
}
