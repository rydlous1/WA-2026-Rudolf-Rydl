<?php
/** @var array $games */
require_once '../app/views/layout/header.php'; 
?>

    <main class="container mx-auto px-6 py-10 flex-grow relative z-10">
        
        <div class="flex justify-between items-end mb-10">
            <h2 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white to-[#a8b1ff] uppercase tracking-tighter italic border-l-4 border-[#C44DFF] pl-4 pr-2">Dostupné hry</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            
            <?php if (empty($games)): ?>
                <div class="col-span-full py-20 text-center border-2 border-dashed border-[#2A1D47] rounded-2xl bg-[#1A122E]/50">
                    <p class="text-slate-400 italic">V databázi se zatím nenachází žádné hry.</p>
                </div>
            <?php else: ?>
                <?php foreach ($games as $game): ?>
                    <div class="bg-[#1A122E]/80 backdrop-blur-sm border border-[#2A1D47] rounded-2xl overflow-hidden shadow-xl transition-all duration-300 hover:-translate-y-2 hover:border-[#C44DFF]/60 flex flex-col group">
                        
                        <div class="aspect-video bg-[#0F0A1A] relative overflow-hidden flex items-center justify-center">
                            <?php 
                                $imageValue = $game['images'] ?? '';
                                $cleanName = str_replace(['[', ']', '"', "'"], '', $imageValue);
                                $cleanName = trim($cleanName);
                            ?>
                            
                            <?php if (!empty($cleanName)): ?>
                                <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($cleanName) ?>" 
                                     alt="<?= htmlspecialchars($game['title']) ?>" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <?php else: ?>
                                <div class="w-full h-full bg-gradient-to-br from-[#2A1D47] to-[#0F0A1A] flex items-center justify-center text-[#C44DFF] font-bold p-4 text-center uppercase opacity-50">
                                    <?= htmlspecialchars($game['title']) ?>
                                </div>
                            <?php endif; ?>

                            <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-t from-[#1A122E] to-transparent"></div>
                            <div class="absolute top-3 right-3 bg-black/60 backdrop-blur-md text-[#e2b3ff] text-xs px-2.5 py-1 rounded border border-[#C44DFF]/20 font-bold">
                                <?= htmlspecialchars($game['release_year'] ?? '-') ?>
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <p class="text-[#C44DFF] text-[10px] uppercase font-black mb-1 opacity-80 tracking-widest">
                                <?= htmlspecialchars($game['developer'] ?? 'Neznámý vývojář') ?>
                            </p>
                            <h3 class="text-white font-bold text-2xl group-hover:text-[#C44DFF] transition-colors mb-6 leading-tight">
                                <?= htmlspecialchars($game['title']) ?>
                            </h3>

                            <div class="mt-auto pt-5 border-t border-[#2A1D47]/70 flex justify-between items-center">
                                
                                <div class="flex gap-6">
                                    <div class="flex flex-col">
                                        <span class="text-slate-500 text-[10px] uppercase font-bold tracking-widest">Cena</span>
                                        <span class="text-white font-black text-xl italic tracking-tight">
                                            <?= number_format($game['price'] ?? 0, 0, ',', ' ') ?> Kč
                                        </span>
                                    </div>

                                    <div class="flex flex-col border-l border-[#2A1D47] pl-4">
                                        <span class="text-slate-500 text-[10px] uppercase font-bold tracking-widest">Žánr</span>
                                        <span class="text-emerald-400 font-bold text-sm uppercase italic tracking-tighter">
                                            <?= htmlspecialchars($game['category_name'] ?? 'Neuvedeno') ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col gap-2 items-end">
                                    <a href="<?= BASE_URL ?>/index.php?url=game/show/<?= htmlspecialchars($game['id']) ?>" 
                                       class="text-[10px] bg-[#C44DFF]/10 hover:bg-[#C44DFF] text-[#C44DFF] hover:text-white px-5 py-2 rounded-lg border border-[#C44DFF]/30 font-black transition-all uppercase tracking-widest">
                                        Detail
                                    </a>
                                    
                                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                        <div class="flex gap-4 mt-1">
                                            <a href="<?= BASE_URL ?>/index.php?url=game/edit/<?= htmlspecialchars($game['id']) ?>" class="text-[9px] text-emerald-500 hover:text-emerald-300 transition-colors uppercase font-bold tracking-wider">Upravit</a>
                                            <a href="<?= BASE_URL ?>/index.php?url=game/delete/<?= htmlspecialchars($game['id']) ?>" 
                                               onclick="return confirm('Opravdu smazat?')" 
                                               class="text-[9px] text-rose-500 hover:text-rose-300 transition-colors uppercase font-bold tracking-wider">Smazat</a>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <footer class="mt-auto border-t border-[#2A1D47]/50 py-8 text-center bg-[#0A0710]/80 relative z-20">
        <p class="text-slate-500 text-sm tracking-widest uppercase italic">&copy; 2026 GG STORE - Herní portál</p>
    </footer>
</body>
</html>