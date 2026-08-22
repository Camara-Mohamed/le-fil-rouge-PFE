<div>

    <x-public.hero :title="__('breadcrumbs.create_announcement')" />

    <div class="flex flex-col gap-6 px-4 py-8 md:px-8">

        <div class="flex items-center justify-between gap-4 flex-wrap">
            <livewire:widgets::breadcrumb :items="[
                ['label' => __('breadcrumbs.announcements'), 'url' => route('public.announcements.index', ['locale' => app()->getLocale()])],
                ['label' => __('breadcrumbs.create_announcement')],
            ]" />
        </div>

        <form wire:submit="save" class="flex flex-col gap-6">

            {{-- Informations --}}
            <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h2 class="font-sans font-bold text-xl text-dark">{{ __('pages/announcements.section_info') }}</h2>
                <x-public.form.input :label="__('pages/announcements.label_title')" name="form.title" wire:model.live="form.title" maxlength="255" required />
                <x-public.form.input :label="__('pages/announcements.label_description')" name="form.description" wire:model.live="form.description" maxlength="255" required />
            </section>

            {{-- Contenu --}}
            <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h2 class="font-sans font-bold text-xl text-dark">{{ __('pages/announcements.section_content') }}</h2>
                <x-public.form.textarea :label="__('pages/announcements.label_content')" name="form.content" wire:model.live="form.content" :rows="8" required />
                <x-public.form.textarea :label="__('pages/announcements.label_details')" name="form.details" wire:model.live="form.details" :rows="5" />
            </section>

            <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h2 class="font-sans font-bold text-xl text-dark">{{ __('pages/announcements.section_images') }}</h2>

                {{-- Bannière --}}
                <div class="flex flex-col gap-3">
                    <span class="font-sans font-bold text-base text-dark">{{ __('pages/announcements.label_banner') }}</span>
                    @if($form->banner)
                        <img src="{{ $form->banner->temporaryUrl() }}" class="w-full h-48 object-cover rounded-xl"  alt="Image temporaire"/>
                    @endif
                    <label class="flex items-center gap-3 px-4 py-3 bg-bg border-2 border-dashed border-dark-light rounded-xl cursor-pointer hover:border-dark transition">
                        <span class="font-serif text-sm text-dark-mid">{{ __('pages/announcements.banner_choose') }}</span>
                        <input type="file" wire:model.live="form.banner" accept="image/*" class="sr-only">
                    </label>
                    <p class="font-serif text-xs text-dark-mid">{{ __('pages/announcements.image_hint') }}</p>
                    @error('form.banner')
                        <div class="px-4 py-1 bg-danger-bg border-l-[3px] border-danger">
                            <p class="font-serif text-sm text-danger">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                {{-- Galerie --}}
                <div class="flex flex-col gap-3">
                    <span class="font-sans font-bold text-base text-dark">{{ __('pages/announcements.label_gallery') }}</span>
                    @if($form->galeries)
                        <div class="grid grid-cols-3 md:grid-cols-4 gap-3">
                            @foreach($form->galeries as $index => $galerie)
                                <img wire:key="galerie-preview-{{ $index }}" src="{{ $galerie->temporaryUrl() }}" class="w-full h-24 object-cover rounded-lg"  alt="Image temporaire"/>
                            @endforeach
                        </div>
                    @endif
                    <label class="flex items-center gap-3 px-4 py-3 bg-bg border-2 border-dashed border-dark-light rounded-xl cursor-pointer hover:border-dark transition">
                        <span class="font-serif text-sm text-dark-mid">{{ __('pages/announcements.gallery_add') }}</span>
                        <input type="file" wire:model.live="form.galeries" accept="image/*" multiple class="sr-only">
                    </label>
                    <p class="font-serif text-xs text-dark-mid">{{ __('pages/announcements.gallery_image_hint') }}</p>
                    @error('form.galeries.*')
                        <div class="px-4 py-1 bg-danger-bg border-l-[3px] border-danger">
                            <p class="font-serif text-sm text-danger">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </section>

            <button type="submit"
                    class="w-full py-4 bg-red text-white font-sans font-bold text-base rounded-lg hover:bg-red-mid transition duration-200">
                {{ __('pages/announcements.create_btn_submit') }}
            </button>

        </form>
    </div>
</div>
