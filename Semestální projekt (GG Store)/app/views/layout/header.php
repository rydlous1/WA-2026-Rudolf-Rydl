<!DOCTYPE html>
<html lang="cs" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>GG STORE - Herní Portál</title>
    <style>
        .msg-fade { transition: opacity 1s ease-out, transform 0.6s ease-out; opacity: 1; }
        .msg-hidden { opacity: 0; transform: translateY(-20px); pointer-events: none; }
    </style>
</head>
<body class="bg-[#0F0A1A] text-slate-300 min-h-screen font-sans flex flex-col selection:bg-[#C44DFF] selection:text-white relative overflow-x-hidden">

    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-[#C44DFF] rounded-full mix-blend-screen filter blur-[150px] opacity-10 pointer-events-none z-0"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-[#8E24DD] rounded-full mix-blend-screen filter blur-[150px] opacity-10 pointer-events-none z-0"></div>

    <header class="bg-gradient-to-b from-[#1A122E]/90 to-[#0A0710]/90 backdrop-blur-md border-b border-[#2A1D47] shadow-[0_4px_30px_rgba(196,77,255,0.1)] relative z-50">
        <div class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-[#C44DFF] to-transparent opacity-50"></div>
        <div class="container mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center relative">
            
            <a href="<?= BASE_URL ?>/index.php" class="transition-transform hover:scale-105 active:scale-95 drop-shadow-[0_0_15px_rgba(196,77,255,0.3)]">
                <img src="<?= BASE_URL ?>/images/logo.png" alt="GG STORE" class="h-20 md:h-24 w-auto object-contain mix-blend-screen">
            </a>
            
            <nav class="mt-4 md:mt-0">
                <ul class="flex flex-wrap justify-center md:justify-end items-center gap-6">
                    <li><a href="<?= BASE_URL ?>/index.php" class="text-slate-300 hover:text-white transition-all font-medium tracking-wide">Nabídka her</a></li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <li><a href="<?= BASE_URL ?>/index.php?url=game/create" class="bg-gradient-to-r from-[#C44DFF] to-[#8E24DD] text-white px-5 py-2.5 rounded-lg transition-all shadow-lg font-bold uppercase text-xs">+ PŘIDAT HRU</a></li>
                            <li><a href="<?= BASE_URL ?>/index.php?url=user/index" class="text-[#a8b1ff] hover:text-white transition-all text-xs font-bold">SPRÁVA UŽIVATELŮ</a></li>
                        <?php endif; ?>
                        <li class="text-slate-400 text-sm italic">Ahoj, <span class="text-[#e2b3ff] font-semibold"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Hráči') ?></span></li>
                        <li><a href="<?= BASE_URL ?>/index.php?url=auth/logout" class="text-rose-400/80 hover:text-rose-400 transition-all text-xs font-bold uppercase tracking-widest">Odhlásit</a></li>
                    <?php else: ?>
                        <li><a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-slate-300 hover:text-white transition-all font-medium tracking-wide">Přihlásit</a></li>
                        <li><a href="<?= BASE_URL ?>/index.php?url=auth/register" class="bg-[#1A122E] hover:bg-[#2A1D47] text-white px-5 py-2.5 rounded-lg border border-[#C44DFF]/30 font-medium transition-all">Registrace</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container mx-auto px-6 pt-6 relative z-50">
        <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
            <div id="msg-container" class="space-y-3">
                <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                    <?php 
                        $styles = [
                            'success' => 'bg-[#0f2e1b]/95 border-[#10b981] text-[#34d399]',
                            'error'   => 'bg-[#3b1219]/95 border-[#f43f5e] text-[#fb7185]',
                            'notice'  => 'bg-[#2A1D47]/95 border-[#C44DFF] text-[#e2b3ff]',
                        ];
                        $style = $styles[$type] ?? 'bg-[#1A122E]/90 border-slate-500 text-slate-300';
                    ?>
                    <?php foreach ($messages as $message): ?>
                        <div class="msg-box msg-fade <?= $style ?> border-l-4 p-4 rounded-r-lg shadow-2xl backdrop-blur-md flex justify-between items-center">
                            <p class="font-medium text-sm italic"><?= htmlspecialchars($message) ?></p>
                            <button onclick="this.parentElement.remove()" class="ml-4 text-white/50 hover:text-white text-2xl leading-none font-bold transition-colors">&times;</button>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php unset($_SESSION['messages']); ?>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const messages = document.querySelectorAll('.msg-box');
                    setTimeout(() => {
                        messages.forEach(msg => {
                            msg.classList.add('msg-hidden');
                            setTimeout(() => { if (msg.parentNode) msg.remove(); }, 1000);
                        });
                    }, 5000);
                });
                function togglePassword(id) {
                    const input = document.getElementById(id);
                    if (input) input.type = input.type === "password" ? "text" : "password";
                }
            </script>
        <?php endif; ?>
    </div>