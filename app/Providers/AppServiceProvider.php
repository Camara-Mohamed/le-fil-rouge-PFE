<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Models\Camp;
use App\Models\Comment;
use App\Models\Document;
use App\Models\Training;
use App\Models\User;
use App\Observers\DocumentObserver;
use App\Policies\AnnouncementPolicy;
use App\Policies\CampPolicy;
use App\Policies\CommentPolicy;
use App\Policies\DocumentPolicy;
use App\Policies\TrainingPolicy;
use App\Policies\UserPolicy;
use Gate;
use Illuminate\Auth\Events\Login;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageManager;

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
        $this->app->removeDeferredServices(['image']);

        $this->app->singleton('image', function () {
            return new ImageManager(config('image.driver'));
        });

        // Observers
        Document::observe(DocumentObserver::class);

        // Paginations
        Paginator::defaultView('vendor.pagination.tailwind');

        // Locale
        URL::defaults(['locale' => app()->getLocale()]);

        // Bloque la connexion des comptes archivés
        Event::listen(Login::class, function (Login $event) {
            if ($event->user->isArchived()) {
                Auth::logout();
                abort(403);
            }
        });

        // Policies
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Training::class, TrainingPolicy::class);
        Gate::policy(Camp::class, CampPolicy::class);
        Gate::policy(Announcement::class, AnnouncementPolicy::class);
        Gate::policy(Document::class, DocumentPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);

        Gate::define('access-dashboard', function (User $user): bool {
            return true;
        });

        Gate::define('access-profile', function (User $user): bool {
            return true;
        });

        Gate::define('manage-training', function (User $user): bool {
            return $user->isAdmin() || $user->isFormateur();
        });

        Gate::define('manage-camp', function (User $user): bool {
            return $user->isAdmin() || $user->isCoordinateur();
        });

        Gate::define('manage-announcement', function (User $user): bool {
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
