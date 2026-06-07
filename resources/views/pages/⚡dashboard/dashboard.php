<?php

use App\Enums\CampStatus;
use App\Enums\RegisterStatus;
use App\Enums\TrainingStatus;
use App\Models\Camp;
use App\Models\CampRegister;
use App\Models\Training;
use App\Models\TrainingRegister;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Dashboard')]
class extends Component
{
    public function acceptTrainingRegister(int $registerId): void
    {
        $user = auth()->user();
        $register = TrainingRegister::with('training')->findOrFail($registerId);

        if ($register->training->user_id !== $user->id && ! $user->isAdmin()) {
            abort(403);
        }

        $register->update(['status' => RegisterStatus::ACCEPTED]);
        $this->dispatch('toast', message: __('toast/enrollments.accept'), type: 'success');
    }

    public function refuseTrainingRegister(int $registerId): void
    {
        $user = auth()->user();
        $register = TrainingRegister::with('training')->findOrFail($registerId);

        if ($register->training->user_id !== $user->id && ! $user->isAdmin()) {
            abort(403);
        }

        $register->update(['status' => RegisterStatus::REFUSED]);
        $this->dispatch('toast', message: __('toast/enrollments.refuse'), type: 'error');
    }

    public function acceptCampRegister(int $registerId): void
    {
        $user = auth()->user();
        $register = CampRegister::with('camp')->findOrFail($registerId);

        if ($register->camp->user_id !== $user->id && ! $user->isAdmin()) {
            abort(403);
        }

        $register->update(['status' => RegisterStatus::ACCEPTED]);
        $this->dispatch('toast', message: __('toast/enrollments.accept'), type: 'success');
    }

    public function refuseCampRegister(int $registerId): void
    {
        $user = auth()->user();
        $register = CampRegister::with('camp')->findOrFail($registerId);

        if ($register->camp->user_id !== $user->id && ! $user->isAdmin()) {
            abort(403);
        }

        $register->update(['status' => RegisterStatus::REFUSED]);
        $this->dispatch('toast', message: __('toast/enrollments.refuse'), type: 'error');
    }

    public function openConfirmRefuseModal(int $id, string $type): void
    {
        $this->dispatch('open_modal', payload: [
            'form' => 'modals::dashboard.confirm-refuse-'.str_replace('_', '-', $type),
            'model_id' => (string) $id,
            'model_type' => $type,
        ]);
    }

    #[On('dashboard_updated')]
    public function onDashboardUpdated(): void {}

