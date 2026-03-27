<?php

namespace Partymeister\Core\Http\Controllers\Api\V2\Auth;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Motor\Admin\Http\Controllers\Controller;
use Partymeister\Core\Http\Requests\Api\V2\Auth\PasswordForgotRequest;
use Partymeister\Core\Http\Resources\V2\Auth\MessageResource;
use Partymeister\Core\Mail\PasswordReset;
use Partymeister\Core\Models\Visitor;

/**
 * @tags Visitor Auth
 */
class PasswordForgotController extends Controller
{
    public function store(PasswordForgotRequest $request): MessageResource
    {
        $email = $request->input('email');
        $visitor = Visitor::where('email', $email)->first();

        if ($visitor) {
            // Delete old password reset tokens for this email
            DB::table('password_resets')->where('email', $email)->delete();

            // Create new reset token
            $token = (string) Str::uuid();
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);

            // Send password reset email
            Mail::to($email)->send(new PasswordReset($token));
        }

        // Always return 200 to not reveal if email exists
        return (new MessageResource)
            ->additional(['meta' => ['message' => 'If the email exists, a reset link has been sent']]);
    }
}
