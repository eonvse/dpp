<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Models\teachers;
use App\Models\positions;
use App\Models\institutions;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {

        $guides = ['positions'=>positions::all()->sortBy('name'),'institutions'=>institutions::all()->sortBy('name')];

        return view('profile.edit', [
            'user' => $request->user(),
            'guides' => $guides
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updatePersonal(Request $request)
    {
        
        $id = Auth::user()->teacher->id ?? 0;
        $name = $request->name;
        $surname = $request->surname;
        $patronymic = !empty($request->patronymic) ? $request->patronymic : NULL;
        $idPositions = $request->idPositions;
        $idInstitutions = $request->idInstitutions;
        $idUpdater = Auth::user()->id;

        if (empty($id)) {

            teachers::create([
                'name' => $name,
                'surname' => $surname,
                'patronymic' => $patronymic,
                'idPositions' => $idPositions,
                'idInstitutions' => $idInstitutions,
                'idType' => 0,
                'dateDoc' => NULL,
                'idUser' => $idUpdater,
                'idAutor' => $idUpdater,
                'idUpdater' => $idUpdater,
        ]);

        }else {

            $upd = teachers::find($id);
            $upd->name = $name;
            $upd->surname = $surname;
            $upd->patronymic = $patronymic;
            $upd->idPositions = $idPositions;
            $upd->idInstitutions = $idInstitutions;
            $upd->idUpdater = $idUpdater;

            $upd->save();

        }


        return Redirect::route('profile.edit')->with('status', 'profile-updated-personal');
    }
    /**
     * Delete the user's account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
