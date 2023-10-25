<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerPolicies();

        //
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });

        VerifyEmail::toMailUsing(function ($notifiable) {
            $verifyUrl = URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );

            return (new MailMessage)
                ->subject('Verifikasi Email')
                ->line('Klik tombol dibawah untuk verifikasi email anda.')
                ->action('Verifikasi Email', $verifyUrl)
                ->line('Jika anda tidak membuat akun, abaikan email ini.');
        });

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $resetUrl = 'https://yaskimember.org/password/reset/' . $token . '?email=' . $notifiable->getEmailForPasswordReset();

            return (new MailMessage)
                ->subject('Reset Password')
                ->line('Klik tombol dibawah untuk reset password anda.')
                ->action('Reset Password', $resetUrl)
                ->line('Link reset password akan kadaluarsa dalam ' . config('auth.passwords.users.expire') . ' menit.')
                ->line('Jika anda tidak membuat akun, abaikan email ini.');
        });

    }
}
