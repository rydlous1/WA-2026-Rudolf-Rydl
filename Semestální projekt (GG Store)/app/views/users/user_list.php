<?php
/** @var array $users */ 
require_once '../app/views/layout/header.php'; 
?>

<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-light tracking-widest text-slate-200 uppercase mb-8">
            Správa <span class="text-emerald-400 font-medium">Uživatelů</span>
        </h2>

        <div class="bg-slate-800/50 border border-slate-700 rounded-xl overflow-hidden shadow-2xl">
            <table class="w-full text-left text-slate-300">
                <thead class="bg-slate-900/50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Uživatel</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4 text-right">Akce</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    <?php foreach ($users as $user): ?>
                    <tr class="hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-mono text-xs italic text-slate-500">#<?= $user['id'] ?></td>
                        <td class="px-6 py-4">
                            <span class="text-white font-medium"><?= htmlspecialchars($user['username']) ?></span>
                            <div class="text-[10px] text-slate-500"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></div>
                        </td>
                        <td class="px-6 py-4 text-sm"><?= htmlspecialchars($user['email']) ?></td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-[10px] font-bold <?= $user['role'] === 'admin' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-blue-500/20 text-blue-400' ?>">
                                <?= strtoupper($user['role']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                <a href="<?= BASE_URL ?>/index.php?url=user/delete/<?= $user['id'] ?>" 
                                   onclick="return confirm('Opravdu smazat uživatele?')"
                                   class="text-rose-500 hover:text-rose-400 text-xs uppercase font-bold transition-colors">Smazat</a>
                            <?php else: ?>
                                <span class="text-slate-600 text-xs italic uppercase">To jsi ty</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>