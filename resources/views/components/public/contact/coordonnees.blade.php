<section aria-labelledby="section-coordonnees">
    <h2 id="section-coordonnees" class="font-sans font-black text-3xl text-dark mb-8">
        {{ __('public/contact.coordonnees_title') }}
    </h2>

    <div class="flex flex-col gap-3">
        @foreach([
            [
                'titre'  => __('public/contact.coord_liege_titre'),
                'items'  => [
                    ['label' => __('public/contact.coord_label_adresse'), 'value' => __('public/contact.coord_liege_adresse')],
                    ['label' => __('public/contact.coord_label_email'),   'value' => __('public/contact.coord_liege_email')],
                    ['label' => __('public/contact.coord_label_tel'),     'value' => __('public/contact.coord_liege_tel')],
                    ['label' => __('public/contact.coord_label_heures'),  'value' => __('public/contact.coord_liege_heures')],
                ],
            ],
            [
                'titre'  => __('public/contact.coord_bxl_titre'),
                'items'  => [
                    ['label' => __('public/contact.coord_label_adresse'), 'value' => __('public/contact.coord_bxl_adresse')],
                    ['label' => __('public/contact.coord_label_email'),   'value' => __('public/contact.coord_bxl_email')],
                    ['label' => __('public/contact.coord_label_tel'),     'value' => __('public/contact.coord_bxl_tel')],
                    ['label' => __('public/contact.coord_label_heures'),  'value' => __('public/contact.coord_bxl_heures')],
                ],
            ],
        ] as $bureau)
            <x-public.accordion
                :summary="$bureau['titre']"
                class="px-6 py-4 bg-bg-mid rounded-tr-lg rounded-br-lg border-l-[6px] border-red">
                <div class="flex flex-col gap-2">
                    @foreach($bureau['items'] as $item)
                        <p class="font-serif text-sm text-dark leading-5">
                            <span class="font-sans font-bold">{{ $item['label'] }} :</span>
                            {{ $item['value'] }}
                        </p>
                    @endforeach
                </div>
            </x-public.accordion>
        @endforeach
    </div>
</section>
