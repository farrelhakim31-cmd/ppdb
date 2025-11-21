<?php

namespace App\Http\Controllers;

use App\Models\MapSetting;
use Illuminate\Http\Request;

class MapSettingController extends Controller
{
    public function edit()
    {
        $setting = MapSetting::getSettings();
        return view('admin.map-settings', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'school_address' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'zoom_level' => 'required|integer|between:1,20'
        ]);

        $setting = MapSetting::getSettings();
        $setting->update($request->all());

        return back()->with('success', 'Pengaturan peta berhasil diperbarui');
    }
}