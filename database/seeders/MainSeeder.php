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
use App\Models\ContactMessage;
use App\Models\Galerie;
use App\Models\Training;
use App\Models\TrainingRegister;
use App\Models\User;
use App\Models\VolunteerRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MainSeeder extends Seeder
{
    use WithoutModelEvents;

    // Copie une image de public/ vers le disk par défaut (s3 en prod, local en dev)
    private function storeImage(string $publicRelativePath, string $storagePath): string
    {
        $fullPath = public_path($publicRelativePath);
        if (file_exists($fullPath)) {
            Storage::put($storagePath, file_get_contents($fullPath), 'public');
        }
        return $storagePath;
    }

    // Bannière + variants (640, 1024, 1440)
    private function storeBanner(string $publicRelativePath, string $storagePath): string
    {
        $this->storeImage($publicRelativePath, $storagePath);
        $filename = basename($storagePath);
        $variantsBase = dirname($storagePath) . '/variants';
        foreach (config('banners.sizes.banner') as $size) {
            $this->storeImage($publicRelativePath, "{$variantsBase}/{$size}/{$filename}");
        }
        return $storagePath;
    }

    // Avatar + variants (80x80, 300x300, 600x600)
    private function storeAvatar(string $publicRelativePath, string $fileName): string
    {
        $this->storeImage($publicRelativePath, config('avatar.original_path') . '/' . $fileName);
        foreach (config('avatar.sizes') as $size) {
            $variantPath = sprintf(config('avatar.variant_pattern'), $size['width'], $size['height']);
            $this->storeImage($publicRelativePath, $variantPath . '/' . $fileName);
        }
        return $fileName;
    }

    public function run(): void
    {
        // ── Users ──────────────────────────────────────────────────────────
        $admin = User::factory()->create([
            'first_name' => 'Mohamed', 'last_name' => 'Camara',
            'email' => 'mohamed.camara@lefilrouge.com',
            'role' => UserRoles::ADMIN, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
            'birth_date' => '1997-03-15', 'phone' => '0472/51.38.37',
            'address' => 'Rue du Vallon', 'number' => '12',
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => '4000',
            'diet' => Diets::NORMAL,
            'avatar_path' => $this->storeAvatar('images/trainings/fun.webp', 'avatar_admin.jpg'),
        ]);

        $stephanie = User::factory()->create([
            'first_name' => 'Stéphanie', 'last_name' => 'Admin',
            'email' => 'stephanie.admin@lefilrouge.com',
            'role' => UserRoles::ADMIN, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
            'avatar_path' => $this->storeAvatar('images/trainings/fun_1.webp', 'avatar_stephanie.jpg'),
        ]);

        $hugo = User::factory()->create([
            'first_name' => 'Hugo', 'last_name' => 'Formateur',
            'email' => 'hugo.formateur@lefilrouge.com',
            'role' => UserRoles::FORMATEUR, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
            'avatar_path' => $this->storeAvatar('images/trainings/fun_2.webp', 'avatar_hugo.jpg'),
        ]);

        $paul = User::factory()->create([
            'first_name' => 'Paul', 'last_name' => 'Coordinateur',
            'email' => 'paul.coordinateur@lefilrouge.com',
            'role' => UserRoles::COORDINATEUR, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
            'avatar_path' => $this->storeAvatar('images/camps/holiday.webp', 'avatar_paul.jpg'),
        ]);

        $tiffany = User::factory()->create([
            'first_name' => 'Tiffany', 'last_name' => 'Brevete',
            'email' => 'tiffany.brevete@lefilrouge.com',
            'role' => UserRoles::BREVETE, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
            'avatar_path' => $this->storeAvatar('images/trainings/fun_3.webp', 'avatar_tiffany.jpg'),
        ]);

        $luc = User::factory()->create([
            'first_name' => 'Luc', 'last_name' => 'Animateur',
            'email' => 'luc.animateur2e@lefilrouge.com',
            'role' => UserRoles::ANIMATEUR_2, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
            'avatar_path' => $this->storeAvatar('images/camps/holiday_1.webp', 'avatar_luc.jpg'),
        ]);

        $lea = User::factory()->create([
            'first_name' => 'Léa', 'last_name' => 'Animateur',
            'email' => 'lea.animateur1re@lefilrouge.com',
            'role' => UserRoles::ANIMATEUR_1, 'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
            'avatar_path' => $this->storeAvatar('images/camps/holiday_2.webp', 'avatar_lea.jpg'),
        ]);

        $sam = User::factory()->create([
            'first_name' => 'Sam', 'last_name' => 'Arrivant',
            'email' => 'sam.arrivant@lefilrouge.com',
            'role' => UserRoles::ARRIVANT, 'status' => UserStatus::INCOMPLETE,
            'password' => Hash::make('change_this'),
            'avatar_path' => $this->storeAvatar('images/trainings/fun_4.webp', 'avatar_sam.jpg'),
        ]);

        // ── Camps ──────────────────────────────────────────────────────────
        $camp1 = Camp::create([
            'title' => 'Stage Animateur 1er niveau – Été 2025',
            'description' => 'Ce stage de 8 jours est le point de départ de ton parcours d\'animateur. Tu vas travailler avec des groupes de jeunes de 6 à 12 ans dans un cadre résidentiel en Ardenne. On te forme à la fois sur la théorie et sur la pratique, avec des mises en situation réelles dès le premier jour. L\'objectif : que tu repartes avec les outils concrets pour animer en toute confiance et en toute sécurité.',
            'details' => 'Au programme : dynamique de groupe, construction d\'activités ludiques et pédagogiques, gestion des conflits entre jeunes, cadre légal lié à l\'encadrement de mineurs, sécurité physique et émotionnelle. Chaque soir une veillée thématique organisée par les participants eux-mêmes. Une équipe de formateurs expérimentés t\'accompagne tout au long du stage avec des feedbacks individualisés.',
            'constraints' => 'Minimum 16 ans révolus au premier jour du stage. Engagement sur les 8 jours complets obligatoire, les absences partielles ne sont pas acceptées. Une fiche médicale complète est exigée avant le départ.',
            'start_date' => now()->addDays(10)->setTime(9,0)->toDateTimeString(), 'end_date' => now()->addDays(17)->setTime(17,0)->toDateTimeString(),
            'type' => CampTypes::STAGE, 'status' => CampStatus::PUBLISHED,
            'participants' => 20,
            'address' => 'Rue de la Lienne', 'number' => '5',
            'city' => 'Stoumont', 'province' => Provinces::LIEGE, 'postal_code' => '4987',
            'roles' => [UserRoles::ANIMATEUR_1->value, UserRoles::ANIMATEUR_2->value, UserRoles::BREVETE->value],
            'user_id' => $admin->id,
            'banner' => $this->storeBanner('images/camps/holiday.webp', 'camps/banners/holiday.webp'),
        ]);

        $camp2 = Camp::create([
            'title' => 'Séjour Découverte Ardennes',
            'description' => 'Cinq jours en pleine nature ardennaise pour renforcer tes compétences de terrain tout en découvrant une région magnifique. Ce séjour mélange apprentissage et convivialité : on travaille sérieusement, mais dans une ambiance détendue et bienveillante. Idéal pour approfondir ce que tu as acquis lors de tes premiers stages et enrichir ton réseau au sein de l\'asso.',
            'details' => 'Randonnées en autonomie avec carte et boussole, veillées à thème animées en rotation par les participants, ateliers nature (bivouac, reconnaissance de plantes, faune locale), travail en équipe sur des projets courts. Les hébergements sont en gîte collectif, repas préparés ensemble. Un accompagnateur expérimenté est présent en permanence.',
            'constraints' => null,
            'start_date' => now()->addDays(30)->setTime(10,0)->toDateTimeString(), 'end_date' => now()->addDays(34)->setTime(16,0)->toDateTimeString(),
            'type' => CampTypes::SEJOUR, 'status' => CampStatus::PUBLISHED,
            'participants' => 15,
            'address' => 'Rue du Moulin', 'number' => '3',
            'city' => 'La Roche-en-Ardenne', 'province' => Provinces::LUXEMBOURG, 'postal_code' => '6980',
            'roles' => [UserRoles::ANIMATEUR_1->value, UserRoles::ANIMATEUR_2->value, UserRoles::BREVETE->value, UserRoles::COORDINATEUR->value],
            'user_id' => $stephanie->id,
            'banner' => $this->storeBanner('images/camps/holiday_1.webp', 'camps/banners/holiday_1.webp'),
        ]);

        $camp3 = Camp::create([
            'title' => 'Stage Brevet d\'Animateur – Session automne',
            'description' => 'Le stage brevet est l\'étape clé de ton parcours d\'animateur au sein du Fil Rouge. Reconnu par la Fédération Wallonie-Bruxelles, ce stage de 10 jours intensifs te permet d\'obtenir ton brevet d\'animateur officiel, indispensable pour encadrer légalement des activités avec des mineurs en Belgique. On alterne théorie et pratique avec des évaluations tout au long du stage.',
            'details' => 'Programme officiel FWB : pédagogie de projet, animation de grands groupes, gestion des situations d\'urgence, cadre déontologique et réglementaire, dossier de stage individuel à remettre. Chaque participant encadre au minimum deux demi-journées d\'animation réelle, observée et débriefée par les formateurs. L\'évaluation finale est individuelle, orale et pratique.',
            'constraints' => 'Minimum 18 ans au premier jour du stage. Avoir effectué le stage 1er niveau avant de s\'inscrire est obligatoire. Une attestation du stage précédent peut être demandée.',
            'start_date' => now()->addDays(60)->setTime(9,0)->toDateTimeString(), 'end_date' => now()->addDays(69)->setTime(17,0)->toDateTimeString(),
            'type' => CampTypes::STAGE, 'status' => CampStatus::PUBLISHED,
            'participants' => 12,
            'address' => 'Avenue des Tilleuls', 'number' => '18',
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => '4000',
            'roles' => [UserRoles::ANIMATEUR_1->value, UserRoles::ANIMATEUR_2->value],
            'user_id' => $admin->id,
            'banner' => $this->storeBanner('images/camps/holiday_2.webp', 'camps/banners/holiday_2.webp'),
        ]);

        $camp4 = Camp::create([
            'title' => 'Camp Solidarité – Projet de quartier',
            'description' => 'Cinq jours d\'engagement concret dans des quartiers liégeois en partenariat avec des associations locales. Pas un stage classique : ici on se retrousse les manches pour contribuer à des projets réels qui ont un impact direct sur la vie des gens du quartier. Peinture de locaux associatifs, organisation d\'activités pour des enfants, mise en place d\'un potager collectif… chaque édition est différente.',
            'details' => 'Les participants travaillent en petits groupes autonomes avec un référent de terrain. Logement chez l\'habitant ou en hébergement collectif selon les disponibilités. Bilan collectif chaque soir. Ce camp n\'est pas noté ni certifiant, il est là pour ancrer la pratique dans le réel.',
            'constraints' => null,
            'start_date' => now()->subDays(20)->setTime(9,0)->toDateTimeString(), 'end_date' => now()->subDays(16)->setTime(17,0)->toDateTimeString(),
            'type' => CampTypes::SEJOUR, 'status' => CampStatus::PENDING,
            'participants' => 25,
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => '4000',
            'roles' => [UserRoles::ANIMATEUR_1->value, UserRoles::ANIMATEUR_2->value, UserRoles::BREVETE->value, UserRoles::COORDINATEUR->value],
            'user_id' => $paul->id,
            'banner' => $this->storeBanner('images/camps/holiday_3.webp', 'camps/banners/holiday_3.webp'),
        ]);

        $camp5 = Camp::create([
            'title' => 'Stage Coordination d\'équipe',
            'description' => 'Tu animes depuis un moment et tu veux passer à la coordination ? Ce stage intensif t\'apprend à gérer une équipe d\'animateurs, à planifier un projet sur plusieurs semaines et à communiquer efficacement avec les familles, les partenaires et l\'administration. Un vrai saut de rôle, bien accompagné.',
            'details' => 'Mises en situation de coordination, gestion de crises et imprévus, communication assertive, répartition des rôles dans une équipe, animation de réunions et d\'espaces de bilan. On travaille sur des cas réels issus de l\'asso. Travail individuel sur son propre style de leadership.',
            'constraints' => null,
            'start_date' => now()->subDays(45)->setTime(9,0)->toDateTimeString(), 'end_date' => now()->subDays(41)->setTime(17,0)->toDateTimeString(),
            'type' => CampTypes::STAGE, 'status' => CampStatus::REFUSED,
            'participants' => 10,
            'city' => 'Namur', 'province' => Provinces::NAMUR, 'postal_code' => '5000',
            'roles' => [UserRoles::BREVETE->value, UserRoles::COORDINATEUR->value],
            'user_id' => $paul->id,
            'banner' => $this->storeBanner('images/camps/holiday_4.webp', 'camps/banners/holiday_4.webp'),
        ]);

        // ── Galeries camps ─────────────────────────────────────────────────
        foreach (['holiday_3', 'holiday_4', 'holiday_5', 'holiday_1', 'holiday_2'] as $img) {
            Galerie::create([
                'camp_id' => $camp1->id,
                'path' => $this->storeImage("images/camps/{$img}.webp", "camps/galeries/{$img}.webp"),
            ]);
        }
        foreach (['holiday', 'holiday_2', 'holiday_3'] as $img) {
            Galerie::create([
                'camp_id' => $camp2->id,
                'path' => $this->storeImage("images/camps/{$img}.webp", "camps/galeries/{$img}_c2.webp"),
            ]);
        }
        foreach (['holiday_4', 'holiday_5'] as $img) {
            Galerie::create([
                'camp_id' => $camp3->id,
                'path' => $this->storeImage("images/camps/{$img}.webp", "camps/galeries/{$img}_c3.webp"),
            ]);
        }

        // ── Camp registers (uniquement pour les camps PUBLISHED, sans arrivant) ──
        CampRegister::create(['camp_id' => $camp1->id, 'user_id' => $tiffany->id, 'status' => RegisterStatus::ACCEPTED, 'notes' => 'Déjà animé en maison de jeunes, veut valider ses acquis avec un stage officiel.']);
        CampRegister::create(['camp_id' => $camp1->id, 'user_id' => $luc->id,     'status' => RegisterStatus::ACCEPTED]);
        CampRegister::create(['camp_id' => $camp1->id, 'user_id' => $lea->id,     'status' => RegisterStatus::ACCEPTED, 'notes' => 'Veut consolider les bases avant de tenter le brevet en automne.']);
        CampRegister::create(['camp_id' => $camp2->id, 'user_id' => $tiffany->id, 'status' => RegisterStatus::ACCEPTED]);
        CampRegister::create(['camp_id' => $camp2->id, 'user_id' => $paul->id,    'status' => RegisterStatus::PENDING,  'notes' => 'Se confirme la semaine prochaine selon ses dispo.']);
        CampRegister::create(['camp_id' => $camp3->id, 'user_id' => $lea->id,     'status' => RegisterStatus::ACCEPTED]);
        CampRegister::create(['camp_id' => $camp3->id, 'user_id' => $luc->id,     'status' => RegisterStatus::PENDING,  'notes' => 'Attend confirmation de son employeur pour les congés.']);

        // ── Trainings ──────────────────────────────────────────────────────
        $training1 = Training::create([
            'title' => 'Formation Premiers Secours (PSC1)',
            'description' => 'Tu travailles avec des jeunes ? La formation aux premiers secours, c\'est la base absolue. Cette journée reconnue par la Croix-Rouge de Belgique te prépare à réagir calmement et efficacement face à une urgence, que ce soit sur le terrain d\'un stage, dans un local ou en pleine nature. Une journée qui peut littéralement sauver une vie.',
            'details' => 'Au programme : gestes de survie (PLS, Heimlich, compression de plaie), réanimation cardio-pulmonaire (RCP) avec mannequin, utilisation d\'un défibrillateur automatisé (DEA), prise en charge des bobos courants (chute, coupure, brûlure, malaise). Tout se fait en petits groupes avec un formateur certifié. Une attestation de participation est remise en fin de journée.',
            'constraints' => 'Aucun prérequis. Formation accessible à tous les niveaux. Tenue confortable recommandée pour les exercices au sol.',
            'start_date' => now()->addDays(5)->setTime(9,0)->toDateTimeString(), 'end_date' => now()->addDays(5)->setTime(17,0)->toDateTimeString(),
            'type' => TrainingTypes::NON_RESIDENTIAL, 'status' => TrainingStatus::PUBLISHED,
            'price' => 2000, 'participants' => 16,
            'address' => 'Rue Douffet', 'number' => '36',
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => '4020',
            'roles' => [UserRoles::ANIMATEUR_1->value, UserRoles::ANIMATEUR_2->value, UserRoles::BREVETE->value, UserRoles::COORDINATEUR->value],
            'user_id' => $stephanie->id,
            'banner' => $this->storeBanner('images/trainings/fun.webp', 'trainings/banners/fun.webp'),
        ]);

        $training2 = Training::create([
            'title' => 'Formation Pédagogie Active et Jeu',
            'description' => 'Le jeu, c\'est du sérieux. Cette formation de deux jours te donne des outils concrets et immédiatement réutilisables pour rendre tes animations plus dynamiques, plus engageantes et plus efficaces. On ne parle pas théorie en salle : on expérimente, on joue, on débriefe. Tu repars avec une boîte à outils pédagogique bien garnie.',
            'details' => 'Ateliers ludiques, jeux coopératifs et de rôle, techniques de débriefing et d\'animation de groupe, création d\'outils pédagogiques sur mesure adaptés à ton public. Chaque participant repart avec un carnet d\'activités conçu pendant la formation. Possibilité de mutualiser avec d\'autres participants pour enrichir sa pratique.',
            'constraints' => null,
            'start_date' => now()->addDays(20)->setTime(9,0)->toDateTimeString(), 'end_date' => now()->addDays(21)->setTime(17,0)->toDateTimeString(),
            'type' => TrainingTypes::NON_RESIDENTIAL, 'status' => TrainingStatus::PUBLISHED,
            'price' => null, 'participants' => 20,
            'address' => 'Rue Douffet', 'number' => '36',
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => '4020',
            'roles' => [UserRoles::ANIMATEUR_1->value, UserRoles::ANIMATEUR_2->value, UserRoles::BREVETE->value, UserRoles::COORDINATEUR->value],
            'user_id' => $hugo->id,
            'banner' => $this->storeBanner('images/trainings/fun_1.webp', 'trainings/banners/fun_1.webp'),
        ]);

        $training3 = Training::create([
            'title' => 'Formation Gestion des Conflits',
            'description' => 'Les tensions dans un groupe, ça arrive — entre participants, avec les familles, ou au sein de l\'équipe encadrante. Cette formation de deux jours te donne les clés pour repérer les conflits naissants, agir avant l\'escalade et trouver des solutions durables. Pas de recettes miracles, mais des techniques éprouvées et adaptables à tes situations réelles.',
            'details' => 'Communication non-violente (CNV) appliquée à l\'animation, médiation entre jeunes, gestion des émotions fortes, posture de l\'animateur en situation difficile, jeux de rôle sur des cas concrets issus du terrain. Travail en binômes et en petits groupes. Chaque session est débriefée collectivement pour ancrer les apprentissages.',
            'constraints' => 'Avoir au moins 6 mois d\'expérience active en animation est requis pour pouvoir participer pleinement aux mises en situation.',
            'start_date' => now()->addDays(45)->setTime(9,0)->toDateTimeString(), 'end_date' => now()->addDays(46)->setTime(17,0)->toDateTimeString(),
            'type' => TrainingTypes::NON_RESIDENTIAL, 'status' => TrainingStatus::PUBLISHED,
            'price' => 4000, 'participants' => 14,
            'city' => 'Namur', 'province' => Provinces::NAMUR, 'postal_code' => '5000',
            'roles' => [UserRoles::ANIMATEUR_2->value, UserRoles::BREVETE->value, UserRoles::COORDINATEUR->value],
            'user_id' => $admin->id,
            'banner' => $this->storeBanner('images/trainings/fun_2.webp', 'trainings/banners/fun_2.webp'),
        ]);

        $training4 = Training::create([
            'title' => 'Week-end Résidentiel Leadership',
            'description' => 'Deux jours en résidentiel dans les Hautes Fagnes pour travailler ton leadership et apprendre à porter un projet collectif de A à Z. Formation intensive mais bienveillante : on pousse chacun à se dépasser tout en restant dans un cadre sécurisant. Idéal pour les animateurs qui veulent évoluer vers la coordination ou la formation.',
            'details' => 'Diagnostic de son style de leadership, travail sur la communication en situation de stress, animation de réunions et de prises de décision collectives, gestion des désaccords dans une équipe, feedback structuré entre participants. Soirée de bilan et de projection personnelle le samedi. Logement et repas inclus dans le tarif.',
            'constraints' => 'Réservé aux animateurs ayant au minimum deux saisons d\'expérience. Places limitées à 10 participants pour garantir un accompagnement individualisé.',
            'start_date' => now()->addDays(75)->setTime(14,0)->toDateTimeString(), 'end_date' => now()->addDays(76)->setTime(17,0)->toDateTimeString(),
            'type' => TrainingTypes::RESIDENTIAL, 'status' => TrainingStatus::PUBLISHED,
            'price' => 4000, 'participants' => 10,
            'address' => 'Chemin des Fagnes', 'number' => '2',
            'city' => 'Malmedy', 'province' => Provinces::LIEGE, 'postal_code' => '4960',
            'roles' => [UserRoles::ANIMATEUR_2->value, UserRoles::BREVETE->value, UserRoles::COORDINATEUR->value],
            'user_id' => $stephanie->id,
            'banner' => $this->storeBanner('images/trainings/fun_3.webp', 'trainings/banners/fun_3.webp'),
        ]);

        $training5 = Training::create([
            'title' => 'Formation Inclusion et Handicap',
            'description' => 'Comment accueillir un jeune en situation de handicap dans ton groupe d\'animation sans le stigmatiser ni le mettre à l\'écart ? Cette journée te donne les clés pratiques pour adapter tes activités, communiquer avec les familles et créer un environnement réellement inclusif. Parce que chaque jeune a le droit de trouver sa place.',
            'details' => 'Tour d\'horizon des différents types de handicap (moteur, cognitif, sensoriel, psychique), adaptations concrètes d\'activités existantes, communication avec les aidants et les familles, cadre légal de l\'inclusion en Belgique, ressources locales disponibles. Intervention d\'un professionnel du secteur du handicap.',
            'constraints' => null,
            'start_date' => now()->subDays(30)->setTime(9,0)->toDateTimeString(), 'end_date' => now()->subDays(30)->setTime(17,0)->toDateTimeString(),
            'type' => TrainingTypes::NON_RESIDENTIAL, 'status' => TrainingStatus::PENDING,
            'price' => null, 'participants' => 18,
            'city' => 'Liège', 'province' => Provinces::LIEGE, 'postal_code' => '4000',
            'roles' => [UserRoles::ANIMATEUR_1->value, UserRoles::ANIMATEUR_2->value, UserRoles::BREVETE->value, UserRoles::COORDINATEUR->value],
            'user_id' => $hugo->id,
            'banner' => $this->storeBanner('images/trainings/fun_4.webp', 'trainings/banners/fun_4.webp'),
        ]);

        // ── Galeries trainings ─────────────────────────────────────────────
        foreach (['fun_1', 'fun_2', 'fun_3', 'fun_4', 'fun_5'] as $img) {
            Galerie::create([
                'training_id' => $training1->id,
                'path' => $this->storeImage("images/trainings/{$img}.webp", "trainings/galeries/{$img}.webp"),
            ]);
        }
        foreach (['fun', 'fun_3', 'fun_4'] as $img) {
            Galerie::create([
                'training_id' => $training2->id,
                'path' => $this->storeImage("images/trainings/{$img}.webp", "trainings/galeries/{$img}_t2.webp"),
            ]);
        }
        foreach (['fun_5', 'fun_2'] as $img) {
            Galerie::create([
                'training_id' => $training3->id,
                'path' => $this->storeImage("images/trainings/{$img}.webp", "trainings/galeries/{$img}_t3.webp"),
            ]);
        }

        // ── Training registers (uniquement pour les formations PUBLISHED, sans arrivant) ──
        TrainingRegister::create(['training_id' => $training1->id, 'user_id' => $tiffany->id, 'status' => RegisterStatus::ACCEPTED, 'notes' => 'Renouvellement PSC1, attestation précédente expirée.']);
        TrainingRegister::create(['training_id' => $training1->id, 'user_id' => $luc->id,     'status' => RegisterStatus::ACCEPTED]);
        TrainingRegister::create(['training_id' => $training1->id, 'user_id' => $lea->id,     'status' => RegisterStatus::ACCEPTED]);
        TrainingRegister::create(['training_id' => $training1->id, 'user_id' => $paul->id,    'status' => RegisterStatus::ACCEPTED]);
        TrainingRegister::create(['training_id' => $training2->id, 'user_id' => $lea->id,     'status' => RegisterStatus::ACCEPTED, 'notes' => 'Veut enrichir ses outils pédago avant le stage brevet.']);
        TrainingRegister::create(['training_id' => $training2->id, 'user_id' => $luc->id,     'status' => RegisterStatus::PENDING,  'notes' => 'Intéressé, veut tester des nouvelles méthodes avec ses groupes.']);
        TrainingRegister::create(['training_id' => $training3->id, 'user_id' => $tiffany->id, 'status' => RegisterStatus::ACCEPTED]);
        TrainingRegister::create(['training_id' => $training3->id, 'user_id' => $paul->id,    'status' => RegisterStatus::PENDING,  'notes' => 'Situation difficile vécue cet été, veut mieux outiller.']);

        // ── Announcements ──────────────────────────────────────────────────
        $ann1 = Announcement::create([
            'title' => 'Bilan de l\'été 2024',
            'description' => 'L\'été 2024 c\'était chaud. Retour sur une saison avec plus de 150 participants et 12 stages dans toute la Wallonie.',
            'content' => 'Quelle saison ! On a accueilli 152 jeunes sur 12 stages répartis partout en Wallonie. Merci à tous les anim, coord et formateurs qui ont rendu ça possible. On remet ça encore mieux l\'année prochaine.',
            'published_at' => now()->subMonths(4),
            'user_id' => $admin->id,
            'banner' => $this->storeBanner('images/home/about.webp', 'announcements/banners/about.webp'),
        ]);

        Announcement::create([
            'title' => 'On cherche des bénévoles pour le printemps !',
            'description' => 'T\'as du temps cet printemps ? On a besoin de toi pour encadrer nos stages. Viens nous rejoindre !',
            'content' => 'Si t\'es anim, coord ou formateur et que t\'as des dispo ce printemps 2025, on a des postes pour toi. Réunion d\'info le 15 février à 18h au local. Viens, y\'aura des croque-monsieurs.',
            'published_at' => now()->subMonths(2),
            'user_id' => $admin->id,
            'banner' => $this->storeBanner('images/home/camps.webp', 'announcements/banners/camps.webp'),
        ]);

        Announcement::create([
            'title' => 'Mise à jour du règlement intérieur',
            'description' => 'Petit update du règlement suite à l\'AG de janvier. Prends 5 min pour lire les changements.',
            'content' => 'Suite à l\'AG du 12 janvier 2025, on a mis à jour quelques articles. Les principaux changements : procédures d\'inscription aux stages, conditions d\'annulation et règles en résidentiel. Le doc complet est dispo sur demande.',
            'published_at' => now()->subWeeks(3),
            'user_id' => $stephanie->id,
            'banner' => $this->storeBanner('images/home/formations.webp', 'announcements/banners/regl.webp'),
        ]);

        Announcement::create([
            'title' => 'Résultats du stage brevet – déc. 2024',
            'description' => 'Bravo aux 8 nouveaux brevetés ! Ils ont assuré lors de l\'éval de décembre.',
            'content' => '8 sur 10, c\'est le résultat du stage brevet de décembre 2024. Un grand bravo à Anaïs, Romain, Charlotte, Théo, Jade, Bastien, Inès et Mathieu ! Vos brevets vous seront remis à la prochaine réunion.',
            'published_at' => now()->subMonths(3),
            'user_id' => $admin->id,
            'banner' => $this->storeBanner('images/home/formations.webp', 'announcements/banners/formations.webp'),
        ]);

        Announcement::create([
            'title' => 'Fermeture estivale du secrétariat',
            'description' => 'Le secrétariat ferme du 15 juillet au 15 août. Les inscriptions en ligne restent ouvertes.',
            'content' => 'Cet été, le secrétariat est fermé du 15 juillet au 15 août. Pour toute urgence, écris-nous à contact@lefilrouge.com. Les inscriptions aux formations restent ouvertes via la plateforme, on répond dès la rentrée.',
            'published_at' => now()->subWeeks(1),
            'user_id' => $stephanie->id,
            'banner' => $this->storeBanner('images/home/about.webp', 'announcements/banners/fermeture.webp'),
        ]);

        $ann6 = Announcement::create([
            'title' => 'Nouvelle formation dispo : Gestion des conflits',
            'description' => 'Une nouvelle formation débarque en septembre à Namur. Parfaite si tu galères parfois avec les tensions dans ton groupe.',
            'content' => 'On lance une formation gestion des conflits en septembre à Namur. 2 jours pour apprendre à gérer les tensions dans un groupe de jeunes, sans perdre les pédales. Places limitées, inscris-toi vite !',
            'published_at' => now()->subDays(4),
            'user_id' => $admin->id,
            'banner' => $this->storeBanner('images/home/hero.webp', 'announcements/banners/hero.webp'),
        ]);

        // ── Galeries announcements ─────────────────────────────────────────
        foreach (['holiday', 'holiday_1', 'holiday_2'] as $img) {
            Galerie::create([
                'announcement_id' => $ann1->id,
                'path' => $this->storeImage("images/camps/{$img}.webp", "announcements/galeries/{$img}.webp"),
            ]);
        }
        foreach (['fun', 'fun_1'] as $img) {
            Galerie::create([
                'announcement_id' => $ann6->id,
                'path' => $this->storeImage("images/trainings/{$img}.webp", "announcements/galeries/{$img}_a6.webp"),
            ]);
        }

        // ── Comments ───────────────────────────────────────────────────────
        $camp1->comments()->createMany([
            ['content' => 'Les jeunes sont super engagés cette année, ça fait plaisir !',      'user_id' => $admin->id,    'is_admin' => true],
            ['content' => 'On fait une soirée inter-groupes le mercredi ? Ce serait sympa 👀', 'user_id' => $tiffany->id,  'is_admin' => false],
            ['content' => 'Bonne idée Tiff, je m\'en occupe 👍',                               'user_id' => $admin->id,    'is_admin' => true],
        ]);
        $camp2->comments()->createMany([
            ['content' => 'Les hébergs sont confirmés pour le séjour ?',   'user_id' => $paul->id,      'is_admin' => false],
            ['content' => 'Oui c\'est bon, check tes mails 😉',            'user_id' => $stephanie->id, 'is_admin' => true],
        ]);
        $camp3->comments()->createMany([
            ['content' => 'J\'ai quelques questions sur le programme du brevet.',  'user_id' => $lea->id,   'is_admin' => false],
            ['content' => 'Envoie-nous un mail ou passe au local !',               'user_id' => $admin->id, 'is_admin' => true],
        ]);
        $training1->comments()->createMany([
            ['content' => 'Super formation, le formateur était vraiment top !',    'user_id' => $tiffany->id,   'is_admin' => false],
            ['content' => 'Merci Tiff 😊 content que ça t\'ait plu.',             'user_id' => $stephanie->id, 'is_admin' => true],
            ['content' => 'Ya une autre session prévue en automne ?',              'user_id' => $luc->id,       'is_admin' => false],
            ['content' => 'On est en train de la planifier, stay tuned 🙌',        'user_id' => $stephanie->id, 'is_admin' => true],
        ]);
        $training2->comments()->createMany([
            ['content' => 'Hâte de tester les outils pédago avec mon groupe !',   'user_id' => $lea->id,  'is_admin' => false],
            ['content' => 'On te réserve des surprises, à très vite 😄',           'user_id' => $hugo->id, 'is_admin' => false],
        ]);
        $training3->comments()->createMany([
            ['content' => 'Vraiment nécessaire cette formation, on en a besoin sur le terrain.',    'user_id' => $paul->id,  'is_admin' => false],
            ['content' => 'Contenu d\'accord 💯 À très vite en septembre !',                       'user_id' => $admin->id, 'is_admin' => true],
        ]);
        $ann6->comments()->createMany([
            ['content' => 'Enfin ! J\'attendais ça depuis un moment.',             'user_id' => $luc->id,   'is_admin' => false],
            ['content' => 'On savait que ça allait vous plaire 😄 Inscris-toi !', 'user_id' => $admin->id, 'is_admin' => true],
        ]);

        // ── Contact messages ───────────────────────────────────────────────
        ContactMessage::create(['full_name' => 'Emma Dupont',    'email' => 'emma.dupont@gmail.com',       'sujet' => 'Inscription stage animateur', 'message' => 'Bonjour, je cherche à m\'inscrire au stage animateur de cet été mais je trouve pas le formulaire sur le site. Tu peux m\'aider ? Merci !', 'read_at' => now()->subDays(2)]);
        ContactMessage::create(['full_name' => 'Thomas Renard',  'email' => 'thomas.renard@hotmail.be',    'sujet' => 'Prérequis stage brevet',      'message' => 'Salut, j\'ai 17 ans et je voudrais faire le stage brevet. Est-ce que mon âge pose problème ? Quels sont les prérequis exactement ?', 'read_at' => null]);
        ContactMessage::create(['full_name' => 'Antoine Masson', 'email' => 'antoine.masson@outlook.com',  'sujet' => 'Remboursement annulation',    'message' => 'Bonjour, j\'ai dû annuler ma place au stage de mars pour raison médicale. J\'avais payé 75€. Comment ça se passe pour le remboursement ? J\'ai un certif médical.', 'read_at' => null]);
        ContactMessage::create(['full_name' => 'Lucie Fontaine', 'email' => 'lucie.fontaine@gmail.com',    'sujet' => 'Don à l\'asso',               'message' => 'Bonjour, je voudrais faire un don à votre asso. C\'est possible ? Et est-ce que c\'est déductible fiscalement ?', 'read_at' => now()->subDays(1)]);
        ContactMessage::create(['full_name' => 'Romain Charlier', 'email' => 'romain.charlier@gmail.com', 'sujet' => 'Attestation de participation', 'message' => 'Bonjour, j\'ai fait le stage animateur en juillet 2024 et j\'ai besoin d\'une attestation de participation pour mon dossier. Comment je peux l\'avoir ?', 'read_at' => null]);
        ContactMessage::create(['full_name' => 'Jade Mercier',   'email' => 'jade.mercier@gmail.com',      'sujet' => 'Info sur les formations',     'message' => 'Salut ! Je viens d\'obtenir mon brevet et je cherche ce que je peux faire comme formation maintenant pour continuer à progresser. Vous avez un parcours conseillé ?', 'read_at' => now()->subHours(3)]);

        // ── Volunteer requests ─────────────────────────────────────────────
        VolunteerRequest::create(['first_name' => 'Camille', 'last_name' => 'Peeters', 'email' => 'camille.peeters@gmail.com',         'phone' => '0487/22.33.44', 'message' => 'Animatrice depuis 3 ans dans une maison de jeunes à Seraing, je veux rejoindre Le Fil Rouge pour continuer à me former et rencontrer d\'autres anim. Dispo les week-ends et pendant les congés scolaires.', 'status' => VolunteerRequestStatus::ACCEPTED]);
        VolunteerRequest::create(['first_name' => 'Nathan',  'last_name' => 'Dubois',  'email' => 'nathan.dubois@student.uliege.be',  'phone' => '0476/55.66.77', 'message' => 'Étudiant en sciences de l\'éduc à l\'ULiège, je cherche une asso sérieuse pour compléter ma formation pratique. J\'ai mon brevet depuis 2023 et j\'ai déjà encadré quelques stages.', 'status' => VolunteerRequestStatus::PENDING]);
        VolunteerRequest::create(['first_name' => 'Sofia',   'last_name' => 'Martins', 'email' => 'sofia.martins@gmail.com',           'phone' => '0465/11.22.33', 'message' => 'Pas encore de brevet mais plein de motivation ! J\'ai déjà bossé dans plusieurs projets jeunesse et je veux vraiment me former correctement. Je suis partante pour commencer par le stage 1er niveau.', 'status' => VolunteerRequestStatus::PENDING]);
        VolunteerRequest::create(['first_name' => 'Julien',  'last_name' => 'Lambert', 'email' => 'julien.lambert@hotmail.com',        'phone' => '0499/88.77.66', 'message' => 'J\'ai fait plusieurs stages avec Le Fil Rouge et j\'aimerais maintenant aider en tant que bénévole formateur. 8 ans d\'expérience en anim, je pense pouvoir apporter quelque chose.', 'status' => VolunteerRequestStatus::REJECTED]);
        VolunteerRequest::create(['first_name' => 'Inès',    'last_name' => 'Nguyen',  'email' => 'ines.nguyen@gmail.com',             'phone' => '0478/44.55.66', 'message' => 'Diplômée en anim socioculturelle, dispo tout de suite. Je parle aussi néerlandais et anglais ce qui peut être utile pour certains groupes. J\'attends votre retour avec impatience !', 'status' => VolunteerRequestStatus::ACCEPTED]);
    }
}
