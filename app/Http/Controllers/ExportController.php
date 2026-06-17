<?php

namespace App\Http\Controllers;

use App\Models\Camp;
use App\Models\CampRegister;
use App\Models\Training;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;

class ExportController extends Controller
{
    use AuthorizesRequests;

    public function resumeTraining(string $locale, Training $training)
    {
        $this->authorize('update', $training);

        $training->load(['acceptedRegisters.user', 'pendingRegisters.user', 'refusedRegisters.user', 'user']);

        $pdf = Pdf::loadView('pdf.training-resume', compact('training'));

        return $pdf->download('resume-training-'.Str::slug($training->title)."-{$training->id}.pdf");
    }

    public function resumeCamp(string $locale, Camp $camp)
    {
        $this->authorize('update', $camp);

        $camp->load(['acceptedRegisters.user', 'pendingRegisters.user', 'refusedRegisters.user', 'user']);

        $pdf = Pdf::loadView('pdf.camp-resume', compact('camp'));

        return $pdf->download('resume-camp-'.Str::slug($camp->title)."-{$camp->id}.pdf");
    }

    public function contract(string $locale, Camp $camp, CampRegister $register)
    {
        if ($register->camp_id !== $camp->id) {
            abort(404);
        }

        $this->authorize('view', $camp);

        $register->load('user');

        $pdf = Pdf::loadView('pdf.camp-contract', compact('camp', 'register'));

        return $pdf->download('contrat-camp-'.Str::slug($register->user->fullName())."-{$camp->id}.pdf");
    }
}
