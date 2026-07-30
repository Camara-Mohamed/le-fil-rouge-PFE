<?php

namespace Database\Seeders;

use App\Enums\CampStatus;
use App\Enums\CampTypes;
use App\Enums\Diets;
use App\Enums\Provinces;
use App\Enums\RegisterStatus;
use App\Enums\TrainingStatus;
use App\Enums\TrainingTypes;
use App\Enums\UserRoles;
use App\Enums\UserStatus;
use App\Enums\VolunteerRequestStatus;
use App\Models\Announcement;
use App\Models\Camp;
use App\Models\CampRegister;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\Galerie;
use App\Models\Training;
use App\Models\TrainingRegister;
use App\Models\User;
use App\Models\VolunteerRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Laravel\Facades\Image;

class PresentationSeeder extends Seeder
{
    use WithoutModelEvents;

    private function storeImage(string $publicRelativePath, string $storagePath): string
    {
        $fullPath = public_path($publicRelativePath);
        if (! file_exists($fullPath)) {
            Log::warning("[PresentationSeeder] Image introuvable : {$fullPath}");

            return $storagePath;
        }
        Storage::put($storagePath, file_get_contents($fullPath), 'public');

        return $storagePath;
    }

    private function storeBanner(string $publicRelativePath, string $storagePath): string
    {
        $fullPath = public_path($publicRelativePath);
        if (! file_exists($fullPath)) {
            Log::warning("[PresentationSeeder] Bannière introuvable : {$fullPath}");

            return $storagePath;
        }
        Storage::put($storagePath, file_get_contents($fullPath), 'public');
        $filename = basename($storagePath);
        $variantsBase = dirname($storagePath).'/variants';
        foreach (config('banners.sizes.banner') as $width) {
            $resized = Image::decode($fullPath)->scaleDown(width: $width)->encode(new WebpEncoder(quality: config('banners.quality', 85)));
            Storage::put("{$variantsBase}/{$width}/{$filename}", (string) $resized, 'public');
        }

        return $storagePath;
    }

    private function storeAvatar(string $publicRelativePath, string $fileName): string
    {
        $this->storeImage($publicRelativePath, config('avatar.original_path').'/'.$fileName);
        foreach (config('avatar.sizes') as $size) {
            $variantPath = sprintf(config('avatar.variant_pattern'), $size['width'], $size['height']);
            $this->storeImage($publicRelativePath, $variantPath.'/'.$fileName);
        }

        return $fileName;
    }

