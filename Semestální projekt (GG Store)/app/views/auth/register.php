<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 flex-grow flex items-center justify-center py-4">
    <div class="w-full max-w-2xl">
        <div class="mb-6 text-center text-white italic uppercase font-black tracking-tighter text-3xl">
            Nová <span class="text-[#C44DFF]">Registrace</span>
        </div>
        
        <div class="bg-[#1A122E]/80 border border-white/10 rounded-2xl p-6 backdrop-blur-xl shadow-2xl">
            <form action="<?= BASE_URL ?>/index.php?url=auth/storeUser" method="post" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2 text-[10px] font-black text-[#C44DFF] uppercase tracking-widest border-b border-white/5 pb-1">Základní údaje</div>
                    
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Username *</label>
                        <input type="text" name="username" required class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none focus:border-[#C44DFF]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">E-mail *</label>
                        <input type="email" name="email" required class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none focus:border-[#C44DFF]">
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Heslo *</label>
                        <div class="relative">
                            <input type="password" id="reg_pass" name="password" required class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none focus:border-[#C44DFF]">
                            <button type="button" onclick="togglePass('reg_pass')" class="absolute right-3 top-1/2 -translate-y-1/2 text-white/30 hover:text-[#C44DFF]">👁️</button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Potvrzení *</label>
                        <div class="relative">
                            <input type="password" id="reg_pass_conf" name="password_confirm" required class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none focus:border-[#C44DFF]">
                            <button type="button" onclick="togglePass('reg_pass_conf')" class="absolute right-3 top-1/2 -translate-y-1/2 text-white/30 hover:text-[#C44DFF]">👁️</button>
                        </div>
                    </div>

                    <div class="md:col-span-2 text-[10px] font-black text-[#C44DFF] uppercase tracking-widest border-b border-white/5 pb-1 mt-2">Osobní údaje</div>
                    
                    <div><input type="text" name="first_name" placeholder="Jméno" class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none focus:border-[#C44DFF]"></div>
                    <div><input type="text" name="last_name" placeholder="Příjmení" class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none focus:border-[#C44DFF]"></div>
                    <div class="md:col-span-2"><input type="text" name="nickname" placeholder="Přezdívka (jak ti máme říkat?)" class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none focus:border-[#C44DFF]"></div>
                </div>

                <button type="submit" class="w-full bg-[#C44DFF] hover:bg-[#d170ff] text-black font-black py-3 rounded-lg uppercase tracking-widest transition-all mt-4">Vytvořit hráčský účet</button>
            </form>
        </div>
    </div>
</main>

<script>
function togglePass(id) {
    const x = document.getElementById(id);
    x.type = x.type === "password" ? "text" : "password";
}
</script>

<?php require_once '../app/views/layout/footer.php'; ?>