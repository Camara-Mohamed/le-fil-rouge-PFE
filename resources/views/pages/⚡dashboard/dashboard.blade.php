<div class="flex flex-col gap-8 p-8">

    <p>Bonjour {{ auth()->user()->fullName() }}, tu as {{ auth()->user()->getAge() }} ans</p>

    <section class="flex flex-col gap-4">
        <h2>CTA</h2>
        <div class="flex flex-wrap gap-3">

            @can('manage-members')
                <a href="{{ route('admin.members.create', ['locale' => app()->getLocale()]) }}">Ajouter un membre</a>
                <a href="{{ route('admin.members.index', ['locale' => app()->getLocale()]) }}">Gérer les membres</a>
            @endcan

            @can('manage-messages')
                <a href="{{ route('admin.messages.index', ['locale' => app()->getLocale()]) }}">Voir les messages</a>
            @endcan

            @can('manage-training')
                <a href="{{ route('admin.trainings.create', ['locale' => app()->getLocale()]) }}">Créer une formation</a>
            @endcan

            @can('manage-camp')
                <a href="{{ route('admin.camps.create', ['locale' => app()->getLocale()]) }}">Créer un camp</a>
            @endcan

            @can('manage-announcement')
                <a href="{{ route('admin.announcements.create', ['locale' => app()->getLocale()]) }}">Ajouter une
                    actualité</a>
            @endcan
        </div>
    </section>
</div>
