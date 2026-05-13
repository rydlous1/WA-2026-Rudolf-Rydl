<?php
/** @var array $game */
/** @var array $comments */
require_once '../app/views/layout/header.php'; 
?>  

<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="max-w-5xl mx-auto">
        
        <!-- Horní navigace -->
        <div class="mb-6 flex justify-between items-center">
            <a href="<?= BASE_URL ?>/index.php" class="text-blue-400 hover:text-white transition-colors text-sm uppercase tracking-wider font-bold">&larr; Zpět na seznam</a>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="<?= BASE_URL ?>/index.php?url=game/edit/<?= $game['id'] ?>" class="bg-amber-600 hover:bg-amber-500 text-white px-6 py-2 rounded-lg text-sm font-bold shadow-lg transition-all uppercase">Upravit hru</a>
            <?php endif; ?>
        </div>

        <!-- Hlavní karta hry -->
        <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-8 shadow-2xl mb-10">
            <div class="flex flex-col md:flex-row gap-10">
                
                <!-- Levá strana: Obrázek -->
                <div class="w-full md:w-1/3">
                    <?php 
                        $imageValue = $game['images'] ?? '';
                        $cleanName = str_replace(['[', ']', '"', "'"], '', $imageValue);
                        $cleanName = trim($cleanName);
                    ?>
                    <?php if (!empty($cleanName)): ?>
                        <img src="<?= BASE_URL ?>/public/uploads/<?= htmlspecialchars($cleanName) ?>" 
                             alt="<?= htmlspecialchars($game['title'] ?? 'Hra') ?>" 
                             class="w-full h-auto rounded-xl shadow-xl border border-slate-600 object-cover"
                             onerror="this.src='<?= BASE_URL ?>/uploads/<?= $cleanName ?>';">
                    <?php else: ?>
                        <div class="w-full aspect-[3/4] bg-slate-900 rounded-xl flex items-center justify-center border border-slate-700">
                            <span class="text-slate-500 uppercase text-xs tracking-widest">Bez obrázku</span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pravá strana: Informace -->
                <div class="w-full md:w-2/3">
                    <h2 class="text-4xl font-black text-white mb-2"><?= htmlspecialchars($game['title'] ?? 'Neznámý název') ?></h2>
                    <p class="text-2xl text-emerald-400 font-bold mb-8">
                        <?= number_format($game['price'] ?? 0, 2, ',', ' ') ?> Kč
                    </p>

                    <!-- Mřížka s detaily -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10 border-t border-slate-700/50 pt-6">
                        <div>
                            <span class="block text-slate-500 uppercase tracking-tighter text-[10px] font-bold mb-1">Vývojář</span>
                            <span class="text-slate-200"><?= htmlspecialchars($game['developer'] ?? 'Neuvedeno') ?></span>
                        </div>
                        <div>
                            <span class="block text-slate-500 uppercase tracking-tighter text-[10px] font-bold mb-1">Žánr</span>
                            <span class="text-slate-200"><?= htmlspecialchars($game['genre'] ?? 'Neuvedeno') ?></span>
                        </div>
                        <div>
                            <span class="block text-slate-500 uppercase tracking-tighter text-[10px] font-bold mb-1">Platforma</span>
                            <span class="text-slate-200"><?= htmlspecialchars($game['platform'] ?? 'Neuvedeno') ?></span>
                        </div>
                        <div>
                            <span class="block text-slate-500 uppercase tracking-tighter text-[10px] font-bold mb-1">Rok vydání</span>
                            <span class="text-slate-200"><?= htmlspecialchars($game['release_year'] ?? '-') ?></span>
                        </div>
                    </div>

                    <!-- Popis -->
                    <div class="mb-10">
                        <span class="block text-slate-500 uppercase tracking-tighter text-[10px] font-bold mb-3">O hře</span>
                        <p class="text-slate-300 leading-relaxed text-sm">
                            <?= nl2br(htmlspecialchars($game['description'] ?? 'Popis hry není k dispozici.')) ?>
                        </p>
                    </div>

                    <?php if (!empty($game['link'])): ?>
                        <a href="<?= htmlspecialchars($game['link']) ?>" target="_blank" class="inline-block bg-blue-600 hover:bg-blue-500 text-white font-bold px-8 py-3 rounded-xl shadow-lg transition-all uppercase text-xs tracking-widest">Koupit hru</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sekce komentářů -->
        <div class="bg-slate-800/30 border border-slate-700 rounded-2xl p-8">
            <h3 class="text-xl font-bold text-white mb-8 uppercase tracking-widest text-center border-b border-slate-700 pb-4">Diskuze</h3>

            <!-- Formulář -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <form action="<?= BASE_URL ?>/index.php?url=game/addComment/<?= $game['id'] ?>" method="POST" class="mb-10">
                    <textarea name="content" rows="3" required placeholder="Napište svůj názor na hru..." class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 mb-4 transition-colors"></textarea>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-8 py-2 rounded-lg shadow-md transition-all text-xs uppercase">Odeslat</button>
                    </div>
                </form>
            <?php else: ?>
                <p class="text-center text-slate-500 text-sm mb-10 italic">Pro přidání komentáře se musíte <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-blue-400 hover:underline">přihlásit</a>.</p>
            <?php endif; ?>

            <!-- Seznam komentářů -->
            <div class="space-y-6">
                <?php if (empty($comments)): ?>
                    <p class="text-slate-500 italic text-center py-4">Zatím žádné komentáře.</p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="bg-slate-900/40 rounded-xl p-5 border border-slate-700/50 relative group">
                            <div class="flex justify-between items-center mb-3">
                                <span class="font-bold text-blue-400 text-sm"><?= htmlspecialchars($comment['username'] ?? 'Anonym') ?></span>
                                <span class="text-[10px] text-slate-500 font-mono"><?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?></span>
                            </div>
                            <p class="text-slate-300 text-sm"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                            
                            <?php if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] === $comment['user_id'] || ($_SESSION['role'] ?? '') === 'admin')): ?>
                                <div class="mt-4 flex justify-end">
                                    <a href="<?= BASE_URL ?>/index.php?url=game/deleteComment/<?= $comment['id'] ?>/<?= $game['id'] ?>" 
                                       class="text-[10px] text-rose-500 hover:text-rose-400 font-bold uppercase" 
                                       onclick="return confirm('Smazat komentář?');">Odstranit</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>