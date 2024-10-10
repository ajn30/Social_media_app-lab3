<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Update profile information
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $user->profile_picture = $path;
        }

        // Handle background picture upload
        if ($request->hasFile('background_picture')) {
            $path = $request->file('background_picture')->store('background-pictures', 'public');
            $user->background_picture = $path;
        }

        $user->save();

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update the user's profile media.
     */
    public function updateMedia(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_picture' => ['nullable', 'image', 'max:1024'],
            'background_picture' => ['nullable', 'image', 'max:2048'],
            'bio' => ['nullable', 'string', 'max:500'],
        ]);

        $user = $request->user();

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $profilePicturePath = $request->file('profile_picture')->store('profile-pictures', 'public');
            $user->profile_picture = $profilePicturePath;
        }

        if ($request->hasFile('background_picture')) {
            if ($user->background_picture) {
                Storage::disk('public')->delete($user->background_picture);
            }
            $backgroundPicturePath = $request->file('background_picture')->store('background-pictures', 'public');
            $user->background_picture = $backgroundPicturePath;
        }

        $user->bio = $request->bio;
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-media-updated');
    }

    /**
     * Display the user's profile information.
     */
    public function show(Request $request): View
    {
        $user = $request->user(); // Get the authenticated user
        return view('profile.show', compact('user')); // Return the profile.show view with the user data
    }
}