    public function publishTraining(int $trainingId): void
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        Training::findOrFail($trainingId)->update(['status' => TrainingStatus::PUBLISHED]);
        $this->dispatch('toast', message: __('toast/trainings.updated'), type: 'success');
    }

    public function refuseTraining(int $trainingId): void
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        Training::findOrFail($trainingId)->update(['status' => TrainingStatus::REFUSED]);
        $this->dispatch('toast', message: __('toast/trainings.updated'), type: 'error');
    }

    public function publishCamp(int $campId): void
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        Camp::findOrFail($campId)->update(['status' => CampStatus::PUBLISHED]);
        $this->dispatch('toast', message: __('toast/camps.updated', ['type' => 'camp']), type: 'success');
    }

    public function refuseCamp(int $campId): void
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        Camp::findOrFail($campId)->update(['status' => CampStatus::REFUSED]);
        $this->dispatch('toast', message: __('toast/camps.updated', ['type' => 'camp']), type: 'error');
    }

    public function render()
    {
        $user = auth()->user();
        $data = [];

        if ($user->isFormateur() || $user->isAdmin()) {
            $query = TrainingRegister::query()
                ->with(['training', 'user'])
                ->where('status', RegisterStatus::PENDING);

            if (! $user->isAdmin()) {
                $query->whereHas('training', fn ($q) => $q->where('user_id', $user->id));
            }

            $data['pendingTrainingRegisters'] = $query->latest()->get();
        }

        if ($user->isCoordinateur() || $user->isAdmin()) {
            $query = CampRegister::query()
                ->with(['camp', 'user'])
                ->where('status', RegisterStatus::PENDING);

            if (! $user->isAdmin()) {
                $query->whereHas('camp', fn ($q) => $q->where('user_id', $user->id));
            }

            $data['pendingCampRegisters'] = $query->latest()->get();
        }

        if ($user->isAdmin()) {
            $data['pendingTrainings'] = Training::where('status', TrainingStatus::PENDING)
                ->with('user')
                ->latest()
                ->get();

            $data['pendingCamps'] = Camp::where('status', CampStatus::PENDING)
                ->with('user')
                ->latest()
                ->get();
        }

        $data['calendarEvents'] = $this->getCalendarEvents($user);

        return view('pages.⚡dashboard.dashboard', $data);
    }

    private function getCalendarEvents($user): array
    {
        $events = [];
        $locale = app()->getLocale();

        if ($user->isAdmin()) {
            foreach (Training::where('status', TrainingStatus::PUBLISHED)->get() as $training) {
                $events[] = [
                    'id' => 'training-'.$training->id,
                    'title' => $training->title,
                    'start' => $training->start_date->toIso8601String(),
                    'end' => $training->end_date->toIso8601String(),
                    'url' => route('public.trainings.show', ['locale' => $locale, 'training' => $training]),
                    'classNames' => ['bg-success-bg border-success text-sky-500 rounded font-semibold text-[0.72rem] font-sans'],
                ];
            }
            foreach (Camp::where('status', CampStatus::PUBLISHED)->get() as $camp) {
                $events[] = [
                    'id' => 'camp-'.$camp->id,
                    'title' => $camp->title,
                    'start' => $camp->start_date->toIso8601String(),
                    'end' => $camp->end_date->toIso8601String(),
                    'url' => route('public.camps.show', ['locale' => $locale, 'camp' => $camp]),
                    'classNames' => ['bg-info-bg border-info text-green-500 rounded font-semibold text-[0.72rem] font-sans'],
                ];
            }
        } elseif ($user->isFormateur()) {
            foreach ($user->trainings()->whereIn('status',
                [TrainingStatus::PUBLISHED->value, TrainingStatus::CONFIRMED->value])->get() as $training) {
                $events[] = [
                    'id' => 'training-'.$training->id,
                    'title' => $training->title,
                    'start' => $training->start_date->toIso8601String(),
                    'end' => $training->end_date->toIso8601String(),
                    'url' => route('public.trainings.show', ['locale' => $locale, 'training' => $training]),
                    'classNames' => ['bg-success-bg border-success text-sky-500 rounded font-semibold text-[0.72rem] font-sans'],
                ];
            }
        } elseif ($user->isCoordinateur()) {
            foreach ($user->camps()->whereIn('status',
                [CampStatus::PUBLISHED->value, CampStatus::CONFIRMED->value])->get() as $camp) {
                $events[] = [
                    'id' => 'camp-'.$camp->id,
                    'title' => $camp->title,
                    'start' => $camp->start_date->toIso8601String(),
                    'end' => $camp->end_date->toIso8601String(),
                    'url' => route('public.camps.show', ['locale' => $locale, 'camp' => $camp]),
                    'classNames' => ['bg-info-bg border-info text-green-500 rounded font-semibold text-[0.72rem] font-sans'],
                ];
            }
        } else {
            foreach ($user->trainingRegisters()->where('status',
                RegisterStatus::ACCEPTED)->with('training')->get() as $register) {
                $events[] = [
                    'id' => 'training-'.$register->training->id,
                    'title' => $register->training->title,
                    'start' => $register->training->start_date->toIso8601String(),
                    'end' => $register->training->end_date->toIso8601String(),
                    'url' => route('public.trainings.show', ['locale' => $locale, 'training' => $register->training]),
                    'classNames' => ['bg-success-bg border-success text-sky-500 rounded font-semibold text-[0.72rem] font-sans'],
                ];
            }
            foreach ($user->campRegisters()->where('status',
                RegisterStatus::ACCEPTED)->with('camp')->get() as $register) {
                $events[] = [
                    'id' => 'camp-'.$register->camp->id,
                    'title' => $register->camp->title,
                    'start' => $register->camp->start_date->toIso8601String(),
                    'end' => $register->camp->end_date->toIso8601String(),
                    'url' => route('public.camps.show', ['locale' => $locale, 'camp' => $register->camp]),
                    'classNames' => ['bg-info-bg border-info text-green-500 rounded font-semibold text-[0.72rem] font-sans'],
                ];
            }
        }

        return $events;
    }
};
