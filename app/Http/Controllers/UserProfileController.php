<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Symfony\Component\Intl\Countries;

class UserProfileController extends Controller
{

    public function edit()
    {
        return view('user-profile', [
            'user' => Auth::user(),
            'countries' => Countries::getNames(App::currentLocale()),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'birthday' => ['date', 'before:today'],
            // 'email' => [
            //     'required',
            //     'email',
            //     Rule::unique('users', 'email')->ignore($user->id),
            // ],
            'profile_photo' => [
                'nullable',
                'image',
                'dimensions:min_width=200,min_height=200',
                'max:512000',
            ],
        ]);

        $previous = $user->profile_photo_path;
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $path = $file->store('/profile-photos', [
                'disk' => 'public'
            ]);
            $request->merge([
                'profile_photo_path' => $path,
            ]);
        }

        $request->merge([
            'name' => $request->first_name . ' ' . $request->last_name,
        ]);

        $user->update($request->except('email'));

        $user->profile()->updateOrCreate([
            'user_id' => $user->id,
        ], $request->all());

        if ($previous && $previous != $user->profile_photo_path) {
            Storage::disk('public')->delete($previous);
        }

        return redirect()->route('profile')
            ->with('success', 'Profile updated');
    }
}
