<?php

namespace App\Providers;

use App\Enums\UserRoles;
use App\Models\Announcement;
use App\Models\Camp;
use App\Models\Training;
use App\Models\User;
use App\Policies\AnnouncementPolicy;
use App\Policies\CampPolicy;
use App\Policies\TrainingPolicy;
use Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Policies
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Training::class, TrainingPolicy::class);
        Gate::policy(Camp::class, CampPolicy::class);
        Gate::policy(Announcement::class, AnnouncementPolicy::class);

        Gate::define('access-dashboard', function (User $user): bool {
            return true;
        });

        Gate::define('create-training', function (User $user): bool {
            return $user->hasAnyRole([
                UserRoles::FORMATEUR,
                UserRoles::ADMIN,
            ]);
        });

        Gate::define('create-camp', function (User $user): bool {
            return $user->hasAnyRole([
                UserRoles::COORDINATEUR,
                UserRoles::ADMIN,
            ]);
        });

        Gate::define('create-announcement', function (User $user): bool {
            return $user->hasAnyRole([
                UserRoles::ADMIN,
            ]);
        });

        Gate::define('create-member', function (User $user): bool {
            return $user->isAdmin();
        });

        Gate::define('manage-members', function (User $user): bool {
            return $user->isAdmin();
        });

        Gate::define('manage-messages', function (User $user): bool {
            return $user->isAdmin();
        });
    }
}
