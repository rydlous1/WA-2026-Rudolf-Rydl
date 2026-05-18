<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 flex-grow flex items-center justify-center py-4">
    <div class="w-full max-w-md">
        <div class="mb-6 text-center">
            <h2 class="text-3xl font-black text-white italic uppercase tracking-tighter">Login <span class="text-[#C44DFF]">Area</span></h2>
        </div>
        
        <div class="bg-[#1A122E]/80 border border-white/10 rounded-2xl p-8 backdrop-blur-xl shadow-2xl">
            <form action="<?= BASE_URL ?>/index.php?url=auth/authenticate" method="post" class="space-y-5">
                <div>
                    <label class="block text-[10px] font-black text-[#C44DFF] uppercase tracking-widest mb-1">E-mail</label>
                    <input type="email" name="email" required autofocus
                           class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2.5 text-white outline-none focus:border-[#C44DFF] transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-[#C44DFF] uppercase tracking-widest mb-1">Heslo</label>
                    <div class="relative">
                        <input type="password" id="login_pass" name="password" required 
                               class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2.5 text-white outline-none focus:border-[#C44DFF] transition-all">
                        <button type="button" onclick="togglePass('login_pass')" class="absolute right-3 top-1/2 -translate-y-1/2 text-white/30 hover:text-[#C44DFF] transition-colors">👁️</button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#C44DFF] hover:bg-[#d170ff] text-black font-black py-3 rounded-lg uppercase tracking-widest shadow-lg transition-all active:scale-95">
                    Vstoupit do obchodu
                </button>
                
                <p class="text-center text-slate-500 text-xs pt-2">
                    Nováček? <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="text-[#C44DFF] hover:underline">Založ si účet</a>
                </p>
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