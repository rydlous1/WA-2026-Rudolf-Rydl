<?php

 /** @var array $categories */

require_once '../app/views/layout/header.php'; 
?>  

<main class="container mx-auto px-6 py-6 flex-grow flex items-center justify-center">
    <div class="w-full max-w-5xl">
        <div class="mb-4 flex justify-between items-end border-b border-white/10 pb-2">
            <h2 class="text-3xl font-black text-white italic uppercase tracking-tighter">
                Přidat <span class="text-[#C44DFF]">Novou Hru</span>
            </h2>
            <a href="<?= BASE_URL ?>/index.php" class="text-slate-500 hover:text-white text-xs uppercase tracking-widest font-bold transition-colors">&larr; ZPĚT</a>
        </div>
        
        <div class="bg-[#1A122E]/80 border border-white/10 rounded-2xl p-8 backdrop-blur-xl shadow-2xl">
            <form action="<?= BASE_URL ?>/index.php?url=game/store" method="post" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-5">
                    
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-[#C44DFF] uppercase tracking-[0.2em] mb-1">Název hry *</label>
                        <input type="text" name="title" required placeholder="např. Grand Theft Auto V" class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2.5 text-white outline-none focus:border-[#C44DFF] transition-all">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-[#C44DFF] uppercase tracking-[0.2em] mb-1">Kategorie *</label>
                        <select name="category_id" required class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2.5 text-white outline-none focus:border-[#C44DFF] transition-all cursor-pointer">
                            <option value="">Vyberte žánr...</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= htmlspecialchars($cat['id']) ?>" class="bg-[#1A122E]"><?= htmlspecialchars($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-[#C44DFF] uppercase tracking-[0.2em] mb-1">Vývojář *</label>
                        <input type="text" name="developer" required class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2.5 text-white outline-none focus:border-[#C44DFF]">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-[#C44DFF] uppercase tracking-[0.2em] mb-1">Vydavatel</label>
                        <input type="text" name="publisher" class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2.5 text-white outline-none focus:border-[#C44DFF]">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-[#C44DFF] uppercase tracking-[0.2em] mb-1">Rok vydání *</label>
                        <input type="number" name="release_year" required class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2.5 text-white outline-none focus:border-[#C44DFF]">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-[#C44DFF] uppercase tracking-[0.2em] mb-1">Platforma</label>
                        <input type="text" name="platform" class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2.5 text-white outline-none focus:border-[#C44DFF]">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-[#C44DFF] uppercase tracking-[0.2em] mb-1">Cena (Kč)</label>
                        <input type="number" name="price" step="0.01" class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2.5 text-white outline-none focus:border-[#C44DFF]">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-[#C44DFF] uppercase tracking-[0.2em] mb-1">Odkaz (Steam/Epic)</label>
                        <input type="text" name="link" class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2.5 text-white outline-none focus:border-[#C44DFF]">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-[#C44DFF] uppercase tracking-[0.2em] mb-1">Popis hry</label>
                        <textarea name="description" rows="3" class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-3 text-white outline-none focus:border-[#C44DFF] transition-all"></textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-[#C44DFF] uppercase tracking-[0.2em] mb-1">Obrázek</label>
                        <input type="file" name="images[]" multiple accept="image/*" class="text-[10px] text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-[#C44DFF] file:text-black file:font-black file:uppercase file:cursor-pointer">
                    </div>
                </div>
                <button type="submit" class="w-full mt-8 bg-[#C44DFF] hover:bg-[#d170ff] text-black font-black py-4 rounded-xl uppercase tracking-widest transition-all shadow-lg shadow-[#C44DFF]/20 active:scale-95">ULOŽIT HRU DO DATABÁZE</button>
            </form>
        </div>
    </div>
</main>
<?php require_once '../app/views/layout/footer.php'; ?>