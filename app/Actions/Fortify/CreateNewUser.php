<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Mail;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    protected $registration_email;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'position' => ['required', 'string', 'max:255'],
            'position_full' => ['required', 'string', 'max:255'],
            'office' => ['required', 'string', 'max:255'],
            'office_full' => ['required', 'string', 'max:255'],
            // 'role' => ['required', 'string', 'max:255'],
            // 'dark_mode' => ['required', 'string', 'max:255'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $this->registration_email = $input['email']; // get email value so email can be sent charrezz

        return DB::transaction(function () use ($input) {
            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'position' => $input['position'],
                'position_full' => $input['position_full'],
                'office' => $input['office'],
                'office_full' => $input['office_full'],
                // 'role' => $input['role'],
                // 'dark_mode' => $input['dark_mode'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) {
                $this->createTeam($user);
                $this->sendRegistrationEmail();
            });
        });
    }

    /**
     * Create a personal team for the user.
     */
    protected function createTeam(User $user): void
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }

    protected function sendRegistrationEmail()
    {
        Mail::html(
            "
                <h2>Your account registration is successful!</h2>
                <p>Please wait for the <strong>activation email</strong> before logging in.</p>
                <hr>
                <i>***Note: This is an automated email. Please do not reply.***</i>
            ", 
            function ($message) {
                $message->to($this->registration_email)
                        ->subject('SIIS Account Registration');
            });
    }
}
