<?php
/** @var array $games */
?>
<!DOCTYPE html>
<html lang="cs" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>GG STORE - Herní Portál</title>
</head>
<body class="bg-[#0F0A1A] text-slate-300 min-h-screen font-sans flex flex-col selection:bg-[#C44DFF] selection:text-white">

    <!-- HLAVIČKA -->
    <header class="bg-gradient-to-b from-[#1A122E] to-[#0A0710] border-b border-[#2A1D47] shadow-[0_4px_30px_rgba(196,77,255,0.1)] relative z-10">
        <div class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-[#C44DFF] to-transparent opacity-50"></div>
        <div class="container mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center relative">
            
            <a href="<?= BASE_URL ?>/index.php" class="transition-transform hover:scale-105 active:scale-95 drop-shadow-[0_0_15px_rgba(196,77,255,0.3)]">
                
                <img src="<?= BASE_URL ?>/images/logo.png" alt="GG STORE" class="h-20 md:h-24 w-auto object-contain">
            </a>
            
            <nav class="mt-4 md:mt-0 w-full md:w-auto">
                <ul class="flex flex-wrap justify-center md:justify-end items-center gap-6">
                    <li>
                        <a href="<?= BASE_URL ?>/index.php" class="text-slate-300 hover:text-white hover:drop-shadow-[0_0_8px_#C44DFF] transition-all font-medium tracking-wide">
                            Nabídka her
                        </a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/index.php?url=game/create" class="bg-gradient-to-r from-[#C44DFF] to-[#8E24DD] hover:from-[#d170ff] hover:to-[#9f2bf2] text-white px-5 py-2.5 rounded-lg transition-all shadow-[0_0_15px_rgba(196,77,255,0.4)] hover:shadow-[0_0_25px_rgba(196,77,255,0.6)] border border-[#d170ff]/50 text-sm font-bold uppercase tracking-wider">
                            + Přidat hru
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- ZPRÁVY (Flash messages) -->
    <div class="container mx-auto px-6 pt-8">
        <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
            <div class="space-y-3">
                <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                    <?php 
                        $styles = [
                            'success' => 'bg-[#0f2e1b] border-[#10b981] text-[#34d399]',
                            'error'   => 'bg-[#3b1219] border-[#f43f5e] text-[#fb7185]',
                            'notice'  => 'bg-[#2A1D47] border-[#C44DFF] text-[#e2b3ff]',
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

    <!-- HLAVNÍ OBSAH (Grid s hrami z databáze) -->
    <main class="container mx-auto px-6 py-10 flex-grow">
        
        <div class="flex justify-between items-end mb-8">
            <h2 class="text-2xl font-bold text-white uppercase tracking-[0.2em] border-l-4 border-[#C44DFF] pl-4">Dostupné hry</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <?php if (empty($games)): ?>
                <!-- Když je databáze prázdná -->
                <div class="col-span-full py-20 text-center border-2 border-dashed border-[#2A1D47] rounded-2xl">
                    <p class="text-slate-500 italic">V databázi se zatím nenachází žádné hry.</p>
                </div>
            <?php else: ?>
                <!-- Výpis karet z databáze -->
                <?php foreach ($games as $game): ?>
                    <div class="bg-[#1A122E] border border-[#2A1D47] rounded-2xl overflow-hidden shadow-lg transition-all hover:border-[#C44DFF]/50 hover:shadow-[0_0_30px_rgba(196,77,255,0.15)] group">
                        
                        <div class="aspect-video bg-[#0F0A1A] relative overflow-hidden flex items-center justify-center">
                            <!-- Pokud zatím nemáš obrázky, generuje to fialový placeholder se jménem hry -->
                            <div class="w-full h-full bg-gradient-to-br from-[#2A1D47] to-[#0F0A1A] flex items-center justify-center text-[#C44DFF] font-bold tracking-widest opacity-50 group-hover:scale-110 transition-transform duration-500 p-4 text-center uppercase">
                                <?= htmlspecialchars($game['title']) ?>
                            </div>
                            <div class="absolute top-3 right-3 bg-black/60 backdrop-blur-md text-[#e2b3ff] text-[10px] px-2 py-1 rounded border border-[#C44DFF]/20 font-mono">
                                <?= htmlspecialchars($game['release_year']) ?>
                            </div>
                        </div>

                        <div class="p-6">
                            <p class="text-[#C44DFF] text-[10px] uppercase tracking-[0.2em] font-bold mb-1">
                                <?= htmlspecialchars($game['developer']) ?>
                            </p>
                            <h3 class="text-white font-bold text-xl group-hover:text-[#C44DFF] transition-colors mb-4 truncate">
                                <?= htmlspecialchars($game['title']) ?>
                            </h3>

                            <div class="flex justify-between items-center pt-4 border-t border-[#2A1D47]">
                                <div class="flex flex-col">
                                    <span class="text-slate-500 text-[10px] uppercase font-bold tracking-tighter">Cena</span>
                                    <span class="text-white font-black text-xl italic"><?= htmlspecialchars($game['price']) ?> Kč</span>
                                </div>
                                
                                <div class="flex flex-col gap-2 items-end">
                                    <a href="<?= BASE_URL ?>/index.php?url=game/show/<?= htmlspecialchars($game['id']) ?>" class="text-xs bg-[#C44DFF]/10 hover:bg-[#C44DFF] text-[#C44DFF] hover:text-white px-4 py-2 rounded border border-[#C44DFF]/20 transition-all font-bold text-center">DETAIL</a>
                                    <div class="flex gap-3 mt-1">
                                        <a href="<?= BASE_URL ?>/index.php?url=game/edit/<?= htmlspecialchars($game['id']) ?>" class="text-[10px] text-emerald-400 hover:text-white transition-colors underline">Upravit</a>
                                        <a href="<?= BASE_URL ?>/index.php?url=game/delete/<?= htmlspecialchars($game['id']) ?>" onclick="return confirm('Opravdu chcete tuto hru smazat?')" class="text-[10px] text-rose-400 hover:text-white transition-colors underline">Smazat</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </main>

    <!-- PATIČKA -->
    <footer class="mt-auto border-t border-[#2A1D47] py-8 text-center bg-[#0A0710]">
        <p class="text-slate-500 text-sm tracking-widest uppercase italic">
            &copy; 2026 GG STORE - Herní portál
        </p>
    </footer>

</body>
</html>