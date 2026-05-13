<!DOCTYPE html>
<html lang="cs" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>GG STORE - Herní Portál</title>
</head>
<!-- 
    1. ZMĚNA POZADÍ: Z obyčejné šedé na velmi temnou fialovou/indigo (#0F0A1A) 
    Text je lehce stříbrný (text-slate-300), aby nebyl ostře bílý a neunavoval oči.
-->
<body class="bg-[#0F0A1A] text-slate-300 min-h-screen font-sans flex flex-col selection:bg-[#C44DFF] selection:text-white">

    <!-- 
        2. HLAVIČKA: Přechod od tmavší fialovo-černé k úplně černé. 
        Přidán jemný fialový stín na spodní hranu (shadow-[#C44DFF]/10).
    -->
    <header class="bg-gradient-to-b from-[#1A122E] to-[#0A0710] border-b border-[#2A1D47] shadow-[0_4px_30px_rgba(196,77,255,0.1)] relative z-10">
        
        <!-- Jemná neonová linka na vrchu obrazovky pro "gaming" efekt -->
        <div class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-[#C44DFF] to-transparent opacity-50"></div>

        <div class="container mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center relative">
            
            <!-- ODKAZ S LOGEM (S tvou velikostí h-24) -->
            <a href="<?= BASE_URL ?>/index.php" class="transition-transform hover:scale-105 active:scale-95 drop-shadow-[0_0_15px_rgba(196,77,255,0.3)]">
                <img src="<?= BASE_URL ?>/images/logo.png" alt="GG STORE" class="h-20 md:h-24 w-auto object-contain">
            </a>
            
            <nav class="mt-4 md:mt-0 w-full md:w-auto">
                <ul class="flex flex-wrap justify-center md:justify-end items-center gap-6">
                    
                    <!-- Klasický odkaz: Při hoveru svítí fialově a text zbělá -->
                    <li>
                        <a href="<?= BASE_URL ?>/index.php" class="text-slate-300 hover:text-white hover:drop-shadow-[0_0_8px_#C44DFF] transition-all font-medium tracking-wide">
                            Nabídka her
                        </a>
                    </li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Tlačítko Přidat hru: Teď je to opravdové fialové tlačítko s neonovým efektem -->
                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=game/create" class="bg-gradient-to-r from-[#C44DFF] to-[#8E24DD] hover:from-[#d170ff] hover:to-[#9f2bf2] text-white px-5 py-2.5 rounded-lg transition-all shadow-[0_0_15px_rgba(196,77,255,0.4)] hover:shadow-[0_0_25px_rgba(196,77,255,0.6)] border border-[#d170ff]/50 text-sm font-bold uppercase tracking-wider">
                                + Přidat hru
                            </a>
                        </li>

                        <!-- SPECIÁLNÍ ODKAZ POUZE PRO ADMINA (Změněno ze žluté na stříbrnou/neonovou) -->
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=user/index" class="text-[#a8b1ff] hover:text-white hover:drop-shadow-[0_0_8px_#a8b1ff] transition-all font-medium text-sm tracking-wide">
                                Správa uživatelů
                            </a>
                        </li>
                        <?php endif; ?>

                        <li class="text-slate-400 text-sm hidden sm:block">
                            <!-- Uživatelské jméno lehce do fialova -->
                            Ahoj, <span class="text-[#e2b3ff] font-semibold tracking-wider"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                        </li>
                        
                        <!-- Odhlásit: Výraznější hover efekt -->
                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=auth/logout" class="text-rose-400/80 hover:text-rose-400 hover:drop-shadow-[0_0_8px_#fb7185] transition-all text-sm uppercase tracking-wider font-semibold">
                                Odhlásit
                            </a>
                        </li>

                    <?php else: ?>
                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-slate-300 hover:text-white hover:drop-shadow-[0_0_8px_#C44DFF] transition-all font-medium tracking-wide">
                                Přihlásit
                            </a>
                        </li>
                        <!-- Registrace: Decentní tmavé tlačítko s fialovým lemem -->
                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="bg-[#1A122E] hover:bg-[#2A1D47] text-white px-5 py-2.5 rounded-lg transition-all border border-[#C44DFF]/30 hover:border-[#C44DFF] shadow-inner font-medium">
                                Registrace
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Zprávy (Flash messages) jsem sladil do temnějšího stylu -->
    <div class="container mx-auto px-6 pt-8">
        <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
            <div class="space-y-3">
                <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                    <?php 
                        $styles = [
                            'success' => 'bg-[#0f2e1b] border-[#10b981] text-[#34d399]',
                            'error'   => 'bg-[#3b1219] border-[#f43f5e] text-[#fb7185]',
                            'notice'  => 'bg-[#2A1D47] border-[#C44DFF] text-[#e2b3ff]', // Notice je teď v barvě brandu
                        ];
                        $style = $styles[$type] ?? 'bg-[#1A122E] border-slate-500 text-slate-300';
                    ?>
                    <?php foreach ($messages as $message): ?>
                        <div class="<?= $style ?> border-l-4 p-4 rounded-r-lg shadow-[0_4px_20px_rgba(0,0,0,0.5)]">
                            <p class="font-medium text-sm tracking-wide"><?= htmlspecialchars($message) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php unset($_SESSION['messages']); ?>
            </div>
        <?php endif; ?>
    </div>