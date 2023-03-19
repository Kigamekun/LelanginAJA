<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\{User,Notification};
use URL;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.profile', [
            'user' => $request->user(),
        ]);
    }

    public function markAsRead(Request $request)
    {
        Notification::find($request->id)->update(['is_read'=>true]);
        return response()->json(['message'=>'notification has been readed'], 200);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $thumbname = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '/avatar' . '/', $thumbname);
            User::where('id', Auth::id())->update([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'address'=>$request->address,
                'state'=>$request->state,
                'zipcode'=>$request->zipcode,
                'country'=>$request->country,
                'thumb' => $thumbname,
            ]);
        } else {
            User::where('id', Auth::id())->update([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'address'=>$request->address,
                'state'=>$request->state,
                'zipcode'=>$request->zipcode,
                'country'=>$request->country,
            ]);
        }

        return Redirect::route('profile.edit')->with(['message'=>'Profile berhasil di update','status'=>'success']);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
            'accountActivation' => ['required'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