    public function run(): void
    {
        // Un compte par rôle avec un mot de passe simple pour la démo jury
        $jAdmin = User::factory()->create([
            'first_name' => 'Claire', 'last_name' => 'Admin',
            'email' => 'claire.admin@lefilrouge.com',
            'role' => UserRoles::ADMIN, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
            'birth_date' => '1985-06-12', 'phone' => '+32 470 00 00 01',
            'address' => 'Rue de la Paix', 'number' => '1',
            'city' => 'Bruxelles', 'province' => Provinces::BRUXELLES, 'postal_code' => 1000,
            'diet' => Diets::NORMAL,
            'avatar_path' => $this->storeAvatar('images/camps/holiday_3.webp', 'avatar_claire.jpg'),
        ]);

        $jFormateur = User::factory()->create([
            'first_name' => 'Marc', 'last_name' => 'Formateur',
            'email' => 'marc.formateur@lefilrouge.com',
            'role' => UserRoles::FORMATEUR, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
            'birth_date' => '1990-03-22', 'phone' => '+32 470 00 00 02',
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => 4000,
            'diet' => Diets::VEGETARIAN,
            'avatar_path' => $this->storeAvatar('images/camps/holiday_4.webp', 'avatar_marc.jpg'),
        ]);

        $jCoord = User::factory()->create([
            'first_name' => 'Sophie', 'last_name' => 'Coordinateur',
            'email' => 'sophie.coordinateur@lefilrouge.com',
            'role' => UserRoles::COORDINATEUR, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
            'birth_date' => '1992-11-08', 'phone' => '+32 470 00 00 03',
            'city' => 'Namur', 'province' => Provinces::NAMUR, 'postal_code' => 5000,
            'diet' => Diets::NORMAL,
            'avatar_path' => $this->storeAvatar('images/camps/holiday_5.webp', 'avatar_sophie.jpg'),
        ]);

        $jAnim1 = User::factory()->create([
            'first_name' => 'Alice', 'last_name' => 'Animateur',
            'email' => 'alice.animateur1re@lefilrouge.com',
            'role' => UserRoles::ANIMATEUR_1, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
            'birth_date' => '1998-07-15', 'phone' => '+32 470 00 00 04',
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => 4020,
            'diet' => Diets::NORMAL,
            'avatar_path' => $this->storeAvatar('images/trainings/fun_5.webp', 'avatar_alice.jpg'),
        ]);

        $jAnim2 = User::factory()->create([
            'first_name' => 'Thomas', 'last_name' => 'Animateur',
            'email' => 'thomas.animateur2e@lefilrouge.com',
            'role' => UserRoles::ANIMATEUR_2, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
            'birth_date' => '1995-02-28', 'phone' => '+32 470 00 00 05',
            'city' => 'Charleroi', 'province' => Provinces::HAINAUT, 'postal_code' => 6000,
            'diet' => Diets::NORMAL,
            'avatar_path' => $this->storeAvatar('images/trainings/fun_4.webp', 'avatar_thomas.jpg'),
        ]);

        $jBrevete = User::factory()->create([
            'first_name' => 'Julie', 'last_name' => 'Brevete',
            'email' => 'julie.brevete@lefilrouge.com',
            'role' => UserRoles::BREVETE, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
            'birth_date' => '1993-09-17', 'phone' => '+32 470 00 00 06',
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => 4000,
            'diet' => Diets::VEGAN,
            'avatar_path' => $this->storeAvatar('images/trainings/fun_3.webp', 'avatar_julie.jpg'),
        ]);

        $jArrivant = User::factory()->create([
            'first_name' => 'Noa', 'last_name' => 'Arrivant',
            'email' => 'noa.arrivant@lefilrouge.com',
            'role' => UserRoles::ARRIVANT, 'status' => UserStatus::INCOMPLETE,
            'password' => Hash::make('change_this'),
            'birth_date' => '2002-04-10', 'phone' => '+32 470 00 00 07',
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => 4000,
            'diet' => Diets::NORMAL,
            'avatar_path' => $this->storeAvatar('images/trainings/fun_2.webp', 'avatar_noa.jpg'),
        ]);

        // Comptes existants pour les inscriptions
        $hugo = User::where('email', 'hugo.formateur@lefilrouge.com')->first();
        $paul = User::where('email', 'paul.coordinateur@lefilrouge.com')->first();
        $lea = User::where('email', 'lea.animateur1re@lefilrouge.com')->first();
        $luc = User::where('email', 'luc.animateur2e@lefilrouge.com')->first();
        $tiffany = User::where('email', 'tiffany.brevete@lefilrouge.com')->first();
        $admin = User::where('email', 'mohamed.camara@lefilrouge.com')->first();

        // Formations supplémentaires pour enrichir le catalogue de la démo
        $tA = Training::create([
            'title' => 'Formation Communication Bienveillante',
            'description' => 'Apprends à communiquer avec les jeunes et leurs familles de façon claire, douce et efficace. Un outil indispensable pour éviter les malentendus et créer un lien de confiance durable.',
            'details' => 'Bases de la CNV (Communication Non-Violente), écoute active, reformulation, gestion des émotions en situation d\'animation, communication avec les parents. Ateliers en petits groupes et jeux de rôle débriefés.',
            'constraints' => null,
            'start_date' => now()->addDays(35)->setTime(9, 0)->toDateTimeString(),
            'end_date' => now()->addDays(35)->setTime(17, 0)->toDateTimeString(),
            'type' => TrainingTypes::NON_RESIDENTIAL,
            'status' => TrainingStatus::PUBLISHED,
            'price' => null, 'participants' => 16,
            'address' => 'Rue Douffet', 'number' => '36',
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => 4020,
            'roles' => [UserRoles::ANIMATEUR_1->value, UserRoles::ANIMATEUR_2->value, UserRoles::BREVETE->value, UserRoles::COORDINATEUR->value],
            'user_id' => $hugo?->id ?? $jFormateur->id,
            'banner' => $this->storeBanner('images/trainings/fun_1.webp', 'trainings/banners/pres_tA.webp'),
        ]);

        $tB = Training::create([
            'title' => 'Formation Activités Créatives et Manuelles',
            'description' => 'Enrichis ta boîte à outils avec des dizaines d\'activités créatives adaptées aux 6-16 ans. Peinture, land art, recyclage créatif : on fabrique ensemble des outils prêts à l\'emploi pour tes stages.',
            'details' => 'Fabrication de jeux en carton, ateliers land art, initiation à la sérigraphie, création d\'instruments DIY. Chaque participant repart avec un carnet de 10 activités testées et documentées.',
            'constraints' => null,
            'start_date' => now()->addDays(55)->setTime(9, 0)->toDateTimeString(),
            'end_date' => now()->addDays(55)->setTime(17, 0)->toDateTimeString(),
            'type' => TrainingTypes::NON_RESIDENTIAL,
            'status' => TrainingStatus::PUBLISHED,
            'price' => 1500, 'participants' => 14,
            'address' => 'Rue Léon Mignon', 'number' => '10',
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => 4000,
            'roles' => [UserRoles::ANIMATEUR_1->value, UserRoles::ANIMATEUR_2->value, UserRoles::BREVETE->value],
            'user_id' => $hugo?->id ?? $jFormateur->id,
            'banner' => $this->storeBanner('images/trainings/fun_2.webp', 'trainings/banners/pres_tB.webp'),
        ]);

        $tC = Training::create([
            'title' => 'Soirée Découverte — Présentation de l\'asso',
            'description' => 'Tu viens de rejoindre le Fil Rouge ? Cette soirée de 3h te présente l\'association, ses valeurs, son historique et les parcours disponibles. Une façon conviviale de commencer l\'aventure.',
            'details' => 'Présentation de l\'asso et de ses projets, témoignages de membres actifs, questions-réponses avec le bureau, moment convivial. Aucune inscription préalable requise.',
            'constraints' => null,
            'start_date' => now()->addDays(7)->setTime(18, 30)->toDateTimeString(),
            'end_date' => now()->addDays(7)->setTime(21, 30)->toDateTimeString(),
            'type' => TrainingTypes::NON_RESIDENTIAL,
            'status' => TrainingStatus::PUBLISHED,
            'price' => null, 'participants' => 30,
            'address' => 'Rue Douffet', 'number' => '36',
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => 4020,
            'roles' => [UserRoles::ANIMATEUR_1->value, UserRoles::ANIMATEUR_2->value, UserRoles::BREVETE->value],
            'user_id' => $admin?->id ?? $jAdmin->id,
            'banner' => $this->storeBanner('images/trainings/fun_3.webp', 'trainings/banners/pres_tC.webp'),
        ]);

        $tD = Training::create([
            'title' => 'Formation Gestion de Projet Associatif',
            'description' => 'Monter un projet de A à Z dans une asso, c\'est un vrai métier. Cette formation de deux jours te donne les outils pour définir des objectifs, répartir les tâches, gérer un budget simple et communiquer auprès des membres et partenaires.',
            'details' => 'Objectifs SMART, Gantt simplifié, gestion budgétaire associative, communication interne/externe, rétrospective de projet. Travail sur un projet réel apporté par les participants.',
            'constraints' => 'Réservé aux membres ayant au minimum 1 an d\'expérience dans l\'asso.',
            'start_date' => now()->addDays(80)->setTime(9, 0)->toDateTimeString(),
            'end_date' => now()->addDays(81)->setTime(17, 0)->toDateTimeString(),
            'type' => TrainingTypes::RESIDENTIAL,
            'status' => TrainingStatus::PUBLISHED,
            'price' => 3000, 'participants' => 12,
            'address' => 'Rue de Longdoz', 'number' => '5',
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => 4020,
            'roles' => [UserRoles::BREVETE->value, UserRoles::COORDINATEUR->value, UserRoles::FORMATEUR->value],
            'user_id' => $admin?->id ?? $jAdmin->id,
            'banner' => $this->storeBanner('images/trainings/fun_4.webp', 'trainings/banners/pres_tD.webp'),
        ]);

        $tE = Training::create([
            'title' => 'Formation Numérique et Réseaux Sociaux',
            'description' => 'Les jeunes sont sur les réseaux. Cette journée te donne les clés pour créer du contenu éducatif, gérer la communication d\'un stage et parler des réseaux avec les jeunes en toute lucidité.',
            'details' => 'Création de contenu pédagogique (Canva, CapCut), gestion d\'un compte Instagram pour une asso, éducation aux médias, cyberharcèlement, droit à l\'image pour les mineurs.',
            'constraints' => null,
            'start_date' => now()->addDays(42)->setTime(9, 0)->toDateTimeString(),
            'end_date' => now()->addDays(42)->setTime(17, 0)->toDateTimeString(),
            'type' => TrainingTypes::NON_RESIDENTIAL,
            'status' => TrainingStatus::PENDING,
            'price' => null, 'participants' => 20,
            'city' => 'Bruxelles', 'province' => Provinces::BRUXELLES, 'postal_code' => 1000,
            'roles' => [UserRoles::ANIMATEUR_1->value, UserRoles::ANIMATEUR_2->value, UserRoles::BREVETE->value, UserRoles::COORDINATEUR->value],
            'user_id' => $hugo?->id ?? $jFormateur->id,
            'banner' => $this->storeBanner('images/trainings/fun_5.webp', 'trainings/banners/pres_tE.webp'),
        ]);

        // Camps supplémentaires pour illustrer les types séjour et stage
        $cA = Camp::create([
            'title' => 'Séjour Nature et Bien-être',
            'description' => 'Trois jours pour se ressourcer et repartir avec de l\'énergie. Yoga, méditation, randonnée douce et ateliers bien-être dans un cadre naturel exceptionnel.',
            'details' => 'Yoga du matin, ateliers pleine conscience, cuisine saine collective, randonnée commentée, soirée astronomie. Hébergement en gîte écologique. Pas d\'évaluation — juste du soin.',
            'constraints' => 'Ouvert à tous les membres actifs. Aucun niveau requis.',
            'start_date' => now()->addDays(25)->setTime(16, 0)->toDateTimeString(),
            'end_date' => now()->addDays(27)->setTime(14, 0)->toDateTimeString(),
            'type' => CampTypes::SEJOUR,
            'status' => CampStatus::PUBLISHED,
            'participants' => 18,
            'address' => 'Chemin du Moulin', 'number' => '2',
            'city' => 'Durbuy', 'province' => Provinces::LUXEMBOURG, 'postal_code' => 6940,
            'roles' => [UserRoles::ANIMATEUR_1->value, UserRoles::ANIMATEUR_2->value, UserRoles::BREVETE->value, UserRoles::COORDINATEUR->value, UserRoles::FORMATEUR->value],
            'user_id' => $paul?->id ?? $jCoord->id,
            'banner' => $this->storeBanner('images/camps/holiday_3.webp', 'camps/banners/pres_cA.webp'),
        ]);

        $cB = Camp::create([
            'title' => 'Stage Multiactivités Été',
            'description' => 'Le stage estival incontournable. Dix jours en plein air pour les animateurs de première année, mixant apprentissage, aventure et convivialité.',
            'details' => 'Escalade, kayak, vélo, orienteering, nuits en bivouac, veillées, animations quotidiennes. Encadrement par deux formateurs permanents. Bilan individuel et collectif en fin de stage.',
            'constraints' => 'Avoir complété le stage 1er niveau. Savoir nager (50m minimum).',
            'start_date' => now()->addDays(100)->setTime(9, 0)->toDateTimeString(),
            'end_date' => now()->addDays(109)->setTime(17, 0)->toDateTimeString(),
            'type' => CampTypes::STAGE,
            'status' => CampStatus::PENDING,
            'participants' => 24,
            'address' => 'Rue du Barrage', 'number' => '8',
            'city' => 'Coo', 'province' => Provinces::LIEGE, 'postal_code' => 4970,
            'roles' => [UserRoles::ANIMATEUR_1->value, UserRoles::ANIMATEUR_2->value],
            'user_id' => $paul?->id ?? $jCoord->id,
            'banner' => $this->storeBanner('images/camps/holiday_4.webp', 'camps/banners/pres_cB.webp'),
        ]);

        $cC = Camp::create([
            'title' => 'Séjour Urbain — Bruxelles Solidaire',
            'description' => 'Trois jours à Bruxelles pour découvrir les projets associatifs de la capitale et créer des liens avec d\'autres structures de jeunesse.',
            'details' => 'Visite de 3 associations partenaires, rencontre avec des jeunes engagés, atelier d\'échange de pratiques, soirée multiculturelle, visite de quartier guidée par des habitants.',
            'constraints' => null,
            'start_date' => now()->addDays(48)->setTime(10, 0)->toDateTimeString(),
            'end_date' => now()->addDays(50)->setTime(16, 0)->toDateTimeString(),
            'type' => CampTypes::SEJOUR,
            'status' => CampStatus::PUBLISHED,
            'participants' => 14,
            'address' => 'Rue du Midi', 'number' => '24',
            'city' => 'Bruxelles', 'province' => Provinces::BRUXELLES, 'postal_code' => 1000,
            'roles' => [UserRoles::ANIMATEUR_1->value, UserRoles::ANIMATEUR_2->value, UserRoles::BREVETE->value, UserRoles::COORDINATEUR->value],
            'user_id' => $paul?->id ?? $jCoord->id,
            'banner' => $this->storeBanner('images/camps/holiday_5.webp', 'camps/banners/pres_cC.webp'),
        ]);

        // Photos de galerie associées aux camps et formations de la démo
        foreach (['holiday', 'holiday_1', 'holiday_2'] as $img) {
            Galerie::create([
                'camp_id' => $cA->id,
                'path' => $this->storeImage("images/camps/{$img}.webp", "camps/galeries/{$img}_pres_cA.webp"),
            ]);
        }
        foreach (['holiday_3', 'holiday_4'] as $img) {
            Galerie::create([
                'camp_id' => $cC->id,
                'path' => $this->storeImage("images/camps/{$img}.webp", "camps/galeries/{$img}_pres_cC.webp"),
            ]);
        }
        foreach (['fun', 'fun_1', 'fun_2'] as $img) {
            Galerie::create([
                'training_id' => $tC->id,
                'path' => $this->storeImage("images/trainings/{$img}.webp", "trainings/galeries/{$img}_pres_tC.webp"),
            ]);
        }

        // Inscriptions aux formations avec différents statuts pour la démo
        TrainingRegister::create(['training_id' => $tA->id, 'user_id' => $jAnim1->id,  'status' => RegisterStatus::PENDING, 'notes' => 'Première inscription sur la plateforme.']);
        TrainingRegister::create(['training_id' => $tA->id, 'user_id' => $jAnim2->id,  'status' => RegisterStatus::PENDING]);
        TrainingRegister::create(['training_id' => $tA->id, 'user_id' => $jBrevete->id, 'status' => RegisterStatus::ACCEPTED]);
        if ($lea) {
            TrainingRegister::create(['training_id' => $tA->id, 'user_id' => $lea->id,     'status' => RegisterStatus::ACCEPTED]);
        }
        if ($luc) {
            TrainingRegister::create(['training_id' => $tA->id, 'user_id' => $luc->id,     'status' => RegisterStatus::PENDING, 'notes' => 'Doit confirmer avant jeudi.']);
        }

        TrainingRegister::create(['training_id' => $tB->id, 'user_id' => $jAnim1->id,  'status' => RegisterStatus::ACCEPTED]);
        TrainingRegister::create(['training_id' => $tB->id, 'user_id' => $jAnim2->id,  'status' => RegisterStatus::PENDING]);
        if ($lea) {
            TrainingRegister::create(['training_id' => $tB->id, 'user_id' => $lea->id,     'status' => RegisterStatus::ACCEPTED]);
        }

        TrainingRegister::create(['training_id' => $tC->id, 'user_id' => $jBrevete->id, 'status' => RegisterStatus::ACCEPTED]);
        if ($tiffany) {
            TrainingRegister::create(['training_id' => $tC->id, 'user_id' => $tiffany->id, 'status' => RegisterStatus::ACCEPTED]);
        }
        if ($luc) {
            TrainingRegister::create(['training_id' => $tC->id, 'user_id' => $luc->id,     'status' => RegisterStatus::REFUSED, 'notes' => 'Absent ce soir-là.']);
        }

        TrainingRegister::create(['training_id' => $tD->id, 'user_id' => $jCoord->id,  'status' => RegisterStatus::PENDING]);

        // Inscriptions aux camps avec différents statuts pour la démo
        CampRegister::create(['camp_id' => $cA->id, 'user_id' => $jAnim1->id,  'status' => RegisterStatus::ACCEPTED]);
        CampRegister::create(['camp_id' => $cA->id, 'user_id' => $jAnim2->id,  'status' => RegisterStatus::PENDING, 'notes' => 'Attend la réponse de son employeur.']);
        CampRegister::create(['camp_id' => $cA->id, 'user_id' => $jBrevete->id, 'status' => RegisterStatus::ACCEPTED]);
        if ($lea) {
            CampRegister::create(['camp_id' => $cA->id, 'user_id' => $lea->id,     'status' => RegisterStatus::ACCEPTED]);
        }
        if ($tiffany) {
            CampRegister::create(['camp_id' => $cA->id, 'user_id' => $tiffany->id, 'status' => RegisterStatus::ACCEPTED]);
        }

        CampRegister::create(['camp_id' => $cC->id, 'user_id' => $jAnim1->id,  'status' => RegisterStatus::PENDING]);
        if ($luc) {
            CampRegister::create(['camp_id' => $cC->id, 'user_id' => $luc->id,     'status' => RegisterStatus::ACCEPTED]);
        }

        // Annonces supplémentaires publiées pour alimenter la page actualités
        Announcement::create([
            'title' => 'Nouvelle plateforme en ligne !',
            'description' => 'Le Fil Rouge lance son espace numérique pour simplifier vos inscriptions et centraliser toutes les informations.',
            'content' => "Après plusieurs mois de développement, nous sommes heureux de vous présenter la nouvelle plateforme du Fil Rouge.\n\nVous pouvez désormais :\n• Consulter toutes nos formations et stages\n• Vous inscrire en quelques clics\n• Gérer votre profil et vos documents\n• Suivre l'état de vos inscriptions en temps réel\n\nCette plateforme a été pensée pour vous — n'hésitez pas à nous faire vos retours.",
            'details' => 'Pour toute question ou suggestion, contactez-nous via le formulaire de contact. Nous lisons tous les messages.',
            'published_at' => now()->subDays(5),
            'user_id' => $admin?->id ?? $jAdmin->id,
            'banner' => $this->storeBanner('images/trainings/fun.webp', 'announcements/banners/pres_ann1.webp'),
        ]);

        Announcement::create([
            'title' => 'Appel à formateurs — Session automne',
            'description' => 'Vous avez de l\'expérience et envie de la transmettre ? Rejoignez notre équipe de formateurs pour la saison automne 2025.',
            'content' => "Le Fil Rouge recherche des formateurs pour compléter son équipe.\n\nNous cherchons des profils avec :\n• Minimum 3 ans d'expérience en animation ou coordination\n• Brevet d'animateur ou équivalent\n• Disponibilité sur au moins 2 week-ends entre septembre et décembre\n\nIntéressé·e ? Envoyez votre candidature via le formulaire de contact.",
            'details' => null,
            'published_at' => now()->subDays(10),
            'user_id' => $admin?->id ?? $jAdmin->id,
            'banner' => $this->storeBanner('images/trainings/fun_2.webp', 'announcements/banners/pres_ann2.webp'),
        ]);

        Announcement::create([
            'title' => 'Félicitations aux nouveaux brevetés !',
            'description' => 'Douze membres ont obtenu leur brevet d\'animateur lors de la session de juin. Bravo à toutes et tous !',
            'content' => "C'est avec une grande fierté que nous annonçons que 12 membres ont validé leur brevet d'animateur reconnu par la Fédération Wallonie-Bruxelles.\n\nCe brevet leur ouvre la porte à l'encadrement légal de mineurs en Belgique. Chaque brevet est le fruit de mois de formation, de stages pratiques et d'évaluations.\n\nFélicitations à chacun d'entre eux — le Fil Rouge est fier de vous avoir accompagnés !",
            'details' => null,
            'published_at' => now()->subDays(18),
            'user_id' => $admin?->id ?? $jAdmin->id,
            'banner' => $this->storeBanner('images/camps/holiday_2.webp', 'announcements/banners/pres_ann3.webp'),
        ]);

        Announcement::create([
            'title' => 'Fermeture estivale du secrétariat',
            'description' => 'Le secrétariat sera fermé du 15 au 31 juillet. Les inscriptions en ligne restent ouvertes.',
            'content' => "Toute l'équipe du Fil Rouge prend une pause bien méritée du 15 au 31 juillet 2025.\n\nPendant cette période :\n• Le secrétariat est fermé — pas de réponse aux emails ni aux appels\n• La plateforme reste accessible 24h/24 pour vos inscriptions\n• Les réponses aux candidatures seront traitées à partir du 1er août\n\nNous vous souhaitons un bel été !",
            'details' => null,
            'published_at' => now()->subDays(3),
            'user_id' => $admin?->id ?? $jAdmin->id,
            'banner' => $this->storeBanner('images/camps/holiday.webp', 'announcements/banners/pres_ann4.webp'),
        ]);

        // Commentaires laissés par les membres sur les formations publiées
        $trainings = Training::where('status', TrainingStatus::PUBLISHED)->get();
        $members = collect(array_filter([$lea, $luc, $tiffany, $jAnim1, $jAnim2, $jBrevete]));

        $formComments = [
            'Super formation, très concrète et bien rythmée. Je repars avec des outils immédiatement utilisables !',
            'Formateur à l\'écoute, ambiance bienveillante. J\'aurais voulu que ça dure plus longtemps.',
            'Très bonne expérience. La partie pratique m\'a vraiment aidé à mieux comprendre les concepts.',
            'Je recommande à tous les animateurs qui veulent se perfectionner. Contenu de qualité.',
            'Les mises en situation étaient vraiment pertinentes. On est vraiment dans le bain dès le début.',
            'Bien organisé, formateurs avec une vraie expertise terrain. Ça change des formations purement théoriques.',
            'Quelques points un peu denses, mais globalement très satisfait·e. À refaire !',
            'La journée est passée très vite — c\'est bon signe ! Merci à l\'équipe du Fil Rouge.',
        ];

        foreach ($trainings->take(5) as $i => $training) {
            $a1 = $members->get($i % $members->count());
            $a2 = $members->get(($i + 1) % $members->count());
            $a3 = $members->get(($i + 2) % $members->count());
            if ($a1) {
                Comment::create(['content' => $formComments[$i % count($formComments)],       'user_id' => $a1->id, 'training_id' => $training->id, 'is_admin' => false]);
            }
            if ($a2) {
                Comment::create(['content' => $formComments[($i + 1) % count($formComments)],   'user_id' => $a2->id, 'training_id' => $training->id, 'is_admin' => false]);
            }
            if ($a3) {
                Comment::create(['content' => $formComments[($i + 2) % count($formComments)],   'user_id' => $a3->id, 'training_id' => $training->id, 'is_admin' => false]);
            }
        }

        // Commentaires laissés par les membres sur les camps publiés
        $camps = Camp::where('status', CampStatus::PUBLISHED)->get();
        $campComments = [
            'Un séjour inoubliable. L\'équipe encadrante est au top, le cadre magnifique.',
            'Excellent programme, bien dosé entre théorie et pratique. On repart motivé·e !',
            'Les soirées thématiques étaient un vrai plus. J\'ai créé des liens pour longtemps.',
            'Très bien organisé. La nourriture était bonne aussi — c\'est important !',
            'Je reviens l\'année prochaine c\'est certain.',
            'Belle découverte de la région. Les activités outdoor étaient vraiment bien pensées.',
        ];

        foreach ($camps->take(5) as $i => $camp) {
            $a1 = $members->get($i % $members->count());
            $a2 = $members->get(($i + 1) % $members->count());
            if ($a1) {
                Comment::create(['content' => $campComments[$i % count($campComments)],     'user_id' => $a1->id, 'camp_id' => $camp->id, 'is_admin' => false]);
            }
            if ($a2) {
                Comment::create(['content' => $campComments[($i + 1) % count($campComments)], 'user_id' => $a2->id, 'camp_id' => $camp->id, 'is_admin' => false]);
            }
        }

        // Messages reçus via le formulaire de contact public
        ContactMessage::create(['full_name' => 'Antoine Dubois',  'email' => 'antoine.dubois@gmail.com',  'sujet' => 'Question sur les inscriptions',  'message' => 'Bonjour, je n\'arrive pas à finaliser mon inscription au stage d\'été. Mon paiement a bien été effectué mais je ne reçois pas de confirmation. Pouvez-vous vérifier ?',                                                                                                                                   'read_at' => null]);
        ContactMessage::create(['full_name' => 'Marie Fontaine',  'email' => 'marie.fontaine@outlook.be', 'sujet' => 'Demande de renseignements',       'message' => 'Bonsoir, je cherche une formation aux premiers secours pour mes animateurs bénévoles. Proposez-vous des sessions en entreprise ou uniquement dans vos locaux ? Merci d\'avance.',                                                                                                                               'read_at' => null]);
        ContactMessage::create(['full_name' => 'Romain Charlier', 'email' => 'romain.ch@hotmail.com',    'sujet' => 'Partenariat associatif',           'message' => 'Bonjour, je représente l\'association "Jeunes Actifs" de Namur. Nous serions intéressés par un partenariat pour co-organiser des stages l\'an prochain. Seriez-vous ouverts à en discuter ?',                                                                                                               'read_at' => null]);
        ContactMessage::create(['full_name' => 'Isabelle Leroy',  'email' => 'isa.leroy@gmail.com',      'sujet' => 'Félicitations pour la plateforme', 'message' => 'Je voulais juste vous dire que la nouvelle plateforme est vraiment bien faite ! C\'est simple, clair, et j\'ai pu m\'inscrire au stage en 2 minutes. Bravo à l\'équipe !',                                                                                                                                 'read_at' => now()->subHours(2)]);

        // Demandes de bénévolat soumises via le formulaire public
        VolunteerRequest::create(['first_name' => 'Kevin', 'last_name' => 'Marchal', 'email' => 'kevin.marchal@gmail.com',  'phone' => '+32 471 55 66 77', 'message' => 'Animateur depuis 4 ans dans une maison de jeunes à Seraing. Je cherche à rejoindre une structure plus structurée pour évoluer vers la formation. Le Fil Rouge correspond exactement à ce que je cherche.', 'status' => VolunteerRequestStatus::PENDING,  'read_at' => null]);
        VolunteerRequest::create(['first_name' => 'Emma',  'last_name' => 'Piron',   'email' => 'emma.piron@hotmail.be',    'phone' => '+32 479 33 44 55', 'message' => 'Étudiante en éducation sociale, je souhaite acquérir une expérience pratique en animation. Je suis disponible les week-ends et pendant les vacances scolaires.',                                                     'status' => VolunteerRequestStatus::PENDING,  'read_at' => null]);
        VolunteerRequest::create(['first_name' => 'David', 'last_name' => 'Renard',  'email' => 'david.renard@gmail.com',   'phone' => '+32 496 12 23 34', 'message' => 'Moniteur de natation et animateur scout depuis 6 ans. Brevet d\'animateur FWB en cours de validation. Je veux m\'investir dans une asso qui forme sérieusement ses membres.',                                       'status' => VolunteerRequestStatus::ACCEPTED, 'read_at' => now()->subDays(2)]);
    }
}
